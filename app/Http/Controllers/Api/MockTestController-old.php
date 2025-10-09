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
use App\Models\UserSubscriptionDetails;
use App\Http\Resources\MockTestSectionResource;

class MockTestControllerOLD extends Controller
{

    // public function getQuestions(Request $request)
    // {
    //     try {

    //         $examId = $request->exam_id;

    //         if (!$examId) {
    //             return $this->responseWithError("exam_id is required.");
    //         }

    //         $allSections = MockTestSection::with(['mockTestQuestion', 'mockTestQuestionGroup', 'mockTestModule'])
    //         ->where('exam_id', $examId)
    //         ->get();


    //         // $allSections = MockTestSection::with(['mockTestQuestion','mockTestQuestionGroup','mockTestModule'])->get();

    //         foreach ($allSections as $section) {

    //             $data = MockTestSectionResource::make($section);

    //             if ($data) {
    //                 $sectionWiseQuestions[] = $data;
    //             }
    //         }

    //         return $this->responseWithSuccess($sectionWiseQuestions, "Questions Generated");
    //     } catch (Throwable $ex) {

    //         return $this->responseWithError("Something went wrong.",$ex->getMessage());
    //     }
    // }

    
    // public function evaluateAnswers(Request $request)
    // {
    //     try {
    //         $modulesScore = [
    //             'Reading' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //             'Listening' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //         ];
    
    //         $validatedData = $request->validate([
    //             '*.id' => 'required|integer|exists:mock_test_questions,id',
    //             '*.answer' => 'required|integer',
    //         ]);
    
    //         foreach ($validatedData as $questionPayload) {
    
    //             $question = MockTestQuestion::with('section.mockTestModule', 'mockTestQuestionOption')->find($questionPayload['id']);
    
    //             if (!$question) continue;
    
    //             $moduleName = $question->section->mockTestModule->name;
    
    //             $modulesScore[$moduleName]['answered']++;
    
    //             // Check answer
    //             $correctAnswer = $question->mockTestQuestionOption->correct_answer_index;
    //             if ($questionPayload['answer'] == $correctAnswer) {
    //                 $modulesScore[$moduleName]['correct']++;
    //             } else {
    //                 $modulesScore[$moduleName]['wrong']++;
    //             }
    //         }

    //         $mockTestRecord = MockTestRecords::create([
    //             'candidate_id' => Auth::guard('candidate')->id(),
    //             'question_set' => 1,
    //             'reading_answered' => $modulesScore['Reading']['answered'],
    //             'correct_reading_answer' => $modulesScore['Reading']['correct'],
    //             'wrong_reading_answer' => $modulesScore['Reading']['wrong'],
    //             'listening_answered' => $modulesScore['Listening']['answered'],
    //             'correct_listening_answer' => $modulesScore['Listening']['correct'],
    //             'wrong_listening_answer' => $modulesScore['Listening']['wrong'],
    //         ]);
    
    //         return $this->responseWithSuccess($mockTestRecord, "Mock test result responded.");
    //     }
    //     catch (Throwable $e) {
    //         Log::error('Mock test unexpected error', ['error' => $e->getMessage()]);
    //         return $this->responseWithError("Something went wrong.",$e->getMessage());
    //     }
    // }

    // public function getQuestions(Request $request)
    // {
    //     try {
    //         $examId = $request->exam_id;

    //         if (!$examId) {
    //             return $this->responseWithError("exam_id is required.");
    //         }

    //         // Filter by exam_id
    //         $allSections = MockTestSection::with(['mockTestQuestion', 'mockTestQuestionGroup', 'mockTestModule'])
    //             ->where('exam_id', $examId)
    //             ->get();

    //         dd($allSections);


    //         $sectionWiseQuestions = [];

    //         foreach ($allSections as $section) {
    //             $data = MockTestSectionResource::make($section);

    //             if ($data) {
    //                 $sectionWiseQuestions[] = $data;
    //             }
    //         }

    //         return $this->responseWithSuccess($sectionWiseQuestions, "Questions generated for Exam ID: {$examId}");
            
    //     } catch (Throwable $ex) {
    //         return $this->responseWithError("Something went wrong.", $ex->getMessage());
    //     }
    // }


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

            // Step 4: Fetch sections & questions
            // $allSections = MockTestSection::with([
            //         'mockTestQuestion',
            //         'mockTestQuestionGroup',
            //         'mockTestModule' => function ($query) use ($examId) {
            //             $query->where('exam_id', $examId);
            //         }
            //     ])
            //     ->get();
            $allSections = MockTestSection::with([
                'mockTestQuestion',
                'mockTestQuestionGroup',
                'mockTestModule'
            ])
            ->whereHas('mockTestModule', function ($query) use ($examId) {
                $query->where('exam_id', $examId);
            })
            ->get();

                // dd($allSections);

            $sectionWiseQuestions = [];

            foreach ($allSections as $section) {
                $data = MockTestSectionResource::make($section);

                if ($data) {
                    $sectionWiseQuestions[] = $data;
                }
            }

            return $this->responseWithSuccess($sectionWiseQuestions, "Questions generated for Exam ID: {$examId}");
            
        } catch (Throwable $ex) {
            return $this->responseWithError("Something went wrong.", $ex->getMessage());
        }
    }


    // public function evaluateAnswers(Request $request)
    // {
    //     try {
    //         $validatedData = $request->validate([
    //             'exam_id' => 'required|integer|exists:exams,id',
    //             '*.id' => 'required|integer|exists:mock_test_questions,id',
    //             '*.answer' => 'required|integer',
    //         ]);

    //         $examId = $request->exam_id;
    //         $candidateId = Auth::guard('candidate')->id();

    //         $modulesScore = [
    //             'Reading' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //             'Listening' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
    //         ];


            


    //         foreach ($validatedData as $key => $questionPayload) {
    //             // skip the exam_id field from validation array
    //             if ($key === 'exam_id') continue;

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

    //         // ✅ Create mock test record
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

    //         // ✅ Increment used_exam_attempt for the user's subscription
    //         $subscriptionId = UserSubscription::where('candidate_id', $candidateId)
    //             ->where('status', 'active')
    //             ->value('id'); // assuming one active subscription per user

    //         if ($subscriptionId) {
    //             $userSubscriptionDetail = UserSubscriptionDetails::where('user_subscription_id', $subscriptionId)
    //                 ->where('exam_id', $examId)
    //                 ->first();

    //             if ($userSubscriptionDetail) {
    //                 $userSubscriptionDetail->increment('used_exam_attempt');
    //             }
    //         }

    //         return $this->responseWithSuccess($mockTestRecord, "Mock test result recorded successfully.");
    //     }
    //     catch (Throwable $e) {
    //         Log::error('Mock test evaluation error', ['error' => $e->getMessage()]);
    //         return $this->responseWithError("Something went wrong.", $e->getMessage());
    //     }
    // }
    public function evaluateAnswers(Request $request)
    {
        try {
            $data = $request->all();

            // 🔹 Step 1: Validate exam_id
            $request->validate([
                'exam_id' => 'required|integer|exists:exams,id',
            ]);

            $examId = $data['exam_id'];
            $candidateId = Auth::guard('candidate')->id();

            $modulesScore = [
                'Reading' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
                'Listening' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
            ];

            // 🔹 Step 2: Loop over numeric keys only
            foreach ($data as $key => $questionPayload) {
                if ($key === 'exam_id') continue; // skip exam_id
                if (!isset($questionPayload['id']) || !isset($questionPayload['answer'])) continue;

                $question = MockTestQuestion::with(['section.mockTestModule', 'mockTestQuestionOption'])
                    ->find($questionPayload['id']);

                if (!$question) continue;

                $moduleName = $question->section->mockTestModule->name ?? null;
                if (!isset($modulesScore[$moduleName])) continue;

                $modulesScore[$moduleName]['answered']++;

                $correctAnswer = $question->mockTestQuestionOption->correct_answer_index;
                if ($questionPayload['answer'] == $correctAnswer) {
                    $modulesScore[$moduleName]['correct']++;
                } else {
                    $modulesScore[$moduleName]['wrong']++;
                }
            }

            // 🔹 Step 3: Create mock test record
            $mockTestRecord = MockTestRecords::create([
                'candidate_id'              => $candidateId,
                'exam_id'                   => $examId,
                'question_set'              => 1,
                'reading_answered'          => $modulesScore['Reading']['answered'],
                'correct_reading_answer'    => $modulesScore['Reading']['correct'],
                'wrong_reading_answer'      => $modulesScore['Reading']['wrong'],
                'listening_answered'        => $modulesScore['Listening']['answered'],
                'correct_listening_answer'  => $modulesScore['Listening']['correct'],
                'wrong_listening_answer'    => $modulesScore['Listening']['wrong'],
            ]);

            // 🔹 Step 4: Increment used_exam_attempt
            $subscriptionId = UserSubscription::where('candidate_id', $candidateId)
                ->where('status', 'confirmed')
                ->value('id'); // assuming one active subscription per user
            // dd($subscriptionId);
            if ($subscriptionId) {
                $userSubscriptionDetail = UserSubscriptionDetails::where('user_subscription_id', $subscriptionId)
                    ->where('exam_id', $examId)
                    ->first();
                // dd($userSubscriptionDetail);

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






    public function getTestResult(){
        $id = Auth::guard('candidate')->id();
        $testResults = MockTestRecords::where('candidate_id', $id)->get();
        // $testResults = MockTestResultResource::collection(MockTestRecords::where('candidate_id', $id)->get());//need to use later
       
        return $this->responseWithSuccess($testResults, "Mock test results fetched.");
    }
}
