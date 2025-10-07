@extends('master')

@section('contents')

<div class="card shadow-lg border-0 rounded-3">
    <!-- Header -->
    <div class="card-header py-3 rounded-top bg-indigo-300">
        <h3 class="fs-5 fw-semibold mb-0 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 1L15.09 8.26H23L17 12.97L19.18 20.74L12 16.77L4.82 20.74L7 12.97L1 8.26H8.91L12 1Z"></path>
            </svg>
            Edit Package
        </h3>
    </div>
    
    <!-- Form -->
    <form action="{{ route('packages.update', $package->id) }}" method="POST" enctype="multipart/form-data" class="p-4">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <!-- Package Name -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Package Name</label>
                <input type="text" name="name" value="{{ $package->name }}"
                    class="form-control form-control-lg shadow-sm rounded-2" placeholder="Enter package name" required />
                @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <!-- Price -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Price</label>
                <input type="number" name="price" value="{{ $package->price }}"
                    class="form-control form-control-lg shadow-sm rounded-2" placeholder="e.g. 1000" required />
                @error('price') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <!-- Home -->
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="is_home" id="isHome"
                        {{ $package->is_home ? 'checked' : '' }}>  
                    <label for="isHome" class="form-check-label fw-semibold">Show Homepage</label>
                </div>
            </div>

            <!-- Popular -->
            <div class="col-md-3 d-flex align-items-center">
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" name="is_popular" id="isPopular"
                        {{ $package->is_popular ? 'checked' : '' }}>
                    <label for="isPopular" class="form-check-label fw-semibold">Popular Package</label>
                </div>
            </div>

            <!-- Order -->
            <div class="col-md-3">
                <label class="form-label fw-semibold">Sequence</label>
                <input type="number" name="order" value="{{ $package->order }}"
                    class="form-control form-control-lg shadow-sm rounded-2" placeholder="e.g. 1" required />
                @error('order') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <!-- Short Description -->
            <div class="col-md-12">
                <label class="form-label fw-semibold">Short Description</label>
                <textarea name="short_description" rows="2" class="form-control shadow-sm rounded-2"
                    placeholder="Brief short description">{{ $package->short_description }}</textarea>
                @error('short_description') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <!-- Full Description -->
            <div class="col-md-12">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" id="details-editor" rows="4" class="form-control shadow-sm rounded-2"
                    placeholder="Full details about the package">{{ $package->description }}</textarea>
                @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
            </div>

            <!-- Status -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-control shadow-sm rounded-2">
                    <option value="1" {{ $package->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$package->status ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <!-- Exams Section -->
            <div class="col-md-12">
                <h5 class="fw-semibold mb-3">Exams</h5>
                <div id="exam-wrapper">
                    @foreach($package->package_details as $detail)
                        <div class="exam-row flex gap-2 mb-2">
                            <select name="exam_id[]" class="form-control shadow-sm rounded-2" required>
                                <option value="">-- Select Exam --</option>
                                @foreach($exams as $exam)
                                    <option value="{{ $exam->id }}" {{ $exam->id == $detail->exam_id ? 'selected' : '' }}>
                                        {{ $exam->title }}
                                    </option>
                                @endforeach
                            </select>

                            <input type="number" name="max_exam_attempt[]" value="{{ $detail->max_exam_attempt }}"
                                placeholder="Max Attempt" class="form-control shadow-sm rounded-2" required>
                        </div>
                    @endforeach
                </div>
                <button type="button" id="add-exam"
                    class="btn btn-outline-secondary btn-sm mt-2 rounded-pill px-3">
                    + Add Exam
                </button>
            </div>
        </div>

        <!-- Submit -->
        <div class="pt-4 flex justify-end">
            <button type="submit"
                class="w-full md:w-auto px-6 py-2 bg-indigo-500 text-white font-semibold rounded-xl shadow hover:bg-indigo-600 transition flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M18 21V13H6V21H4C3.44772 21 3 20.5523 3 20V4C3 3.44772 3.44772 3 4 3H17L21 7V20C21 20.5523 20.5523 21 20 21H18ZM16 21H8V15H16V21Z"></path>
                </svg>
                Update Package
            </button>
        </div>
    </form>

</div>

<script>
    document.getElementById('add-exam').addEventListener('click', function () {
    let wrapper = document.getElementById('exam-wrapper');

    let row = document.createElement('div');
    row.classList.add('exam-row', 'flex', 'gap-2', 'mb-2');

    row.innerHTML = `
        <select name="exam_id[]" class="form-control" required>
            <option value="">-- Select Exam --</option>
            @foreach($exams as $exam)
                <option value="{{ $exam->id }}">{{ $exam->title }}</option>
            @endforeach
        </select>
        <input type="number" name="max_exam_attempt[]" placeholder="Max Attempt" class="form-control" required>
    `;

    wrapper.appendChild(row);
});
</script>
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#details-editor'))
        .catch(error => {
            console.error(error);
        });
</script>
@endsection
