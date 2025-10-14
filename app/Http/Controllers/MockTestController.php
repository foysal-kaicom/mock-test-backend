<?php

namespace App\Http\Controllers;

use Throwable;
use Carbon\Carbon;
use App\Models\Exam;
use App\Models\Candidate;
use Illuminate\Http\Request;
use App\Models\MockTestModule;
use App\Models\MockTestRecords;
use App\Models\MockTestSection;
use App\Models\MockTestQuestion;
use Illuminate\Support\Facades\DB;
use App\Services\FileStorageService;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\MockTestQuestionGroup;
use App\Models\MockTestRecordDetails;
use App\Models\MockTestQuestionOption;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreMockTestRequest;

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

        return view('mock-tests.sections.module_section_list', compact('modules'));
    }

    public function questionList(Request $request)
    {
        $query = MockTestQuestion::with('section', 'mockTestQuestionGroup');
    
        if ($request->has('section_id') && $request->section_id != 'all') {
            $query->where('mock_test_section_id', $request->section_id);
        }
    
        $questions = $query->paginate(10);
        
        $sections = MockTestSection::all();
    
        return view('mock-tests.question-list', compact('questions', 'sections'));
    }

    public function questionSetupForm()
    {

        $mockTestSections = MockTestSection::with('mockTestModule')->get();

        return view('mock-tests.question-setup', compact('mockTestSections'));
    }

    public function createSection()
    {
        $modules = MockTestModule::all();
        return view('mock-tests.sections.create-section', compact('modules'));
    }

    public function storeSection(Request $request)
    {
        $request->validate([
            'mock_test_module_id' => 'required|exists:mock_test_modules,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mock_test_sections,slug',
            'sample_question' => 'required|string',
        ]);

        MockTestSection::create([
            'mock_test_module_id' => $request->input('mock_test_module_id'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
            'sample_question' => $request->input('sample_question'),
        ]);

        Toastr::success("Section created successfully.");
        return redirect()->route('mock-tests.module-section.info');
    }

    public function editSection($id){
        $modules = MockTestModule::all();
        $section = MockTestSection::findOrFail($id);
        return view('mock-tests.sections.edit-section', compact('section','modules'));
    }

    public function updateSection(Request $request, $id)
    {
        $request->validate([
            'mock_test_module_id' => 'required|exists:mock_test_modules,id',
            'title' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:mock_test_sections,slug,'.$id,
            'sample_question' => 'required|string',
        ]);

        $section = MockTestSection::findOrFail($id);

        $section->update([
            'mock_test_module_id' => $request->input('mock_test_module_id'),
            'title' => $request->input('title'),
            'slug' => $request->input('slug'),
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
                'set_no' => $request->set_no,
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
                    // 'mock_test_section_id' => $request->section_id,
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
        $question = MockTestQuestion::with('mockTestQuestionOption', 'mockTestQuestionGroup')->findOrFail($id);
        $mockTestSections = MockTestSection::with('mockTestModule')->get();
    
        return view('mock-tests.edit-question', compact('question', 'mockTestSections'));
    }

    public function updateQuestionGroup(Request $request, $id)
    {
        
        $request->validate([
            'mock_test_section_id' => 'required|exists:mock_test_sections,id',
            'group_type' => 'nullable|in:passage,audio',
            'set_no' => 'required|integer',
            'content' => 'nullable|string',
            'audio-content' => 'nullable|file|mimes:mp3,ogg,wav',
        ]);
        
        $questionGroup = MockTestQuestionGroup::findOrFail($id);
    
        $questionGroup->mock_test_section_id = $request->mock_test_section_id;
        $questionGroup->group_type = $request->group_type;
    
        if ($request->hasFile('audio-content')) {
            $file = $request->file('audio-content');
            $fileUploadResponse = $this->fileStorageService->uploadPdfFileToCloud($file, 'mock-question','audio');

            if ($fileUploadResponse) {
                $questionGroup->content = $fileUploadResponse['public_path'];
            } else {
                return back()->with('error', 'File upload failed.');
            }
        } elseif ($request->group_type == 'passage' && $request->input('content')) {
            $questionGroup->content = $request->input('content');
        }

        $questionGroup->set_no = $request->set_no;
        $questionGroup->save();

        $questionGroup->mockTestQuestion()->update([
            'mock_test_section_id' => $request->mock_test_section_id
        ]);
    
        Toastr::success("Question group information updated Successfully.");
        return back();
    }
    

    public function updateQuestion(Request $request, $id)
    {
        $validated = $request->validate([
            'question' => 'nullable|max:255',
            'proficiency_level' => 'required|in:N4,N5',
            'question_type' => 'required|in:text,image',
            'answer' => 'required|integer|in:1,2,3,4',
            'options' => 'required|array|min:4|max:4',
            'options.*' => 'required|string|max:255',
            'question_image' => 'nullable|file|mimes:jpeg,jpg,png,gif|max:2048',
        ]);
    
        try {
            DB::beginTransaction();
    
            $question = MockTestQuestion::findOrFail($id);
    
            $question->title = $request->question;

            if ($request->question_type == 'image' && $request->hasFile('question_image')) {
                $imageUploadResponse = $this->fileStorageService->uploadImageToCloud($request->file('question_image'), 'questions');
                $question->title = strip_tags($imageUploadResponse['public_path']); // Store the image URL/path in the 'title' field
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

            if ($question->mockTestQuestionGroup) {
                $question->mockTestQuestionGroup->delete();
            }

            $question->delete();

            Toastr::success("Question deleted successfully.");
            return redirect()->back();
        } catch (\Throwable $ex) {
            Toastr::error("Failed to delete question: " . $ex->getMessage());
            return redirect()->back();
        }
    }

    public function getReportsData(Request $request)
    {
        $candidates = Candidate::all();
        $exams = Exam::all();

        // Check if this is an AJAX request from DataTables
        if ($request->ajax()) {
            $query = MockTestRecords::with(['candidate', 'exam']);

            if ($request->candidate_id) {
                $query->where('candidate_id', $request->candidate_id);
            }

            if ($request->exam_id) {
                $query->where('exam_id', $request->exam_id);
            }

            if ($request->date_range) {
                [$start, $end] = explode(' - ', $request->date_range);
                $query->whereBetween('created_at', [
                    Carbon::parse($start)->startOfDay(),
                    Carbon::parse($end)->endOfDay(),
                ]);
            }

            $records = $query->orderBy('created_at', 'desc')->get();

            return datatables()->of($records)
                ->addColumn('candidate', fn($row) => $row->candidate->full_name ?? '-')
                ->addColumn('exam', fn($row) => $row->exam->title ?? '-')
                ->addColumn('results', function($record) {
                    $details = MockTestRecordDetails::with('module')
                        ->where('mock_test_record_id', $record->id)
                        ->get();
                    $modules = [];
                    foreach ($details as $detail) {
                        $moduleName = $detail->module->name ?? 'Unknown';
                        if (!isset($modules[$moduleName])) $modules[$moduleName] = 0;
                        if ($detail->is_correct) $modules[$moduleName]++;
                    }
                    $html = '';
                    foreach ($modules as $module => $count) {
                        $html .= "<div><strong>{$module}:</strong> {$count}</div>";
                    }
                    return $html ?: '-';
                })
                ->addColumn('date', fn($row) => $row->created_at->format('j, M Y'))
                ->addColumn('question_set', fn($row) => $row->question_set)
                ->rawColumns(['results'])
                ->make(true);
        }

        return view('mock-tests.reports.list', compact('candidates', 'exams'));
    }


    

}
