@extends('master')

@section('contents')
<div class="container">
    <!-- Question Group Edit Form -->
    <form action="{{ route('mock-tests.question-group.update', $question->mockTestQuestionGroup->id) }}" class="mb-4" method="post" enctype="multipart/form-data">
        @csrf
        <div class="flex items-center justify-between p-[12px] rounded-t-lg bg-indigo-300">
            <h3 class="text-xl font-semibold text-black">Create Question Group</h3>
            <a href="{{ route('mock-tests.question.list') }}" 
               class="inline-flex items-center px-4 py-2 text-indigo-700 border border-indigo-700 rounded hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-indigo-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Questions
            </a>
        </div>

        <div class="p-8 rounded-b-lg bg-white border">
            <div class="grid grid-cols-4 gap-4">
                <!-- Section, Group By, Set No, Audio / Passage fields -->
                <div class="space-y-2">
                    <label for="sectionSelect" class="block font-semibold">Select Section</label>
                    <select id="sectionSelect" name="mock_test_section_id" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-full">
                        @foreach ($mockTestSections as $eachSection)
                            <option value="{{ $eachSection->id }}" {{ $eachSection->id == $question->mockTestQuestionGroup->mock_test_section_id ? 'selected' : '' }}>
                                {{ optional($eachSection->mockTestModule)->name }} - {{ $eachSection->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label for="groupBySelect" class="block font-semibold">Group By </label>
                    <select id="groupBySelect" name="group_type" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-full">
                        <option value="">Select Group</option>
                        <option value="passage" {{ old('group_type', $question->mockTestQuestionGroup->group_type) == 'passage' ? 'selected' : '' }}>Passage</option>
                        <option value="audio" {{ old('group_type', $question->mockTestQuestionGroup->group_type) == 'audio' ? 'selected' : '' }}>Audio</option>
                    </select>
                    <span class="text-xs text-gray-400"> (If multiple questions under a passage or audio) </span>
                </div>

                <div class="space-y-2">
                    <label class="block font-semibold">Set No</label>
                    <input 
                        type="number" 
                        name="set_no" 
                        min="0" 
                        max="10" 
                        value="{{ $question->mockTestQuestionGroup->set_no }}" 
                        class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-2/3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    >
                </div>
                

                <div class="space-y-2 col-span-4">
                    <div id="fileInputWrapper" class="space-y-2 hidden mt-3">
                        <label for="fileInput" class="block font-semibold">Audio file</label>
                        <input type="file" id="fileInput" name="audio-content" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-1/2" />
                        <p id="contentValue">{{ $question->mockTestQuestionGroup->content }}</p>
                    </div>

                    <div id="passageTextareaWrapper" class="space-y-2 hidden mt-3 w-full">
                        <label for="passageTextarea" class="block font-semibold">Write Passage</label>
                        <textarea id="passage_content" rows="5" name="content" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 tinymce" placeholder="Write passage ...">{{ old('content', $question->mockTestQuestionGroup->content) }}</textarea>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-4">Update Question group</button>
            <div id="questionsContainer"></div>
        </div>
    </form>

    <!-- Edit Question Form -->
    <form action="{{ route('mock-tests.question.update', $question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <h3 class="text-xl font-semibold p-[12px] rounded-t-lg text-black bg-indigo-300">Edit Question</h3>
        <div class="p-8 rounded-b-lg bg-white border mb-5">
            <div class="grid grid-cols-4 gap-4">
                <div class="space-y-2">
                    <label class="block font-semibold">Proficiency Level</label>
                    <select name="proficiency_level" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2">
                        <option value="N4" {{ $question->proficiency_level == 'N4' ? 'selected' : '' }}>N4</option>
                        <option value="N5" {{ $question->proficiency_level == 'N5' ? 'selected' : '' }}>N5</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-semibold">Question Type</label>
                    <select id="question_type" name="question_type" class="questionType bg-white drop-shadow-md text-sm border rounded px-3 py-2" onchange="toggleQuestionInput()">
                        <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="image" {{ $question->type == 'image' ? 'selected' : '' }}>Image</option>
                    </select>
                </div>

                <!-- Question Title -->
                <div class="space-y-2 col-span-3" id="question_text_div">
                    <label class="block font-semibold">Question</label>
                    <textarea name="question" placeholder="Enter question" id="question_title" class="questionInput bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-full tinymce">{{ $question->title }}</textarea>
                </div>

                <!-- Image Question Input -->
                <div class="space-y-2 col-span-3 hidden" id="question_image_div">
                    <label class="block font-semibold">Upload Image</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="question_image" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-3/4" />
                        <div id="image_preview" class="w-1/2">
                            @if (filter_var($question->title, FILTER_VALIDATE_URL) && preg_match('/\.(jpeg|jpg|png|gif)$/', $question->title))
                                <img src="{{ $question->title }}" alt="Question Image" class="max-w-full border h-auto">
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Options -->
            <div class="p-6 rounded-lg border bg-white mt-[30px] space-y-7">
                <h3 class="font-semibold rounded text-black">Edit Options (Choose the correct answer)</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach (json_decode($question->mockTestQuestionOption->values) as $optIndex => $optValue)
                    <div class="flex items-center gap-1">
                        <input type="radio" name="answer" value="{{ $optIndex }}" {{ $optIndex == $question->mockTestQuestionOption->correct_answer_index ? 'checked' : '' }} class="size-5">
                        <textarea id="option_{{ $optIndex }}" name="options[{{ $optIndex }}]" class="w-full border rounded px-3 py-2 tinymce">{{ $optValue }}</textarea>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
</div>

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {

    // ======== TinyMCE Initialization =========
    function initTiny(selector) {
        tinymce.init({
            selector,
            menubar: false,
            plugins: 'link image lists code',
            toolbar: 'undo redo | bold italic furigana | bullist numlist | link image | code',
            height: 150,
            extended_valid_elements: 'ruby,rt,rp',
            setup: function (editor) {
                editor.ui.registry.addButton('furigana', {
                    text: 'Furigana',
                    onAction: function () {
                        editor.windowManager.open({
                            title: 'Add Furigana',
                            body: {
                                type: 'panel',
                                items: [
                                    { type: 'input', name: 'kanji', label: 'Kanji' },
                                    { type: 'input', name: 'reading', label: 'Furigana' }
                                ]
                            },
                            buttons: [
                                { type: 'cancel', text: 'Close' },
                                { type: 'submit', text: 'Insert', primary: true }
                            ],
                            onSubmit: function (api) {
                                const data = api.getData();
                                editor.insertContent(`<ruby>${data.kanji}<rt>${data.reading}</rt></ruby>`);
                                api.close();
                            }
                        });
                    }
                });
            }
        });
    }

    // Initialize TinyMCE for all textareas with class "tinymce"
    initTiny('.tinymce');

    // ======== Question Type Toggle =========
    const questionTypeSelect = document.getElementById("question_type");
    const questionTextDiv = document.getElementById('question_text_div');
    const questionImageDiv = document.getElementById('question_image_div');

    function toggleQuestionInput() {
        if (questionTypeSelect.value === 'image') {
            questionTextDiv.classList.add('hidden');
            questionImageDiv.classList.remove('hidden');
        } else {
            questionTextDiv.classList.remove('hidden');
            questionImageDiv.classList.add('hidden');
        }
    }

    toggleQuestionInput(); // initial check on page load
    questionTypeSelect.addEventListener('change', toggleQuestionInput);

    // ======== Image Preview for Question =========
    const fileInput = document.querySelector('input[name="question_image"]');
    if (fileInput) {
        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = document.getElementById('image_preview');
                    previewDiv.innerHTML = `<img src="${e.target.result}" alt="Image Preview" class="max-w-full h-auto" />`;
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // ======== Passage / Audio Toggle =========
    const groupBySelect = document.getElementById("groupBySelect");
    const fileInputWrapper = document.getElementById("fileInputWrapper");
    const passageTextareaWrapper = document.getElementById("passageTextareaWrapper");
    const contentValue = document.getElementById("contentValue");

    function toggleGroupBy() {
        if (groupBySelect.value === "passage") {
            passageTextareaWrapper.style.display = "block";
            fileInputWrapper.style.display = "none";
            contentValue.style.display = "block";
        } else if (groupBySelect.value === "audio") {
            fileInputWrapper.style.display = "block";
            passageTextareaWrapper.style.display = "none";
        } else {
            passageTextareaWrapper.style.display = "none";
            fileInputWrapper.style.display = "none";
            contentValue.style.display = "block";
        }
    }

    groupBySelect.addEventListener("change", toggleGroupBy);
    toggleGroupBy(); // initial check on page load

});
</script>

@endsection
