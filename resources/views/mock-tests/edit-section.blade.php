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
        Edit Section
    </div>

    <!-- Form -->
    <form action="{{ route('mock-tests.section.update', $section->id) }}" method="POST">
        @csrf

        <div class="row g-4">
            <!-- Section Title -->
            <div class="col-md-12">
                <label class="form-label fw-semibold">Section Title</label>
                <input
                    type="text"
                    name="title"
                    value="{{ old('title', $section->title) }}"
                    class="form-control form-control-lg shadow-sm rounded-2"
                    placeholder="e.g. Photo description" />
                @error('title')
                <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <!-- Sample Question (TinyMCE editor) -->
        
        <div class="mt-4">
            <label for="sample_question" class="form-label fw-semibold">Sample Question</label>
            <textarea
                id="content"
                name="sample_question"
                class="form-control form-control-lg shadow-sm rounded-2"
                placeholder="Write the sample question here...">{{ old('sample_question', $section->sample_question) }}</textarea>
            @error('sample_question')
            <small class="text-danger">{{ $message }}</small>
            @enderror

        </div>

        <!-- Submit Button -->
        <div class="pt-4">
            <button type="submit"
                class="w-full md:w-auto px-6 py-2 bg-indigo-500 text-white font-semibold rounded-xl shadow hover:bg-indigo-600 transition flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="size-4" fill="currentColor">
                    <path d="M18 21V13H6V21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H17L21 7V20C21 20.5523 20.5523 21 20 21H18ZM16 21H8V15H16V21Z"></path>
                </svg> Update Section
            </button>
        </div>
    </form>
</div>


@endsection


