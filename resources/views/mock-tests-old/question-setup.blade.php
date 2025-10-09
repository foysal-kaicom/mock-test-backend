@extends('master')

@section('contents')

<form action="{{route('mock-tests.question-setup.post')}}" class="px-10" method="post" enctype="multipart/form-data">
  @csrf
  <h3 class="text-xl font-semibold p-[12px] rounded-t-lg text-black bg-indigo-300">Create Question Group</h3>
  <div class="p-8 rounded-b-lg bg-white border">
    <div class="grid grid-cols-4 gap-4">
      <div class="space-y-2">
        <label for="sectionSelect" class="block font-semibold">Select Section</label>
        <select id="sectionSelect" name="section_id"
          class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
          @foreach($mockTestSections as $section)
          <option value="{{$section->id}}">{{optional($section->mockTestModule)->name}} - {{$section->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="space-y-2">
        <label for="questionTypeSelect" class="block font-semibold">Group Type</label>
        <select id="questionTypeSelect" name="group_type"
          class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
          <option value="single" selected>Single</option>
          <option value="multiple">Multiple</option>
        </select>
      </div>

      <div class="space-y-2">
        <label for="groupBySelect" class="block font-semibold">Group By </label>
        <select id="groupBySelect" name="group_by"
          class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
          <option value="">Select Group</option>
          <option value="passage">Passage</option>
          <option value="audio">Audio</option>
        </select>
        <span class="text-xs text-gray-400"> (If multiple questions under a passage or audio) </span>
      </div>

      <div id="questionQuantityWrapper" class="space-y-2 hidden">
        <label for="questionQuantity" class="block font-semibold">Question Quantity</label>
        <select id="questionQuantity" name="question_quantity"
          class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full">
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
        </select>
      </div>
    </div>

    <div class="flex gap-5">
      <div id="fileInputWrapper" class="space-y-2 hidden mt-3">
        <label for="fileInput" class="block font-semibold">Audio file</label>
        <input type="file" id="fileInput" name="passage_or_file"
          class="bg-white drop-shadow-md text-sm border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full" />
      </div>
      <div id="passageTextareaWrapper" class="space-y-2 hidden mt-3 w-full">
        <label for="passageTextarea" class="block font-semibold">Write Passage</label>
        <textarea id="content" rows="5" name="passage_or_file"
          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
          placeholder="Write passage ..."></textarea>
      </div>
    </div>
  </div>

  <!-- Container for questions -->
  <div id="questionsContainer"></div>

  <div class="flex justify-center">
    <button class="px-8 py-2 rounded-md bg-indigo-500 text-white font-semibold hover:opacity-90 duration-300 w-[250px]">
      Create question
    </button>
  </div>
</form>


<script>
  document.addEventListener("DOMContentLoaded", () => {
    const questionTypeSelect = document.getElementById("questionTypeSelect");
    const groupBySelect = document.getElementById("groupBySelect");
    const questionQuantityWrapper = document.getElementById("questionQuantityWrapper");
    const fileInputWrapper = document.getElementById("fileInputWrapper");
    const passageTextareaWrapper = document.getElementById("passageTextareaWrapper");
    const questionQuantity = document.getElementById("questionQuantity");
    const questionsContainer = document.getElementById("questionsContainer");

    function generateQuestions(qty) {
      questionsContainer.innerHTML = "";

      for (let i = 0; i < qty; i++) {
        const questionBlock = `
          <h3 class="text-xl font-semibold p-[12px] rounded-t-lg text-black bg-indigo-300 mt-5">
            Create Question ${i + 1}
          </h3>
          <div class="p-8 rounded-b-lg bg-white border mb-5">
            <div class="grid grid-cols-4 gap-4">
              <div class="space-y-2">
                <label class="block font-semibold">Proficiency Level</label>
                <select name="questions[${i}][proficiency_level]" class="bg-white drop-shadow-md text-sm border rounded px-3 py-2">
                  <option value="n4">N4</option>
                  <option value="n5">N5</option>
                </select>
              </div>

              <div class="space-y-2">
                <label class="block font-semibold">Each Question Type</label>
                <select name="questions[${i}][question_type]" class="questionType bg-white drop-shadow-md text-sm border rounded px-3 py-2">
                  <option value="text" selected>Text</option>
                  <option value="image">Image</option>
                </select>
              </div>

              <div class="space-y-2 col-span-2">
                <label class="block font-semibold">Question</label>
                <input name="questions[${i}][question]" type="text" placeholder="Enter question"
                  class="questionInput bg-white drop-shadow-md text-sm border rounded px-3 py-2 w-full" />
              </div>
            </div>

            <div class="p-6 rounded-lg border bg-white mt-[30px] space-y-7">
              <h3 class="font-semibold rounded text-black">Create Options (Choose the correct answer)</h3>
              <div class="grid grid-cols-2 gap-4">
                ${[1, 2, 3, 4].map(opt => `
                  <div class="flex items-center gap-1">
                    <input type="radio" name="questions[${i}][answer]" value="${opt}" class="size-5">
                    <input type="text" name="questions[${i}][options][${opt}]" placeholder="Option ${opt}"
                      class="bg-white text-sm border rounded px-3 py-2 w-full">
                  </div>`).join('')}
              </div>
            </div>
          </div>
        `;
        questionsContainer.insertAdjacentHTML("beforeend", questionBlock);
      }

      document.querySelectorAll(".questionType").forEach((selectEl) => {
        selectEl.addEventListener("change", function () {
          const inputEl = this.closest(".grid").querySelector(".questionInput");
          if (this.value === "image") {
            inputEl.type = "file";
            inputEl.placeholder = "";
          } else {
            inputEl.type = "text";
            inputEl.placeholder = "Enter question";
          }
        });
      });
    }

    questionTypeSelect.addEventListener("change", (e) => {
      if (e.target.value === "multiple") {
        questionQuantityWrapper.style.display = "block";
      } else {
        questionQuantityWrapper.style.display = "none";
        generateQuestions(1);
      }
    });

    groupBySelect.addEventListener("change", (e) => {
      if (e.target.value === "passage") {
        passageTextareaWrapper.style.display = "block";
        fileInputWrapper.style.display = "none";
      } else if (e.target.value === "audio") {
        fileInputWrapper.style.display = "block";
        passageTextareaWrapper.style.display = "none";
      } else {
        passageTextareaWrapper.style.display = "none";
        fileInputWrapper.style.display = "none";
      }
    });

    questionQuantity.addEventListener("change", (e) => {
      generateQuestions(parseInt(e.target.value));
    });

    generateQuestions(1);
  });
</script>

@endsection
