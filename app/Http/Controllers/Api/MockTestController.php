<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MockTestSectionResource;
use App\Models\MockTestQuestion;
use App\Models\MockTestRecords;
use App\Models\MockTestSection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class MockTestController extends Controller
{

    public function getQuestions()
    {

        try {

            $allSections = MockTestSection::with(['mockTestQuestion','mockTestQuestionGroup','mockTestModule'])->get();

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

    public function evaluateAnswers(Request $request)
    {
        try {
            $modulesScore = [
                'Reading' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
                'Listening' => ['answered' => 0, 'correct' => 0, 'wrong' => 0],
            ];
    
            $validatedData = $request->validate([
                '*.id' => 'required|integer|exists:mock_test_questions,id',
                '*.answer' => 'required|integer',
            ]);
    
            foreach ($validatedData as $questionPayload) {
    
                $question = MockTestQuestion::with('section.mockTestModule', 'mockTestQuestionOption')->find($questionPayload['id']);
    
                if (!$question) continue;
    
                $moduleName = $question->section->mockTestModule->name;
    
                $modulesScore[$moduleName]['answered']++;
    
                // Check answer
                $correctAnswer = $question->mockTestQuestionOption->correct_answer_index;
                if ($questionPayload['answer'] == $correctAnswer) {
                    $modulesScore[$moduleName]['correct']++;
                } else {
                    $modulesScore[$moduleName]['wrong']++;
                }
            }

            $mockTestRecord = MockTestRecords::create([
                'candidate_id' => Auth::guard('candidate')->id(),
                'question_set' => 1,
                'reading_answered' => $modulesScore['Reading']['answered'],
                'correct_reading_answer' => $modulesScore['Reading']['correct'],
                'wrong_reading_answer' => $modulesScore['Reading']['wrong'],
                'listening_answered' => $modulesScore['Listening']['answered'],
                'correct_listening_answer' => $modulesScore['Listening']['correct'],
                'wrong_listening_answer' => $modulesScore['Listening']['wrong'],
            ]);
    
            return $this->responseWithSuccess($mockTestRecord, "Mock test result responded.");
        }
        catch (Throwable $e) {
            Log::error('Mock test unexpected error', ['error' => $e->getMessage()]);
            return $this->responseWithError("Something went wrong.",$e->getMessage());
        }
    }

    public function getTestResult(){
        $id = Auth::guard('candidate')->id();
        $testResults = MockTestRecords::where('candidate_id', $id)->get();
        // $testResults = MockTestResultResource::collection(MockTestRecords::where('candidate_id', $id)->get());//need to use later
       
        return $this->responseWithSuccess($testResults, "Mock test results fetched.");
    }
}
