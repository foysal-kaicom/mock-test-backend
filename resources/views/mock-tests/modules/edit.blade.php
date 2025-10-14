@extends('master')

@section('contents')

<div class="card shadow-lg border-0 rounded-3">
    <!-- Header -->
    <div class="card-header py-3 rounded-top bg-indigo-300">
        <h3 class="fs-5 fw-semibold mb-0 flex items-center gap-2">
            Edit Mock Test Module
        </h3>
    </div>

    <!-- Form -->
    <form action="{{ route('mock-test-modules.update', $mockTestModule) }}" method="POST" class="p-4">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Form Fields -->
            <div class="col-md-12">
                <div class="row g-3">

                    <!-- Exam Selection -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Select Exam</label>
                        <select name="exam_id" class="form-control form-control-lg shadow-sm rounded-2">
                            <option value="">-- Select Exam --</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}" {{ $mockTestModule->exam_id == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_id') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Module Name</label>
                        <input type="text" name="name" value="{{ old('name', $mockTestModule->name) }}" class="form-control form-control-lg shadow-sm rounded-2" placeholder="Enter module name" />
                        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug</label>
                        <input type="text" name="slug" value="{{ old('slug', $mockTestModule->slug) }}" class="form-control form-control-lg shadow-sm rounded-2" placeholder="Enter slug" />
                        @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status</label>
                        <select name="status" class="form-control form-control-lg shadow-sm rounded-2">
                            <option value="active" {{ $mockTestModule->status == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="disabled" {{ $mockTestModule->status == 'disabled' ? 'selected' : '' }}>Disabled</option>
                        </select>
                        @error('status') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                </div>
            </div>
        </div>

        <div class="pt-4 flex justify-end">
            <button type="submit"
                class="w-full md:w-auto px-6 py-2 bg-indigo-500 text-white font-semibold rounded-xl shadow hover:bg-indigo-600 transition flex items-center gap-1">
                Update Module
            </button>
        </div>
    </form>
</div>

<script>
//create slug from name
    document.querySelector('input[name="name"]').addEventListener('input', function() {
        let name = this.value;
        let slug = name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
        document.querySelector('input[name="slug"]').value = slug;
    });
</script>
@endsection
