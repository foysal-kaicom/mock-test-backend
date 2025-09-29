<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMockTestRequest;
use App\Models\MockTestModule;
use App\Models\MockTestQuestion;
use App\Models\MockTestQuestionGroup;
use App\Models\MockTestQuestionOption;
use App\Models\MockTestSection;
use App\Services\FileStorageService;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Throwable;

class MockTestController extends Controller
{
   
    public $fileStorageService;
    public function __construct(FileStorageService $fileStorageService)
    {
        $this->fileStorageService = $fileStorageService;
    }

    public function index()
    {
        $modules = MockTestModule::with('sections')->get();

        return view('mock-tests.module_section_list', compact('modules'));
    }

    public function questionList()
    {

        // $modules = MockTestModule::with(['sections','sections.mockTestQuestionGroup','sections.mockTestQuestionGroup.mockTestQuestion','sections.mockTestQuestionGroup.mockTestQuestion.mockTestQuestionOption'])->get();
        $questions = MockTestQuestion::with('section', 'mockTestQuestionGroup')->paginate(10);

        return view('mock-tests.question-list', compact('questions'));
    }


    public function questionSetupForm()
    {

        $mockTestSections = MockTestSection::with('mockTestModule')->get();

        return view('mock-tests.question-setup', compact('mockTestSections'));
    }

    public function editSection($id){
        $section = MockTestSection::findOrFail($id);
        return view('mock-tests.edit-section', compact('section'));
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sample_question' => 'required|string',
        ]);

        $section = MockTestSection::findOrFail($id);

        $section->update([
            'title' => $request->input('title'),
            'sample_question' => $request->input('sample_question'),
        ]);

        Toastr::success("Question updated Successfully.");
        return redirect()->route('mock-tests.module-section.info');
    }


    public function questionSetup(StoreMockTestRequest $request)
    {
               
        if ($request->group_by == 'audio') {
            //upload audio file to bucket and get the path

            if ($request->hasFile('passage_or_file')) {
                $file = $request->file('passage_or_file');

                $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($file, 'audio');
                $content = $imageUploadResponse['public_path'];
            }
        } else {
            $content = $request->passage_or_file;
        }

        try {

            DB::beginTransaction();

            //insert data into question group
            $questionGroup=MockTestQuestionGroup::create([
                'mock_test_section_id' => $request->section_id,
                'type' => $request->group_type, //single or multiple
                'group_type' => $request->group_by, //i.e: group by : passages/audio
                'content' => $content,
                'question_quantity' => $request->question_quantity,
            ]);

            //store question into mockTestQuestion table
            foreach ($request->questions as $q) {

                // Handle question title
                $textOrImage = $q['question'];
                if ($q['question_type'] === 'image' && $textOrImage instanceof \Illuminate\Http\UploadedFile) {
                
                    $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($textOrImage, 'questons');
                    $textOrImage = $imageUploadResponse['public_path'];
                     
                }

                // Create Question
                $question = MockTestQuestion::create([
                    'title' => $textOrImage,
                    'mock_test_section_id' => $request->section_id,
                    'proficiency_level' => strtoupper($q['proficiency_level']),
                    'mock_test_section_id' => $request->section_id,
                    'mock_test_question_group_id' => $questionGroup->id ?? null,
                    'type' => $q['question_type'],
                ]);

                // Create Options
                MockTestQuestionOption::create([
                    'mock_test_question_id' => $question->id,
                    'values' => json_encode($q['options']),
                    'correct_answer_index' => (string) $q['answer'],
                ]);
            }

            DB::commit();
            Toastr::success("Question Created Successfully.");
            return redirect()->route('mock-tests.question.list');
        } catch (Throwable $ex) {
            DB::rollBack();
            toastr()->error($ex->getMessage());
            return redirect()->back()->withInput();

        }
    }

    public function editQuestion($id)
    {
        $question = MockTestQuestion::with('mockTestQuestionOption')->findOrFail($id);
    
        return view('mock-tests.edit-question', compact('question'));
    }
    

    public function updateQuestion(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'proficiency_level' => 'required|in:n4,n5',
            'question_type' => 'required|in:text,image',
            'answer' => 'required|integer|in:1,2,3,4',
            'options' => 'required|array|min:4|max:4',
            'options.*' => 'required|string|max:255',
            'question_image' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
    
        try {
            DB::beginTransaction();
    
            $question = MockTestQuestion::findOrFail($id);
    
            $question->title = $request->question;

            if ($request->question_type == 'image' && $request->hasFile('question_image')) {
                $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($request->file('question_image'), 'questions');
                $question->title = $imageUploadResponse['public_path']; // Store the image URL/path in the 'title' field
            }
    
            $question->proficiency_level = strtoupper($request->proficiency_level);
            $question->type = $request->question_type;
            $question->save();

            $options = $request->options;
            $correctAnswerIndex = $request->answer;

            $questionOption = $question->mockTestQuestionOption;
            $questionOption->values = json_encode($options);
            $questionOption->correct_answer_index = $correctAnswerIndex;
            $questionOption->save();
    
            DB::commit();
    
            Toastr::success("Question Updated Successfully.");
            return redirect()->route('mock-tests.question.list');
        } catch (Throwable $ex) {
            DB::rollBack();
            toastr()->error($ex->getMessage());
            return redirect()->back()->withInput();
        }
    }
    
    public function deleteQuestion($id)
    {
        try {
            $question = MockTestQuestion::findOrFail($id);

            if ($question->mockTestQuestionOption) {
                $question->mockTestQuestionOption->delete();
            }

            $question->delete();

            Toastr::success("Question deleted successfully.");
            return redirect()->back();
        } catch (\Throwable $ex) {
            Toastr::error("Failed to delete question: " . $ex->getMessage());
            return redirect()->back();
        }
    }

    

}
