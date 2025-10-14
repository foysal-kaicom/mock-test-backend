@extends('master')

@section('contents')

<div class="bg-white rounded-3 shadow-sm border p-6">
    <!-- Header -->
    <div class="text-2xl font-bold text-gray-800 border-b pb-3 mb-5 flex items-center gap-2">
        <p class="p-2 rounded-full bg-indigo-500 text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M19.7134 9.12811L19.4668 9.69379C19.2864 10.1079 18.7136 10.1079 18.5331 9.69379L18.2866 9.12811C17.8471 8.11947 17.0555 7.31641 16.0677 6.87708L15.308 6.53922C14.8973 6.35653 14.8973 5.75881 15.308 5.57612L16.0252 5.25714C17.0384 4.80651 17.8442 3.97373 18.2761 2.93083L18.5293 2.31953C18.7058 1.89349 19.2942 1.89349 19.4706 2.31953L19.7238 2.93083C20.1558 3.97373 20.9616 4.80651 21.9748 5.25714L22.6919 5.57612C23.1027 5.75881 23.1027 6.35653 22.6919 6.53922L21.9323 6.87708C20.9445 7.31641 20.1529 8.11947 19.7134 9.12811ZM6 5C4.89543 5 4 5.89543 4 7V17C4 18.1046 4.89543 19 6 19H18C19.1046 19 20 18.1046 20 17V12H22V17C22 19.2091 20.2091 21 18 21H6C3.79086 21 2 19.2091 2 17V7C2 4.79086 3.79086 3 6 3H13V5H6Z"></path>
            </svg>
        </p>
        Create Section
    </div>

    <!-- Form -->
    <form action="{{ route('mock-tests.section.store') }}" method="POST">
        @csrf
        <div class="row g-4">
            <!-- Mock Test Selection -->
            <div class="col-md-12">
                <label class="form-label fw-semibold">Select Mock Test Modules</label>
                <select name="mock_test_module_id" class="form-select form-select-lg shadow-sm rounded-2" required>
                    <option value="" disabled selected>Select a Modules</option>
                    @foreach($modules as $mockTestModule)
                        <option value="{{ $mockTestModule->id }}" {{ old('mock_test_module_id') == $mockTestModule->id ? 'selected' : '' }}>
                            {{ $mockTestModule->name }}
                        </option>
                    @endforeach
                </select>
                @error('mock_test_module_id')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Section Title -->
        <div class="row g-4 pt-4">
            <div class="col-md-12">
                <label class="form-label fw-semibold">Section Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title') }}"
                    class="form-control form-control-lg shadow-sm rounded-2"
                    placeholder="e.g. Photo description" />
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Section Slug -->
        <div class="row g-4 pt-4">
            <div class="col-md-12">
                <label class="form-label fw-semibold">Section Slug</label>
                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    class="form-control form-control-lg shadow-sm rounded-2"
                    placeholder="e.g. photo-description" />
                @error('slug')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>
        
        <!-- Sample Question (TinyMCE editor) -->
        <div class="mt-4">
            <label for="sample_question" class="form-label fw-semibold">Sample Question</label>
            <textarea
                id="editor"
                name="sample_question"
                class="form-control form-control-lg shadow-sm rounded-2"
                placeholder="Write the sample question here...">{{ old('sample_question') }}</textarea>
            @error('sample_question')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full md:w-auto px-6 py-2 bg-indigo-500 text-white font-semibold rounded-xl shadow hover:bg-indigo-600 transition flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12H20C20 16.41 16.41 20 12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4V2ZM13 7V11H17V13H13V17H11V13H7V11H11V7H13Z"></path>
                </svg> Create Section
            </button>
        </div>
    </form>
</div>

@endsection

@push('js')
<script type="text/javascript">
tinymce.init({
  selector: '#editor',
  menubar: false,
  toolbar: 'bold italic furigana code',
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
</script>
<script>
// Add any additional JavaScript if needed for slug generation based on title
document.querySelector('input[name="title"]').addEventListener('input', function() {
    const slugInput = document.querySelector('input[name="slug"]');
    const slug = this.value.toLowerCase().replace(/[^a-z0-9]+/gi, '-').replace(/^-+|-+$/g, '');
    slugInput.value = slug;
});

</script>
@endpush
