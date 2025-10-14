<?php

namespace App\Http\Controllers\Api;

use Throwable;
use Illuminate\Http\Request;

use App\Models\MockTestRecords;
use App\Models\MockTestSection;
use App\Models\MockTestQuestion;
use App\Models\UserSubscription;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\MockTestRecordDetails;
use App\Models\UserSubscriptionDetails;
use App\Http\Resources\MockTestSectionResource;
use App\Http\Resources\UserSubscriptionResource;

class MockTestController extends Controller
{

    public function getQuestions(Request $request)
    {

        try {
            $examId = $request->exam_id;

            if (!$examId) {
                return $this->responseWithError("exam_id is required.");
            }

            $candidate = auth('candidate')->user();

            // Step 1: Get all active subscriptions for this candidate
            $activeSubscriptions = UserSubscription::where('candidate_id', $candidate->id)
                ->where('status', 'confirmed')
                ->where('payment_status', 'success')
                ->pluck('id');

            if ($activeSubscriptions->isEmpty()) {
                return $this->responseWithError("You do not have an active subscription for any exam.");
            }

            // Step 2: Check if this exam exists in any active subscription
            $subscriptionDetails = UserSubscriptionDetails::whereIn('user_subscription_id', $activeSubscriptions)
                ->where('exam_id', $examId)
                ->get();

            if ($subscriptionDetails->isEmpty()) {
                return $this->responseWithError("This exam is not included in your active subscriptions.");
            }

            // Step 3: Verify remaining attempts
            $hasRemaining = $subscriptionDetails->contains(function ($detail) {
                return $detail->used_exam_attempt < $detail->max_exam_attempt;
            });

            if (!$hasRemaining) {
                return $this->responseWithError("You have reached the maximum attempt limit for this exam.");
            }
            

            // $allSections = MockTestSection::with(['mockTestQuestion','mockTestQuestionGroup','mockTestModule'])->get();

            $allSections = MockTestSection::with([
                'mockTestQuestion',
                'mockTestQuestionGroup',
                'mockTestModule'
            ])
            ->whereHas('mockTestModule', function ($query) use ($examId) {
                $query->where('exam_id', $examId);
            })
            ->get();

            $sectionWiseQuestions = [];

            foreach ($allSections as $section) {

                $data = MockTestSectionResource::make($section);

                if ($data) {
                    $sectionWiseQuestions[] = $data;
                }
            }

            return $this->responseWithSuccess($sectionWiseQuestions, "Questions Generated");

        } catch (Throwable $ex) {

            return $this->responseWithError("Something went wrong.",$ex->getMessage());
        }
    }

    // public function evaluateAnswers(Request $request)
    // {
    //     try {
    //         $data = $request->all();

    //         // 🔹 Step 1: Validate exam_id
    //         $request->validate([
    //             'exam_id' => 'required|integer|exists:exams,id',
    //         ]);

    //         $examId = $data['exam_id'];
    //         $candidateId = Auth::guard('candidate')->id();

    //         $modulesScore = [
    //             'Reading' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //             'Listening' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //         ];

    //         // 🔹 Step 2: Loop over numeric keys only
    //         foreach ($data as $key => $questionPayload) {
    //             if ($key === 'exam_id') continue; // skip exam_id
    //             if (!isset($questionPayload['id']) || !isset($questionPayload['answer'])) continue;

    //             $question = MockTestQuestion::with(['section.mockTestModule', 'mockTestQuestionOption'])
    //                 ->find($questionPayload['id']);

    //             if (!$question) continue;

    //             $moduleName = $question->section->mockTestModule->name ?? null;
    //             if (!isset($modulesScore[$moduleName])) continue;

    //             $modulesScore[$moduleName]['answered']++;

    //             $correctAnswer = $question->mockTestQuestionOption->correct_answer_index;
    //             if ($questionPayload['answer'] == $correctAnswer) {
    //                 $modulesScore[$moduleName]['correct']++;
    //             } else {
    //                 $modulesScore[$moduleName]['wrong']++;
    //             }
    //         }

    //         // 🔹 Step 3: Create mock test record
    //         $mockTestRecord = MockTestRecords::create([
    //             'candidate_id'              => $candidateId,
    //             'exam_id'                   => $examId,
    //             'question_set'              => 1,
    //             'reading_answered'          => $modulesScore['Reading']['answered'],
    //             'correct_reading_answer'    => $modulesScore['Reading']['correct'],
    //             'wrong_reading_answer'      => $modulesScore['Reading']['wrong'],
    //             'listening_answered'        => $modulesScore['Listening']['answered'],
    //             'correct_listening_answer'  => $modulesScore['Listening']['correct'],
    //             'wrong_listening_answer'    => $modulesScore['Listening']['wrong'],
    //         ]);

    //         // 🔹 Step 4: Increment used_exam_attempt
    //         $subscriptionId = UserSubscription::where('candidate_id', $candidateId)
    //             ->where('status', 'confirmed')
    //             ->value('id'); // assuming one active subscription per user
    //         // dd($subscriptionId);
    //         if ($subscriptionId) {
    //             $userSubscriptionDetail = UserSubscriptionDetails::where('user_subscription_id', $subscriptionId)
    //                 ->where('exam_id', $examId)
    //                 ->first();
    //             // dd($userSubscriptionDetail);

    //             if ($userSubscriptionDetail) {
    //                 $userSubscriptionDetail->increment('used_exam_attempt');
    //             }
    //         }

    //         return $this->responseWithSuccess($mockTestRecord, "Mock test result recorded successfully.");
    //     } catch (Throwable $e) {
    //         Log::error('Mock test evaluation error', ['error' => $e->getMessage()]);
    //         return $this->responseWithError("Something went wrong.", $e->getMessage());
    //     }
    // }

    public function evaluateAnswers(Request $request)
    {
        try {
            $data = $request->all();

            $request->validate([
                'exam_id' => 'required|integer|exists:exams,id',
            ]);

            $examId = $data['exam_id'];
            $candidateId = Auth::guard('candidate')->id();
            $questionSet = 1;

            $totalMarks = 0;
            $details = [];

            foreach ($data as $key => $questionPayload) {
                if ($key === 'exam_id') continue;
                if (!isset($questionPayload['id']) || !isset($questionPayload['answer'])) continue;

                $question = MockTestQuestion::with(['section.mockTestModule', 'mockTestQuestionOption'])
                    ->find($questionPayload['id']);

                if (!$question) continue;

                $correctAnswer = $question->mockTestQuestionOption->correct_answer_index;
                $isCorrect = ($questionPayload['answer'] == $correctAnswer) ? 1 : 0;

                if ($isCorrect) {
                    $totalMarks++;
                }

                $details[] = [
                    'mock_test_question_id' => $question->id,
                    'mock_test_question_option_id' => $questionPayload['answer'] ?? null,
                    'mock_test_section_id' => $question->section_id ?? null,
                    'mock_test_module_id' => $question->section->mock_test_module_id ?? null,
                    'is_correct' => $isCorrect,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // ✅ Step 3: Create record summary
            $mockTestRecord = MockTestRecords::create([
                'candidate_id' => $candidateId,
                'exam_id' => $examId,
                'question_set' => $questionSet,
                'total_marks' => $totalMarks,
            ]);

            // ✅ Step 4: Bulk insert details
            foreach ($details as &$d) {
                $d['mock_test_record_id'] = $mockTestRecord->id;
            }
            MockTestRecordDetails::insert($details);

            // ✅ Step 5: Increment used_exam_attempt
            $subscriptionId = UserSubscription::where('candidate_id', $candidateId)
                ->where('status', 'confirmed')
                ->value('id');

            if ($subscriptionId) {
                $userSubscriptionDetail = UserSubscriptionDetails::where('user_subscription_id', $subscriptionId)
                    ->where('exam_id', $examId)
                    ->first();

                if ($userSubscriptionDetail) {
                    $userSubscriptionDetail->increment('used_exam_attempt');
                }
            }

            return $this->responseWithSuccess($mockTestRecord, "Mock test result recorded successfully.");
        } catch (Throwable $e) {
            Log::error('Mock test evaluation error', ['error' => $e->getMessage()]);
            return $this->responseWithError("Something went wrong.", $e->getMessage());
        }
    }






    public function getTestResult()
    {
        try {
            $candidateId = Auth::guard('candidate')->id();

            // Load candidate name and related details with eager loading
            $testResults = MockTestRecords::with(['candidate:id,first_name', 'details.module:id,name'])
                ->where('candidate_id', $candidateId)
                ->get()
                ->map(function ($record) {
                    // Group details by module and count correct answers
                    $moduleScores = $record->details
                        ->groupBy(fn($d) => $d->module->name ?? 'Unknown')
                        ->map(function ($group) {
                            return $group->where('is_correct', 1)->count();
                        });

                    return [
                        'candidate_name' => $record->candidate->first_name ?? 'N/A',
                        'exam_id'        => $record->exam_id,
                        'question_set'   => $record->question_set,
                        'total_marks'    => $record->total_marks,
                        'module_scores'  => $moduleScores,
                        'created_at'     => $record->created_at->format('Y-m-d H:i:s'),
                    ];
                });

            return $this->responseWithSuccess($testResults, "Mock test results fetched successfully.");
        } catch (Throwable $e) {
            Log::error('Get test result error', ['error' => $e->getMessage()]);
            return $this->responseWithError("Something went wrong.", $e->getMessage());
        }
    }


    public function activeUserSubscriptionDetails(){
        $candidateId = Auth::guard('candidate')->id();
        $activeSubscriptions = UserSubscription::where('candidate_id', $candidateId)
            ->where('status', 'confirmed')
            ->where('payment_status', 'success')
            ->with('package')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($activeSubscriptions->isEmpty()) {
            return $this->responseWithError("You do not have an active subscription.");
        }

        // Use a resource for formatting the subscription details
        return $this->responseWithSuccess(
            UserSubscriptionResource::collection($activeSubscriptions),
            "Active subscription details fetched."
        );
    }
}
