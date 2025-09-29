@extends('master')

@section('contents')
<div class="container">
    <h3 class="text-xl font-semibold p-[12px] rounded-t-lg text-black bg-indigo-300">
        Edit Question
    </h3>
    <form action="{{ route('mock-tests.question.update', $question->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="p-8 rounded-b-lg bg-white border mb-5">
            <div class="grid grid-cols-4 gap-4">
                <div class="space-y-2">
                    <label class="block font-semibold">Proficiency Level</label>
                    <select name="proficiency_level" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2">
                        <option value="n4" {{ $question->proficiency_level == 'n4' ? 'selected' : '' }}>N4</option>
                        <option value="n5" {{ $question->proficiency_level == 'n5' ? 'selected' : '' }}>N5</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block font-semibold">Question Type</label>
                    <select id="question_type" name="question_type" class="questionType bg-white drop-shadow-md text-sm border rounded px-3 py-2" onchange="toggleQuestionInput()">
                        <option value="text" {{ $question->type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="image" {{ $question->type == 'image' ? 'selected' : '' }}>Image</option>
                    </select>
                </div>

                <!-- Text Question Input -->
                <div class="space-y-2 col-span-3" id="question_text_div">
                    <label class="block font-semibold">Question</label>
                    <textarea name="question" placeholder="Enter question"
                        id="content" class="questionInput bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-full h-24">{{ $question->title }}</textarea>
                </div>


                <!-- Image Question Input -->
                <div class="space-y-2 col-span-3 hidden" id="question_image_div">
                    <label class="block font-semibold">Upload Image</label>
                    <div class="flex items-center gap-4">
                        <input type="file" name="question_image" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-3/4" />
                        <div id="image_preview" class="w-1/2">
                            @if (filter_var($question->title, FILTER_VALIDATE_URL) && preg_match('/\.(jpeg|jpg|png|gif)$/', $question->title))
                                <!-- If it's a valid image URL, show preview -->
                                <img src="{{ $question->title }}" alt="Question Image" class="max-w-full border h-auto">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="p-6 rounded-lg border bg-white mt-[30px] space-y-7">
                <h3 class="font-semibold rounded text-black">Edit Options (Choose the correct answer)</h3>
                <div class="grid grid-cols-2 gap-4">
                    @foreach (json_decode($question->mockTestQuestionOption->values) as $optIndex => $optValue)
                    <div class="flex items-center gap-1">
                        <input type="radio" name="answer" value="{{ $optIndex }}" 
                            {{ $optIndex == $question->mockTestQuestionOption->correct_answer_index ? 'checked' : '' }} class="size-5">
                        <input type="text" name="options[{{ $optIndex }}]" value="{{ $optValue }}"
                            placeholder="Option {{ $optIndex + 1 }}" class="bg-white text-sm border rounded px-3 py-2 w-full">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Question</button>
    </form>
</div>

<script>
    // Function to toggle visibility of question input fields based on selected question type
    function toggleQuestionInput() {
        const questionType = document.getElementById('question_type').value;
        const questionTextDiv = document.getElementById('question_text_div');
        const questionImageDiv = document.getElementById('question_image_div');
        
        // Check if image is selected
        if (questionType === 'image') {
            questionTextDiv.classList.add('hidden');
            questionImageDiv.classList.remove('hidden');
        } else {
            questionTextDiv.classList.remove('hidden');
            questionImageDiv.classList.add('hidden');
        }
    }

    // If page loads and the question type is set to 'image', show the image input field
    window.onload = function() {
        toggleQuestionInput();
    };

    // Display image preview when file is selected
    document.querySelector('input[name="question_image"]').addEventListener('change', function(event) {
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
</script>

@endsection
