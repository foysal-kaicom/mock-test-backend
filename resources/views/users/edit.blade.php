@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden">
    <!-- Section Header -->
    <div class="p-2 px-4 d-flex justify-content-between align-items-center" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="text-md m-0">Edit User</h3>
    </div>

    <!-- Form Start -->
    <form action="{{ route('users.update', $superAdmin->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf
        @method('POST') <!-- Correct method for updating -->
        
        <div class="row g-4">
            <!-- Image Upload Section -->
            <div class="col-md-3 text-center">
                <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center h-75">
                    <img id="imagePreview" 
                         src="{{ isset($superAdmin) && $superAdmin->image ? $superAdmin->image : asset('assets/imagePH.png') }}" 
                         alt="Display Image" 
                         class="w-100 h-100 object-fit-cover rounded" />
                    <button type="button" id="removeImage" class="btn btn-sm btn-light bg-white border position-absolute top-0 end-0 rounded-circle">
                        ×
                    </button>
                </div>
                <input type="file" accept="image/*" id="fileInput" name="image" class="d-none" />
                <label for="fileInput" class="btn btn-dark mt-3 w-100">Choose Image</label>
                @error('image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Form Fields -->
            <div class="col-md-9">
                <div class="row g-3">
                    <!-- Name Field -->
                    <div class="col-md-4">
                        <label class="form-label">User Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name', $superAdmin->name) }}" />
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email', $superAdmin->email) }}" />
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="col-md-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep existing" />
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <!-- Confirm Password Field -->
                    <div class="col-md-4">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role Selection -->
                    <div class="col-md-4">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select">
                            <option value="">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ old('role_id', $superAdmin->role_id) == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status Selection -->
                    <div class="col-md-4">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" {{ old('status', $superAdmin->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $superAdmin->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                @hasPermission('super-admin.update')
                <!-- Submit Button -->
                <div class="row g-3 mt-3">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary px-4">Update</button>
                    </div>
                </div>
                @endHasPermission 
            </div>
        </div>
    </form>
    <!-- Form End -->
</section>

<!-- JavaScript for Image Preview -->
<script>
    document.getElementById("fileInput").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("imagePreview").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById("removeImage").addEventListener("click", function() {
        document.getElementById("imagePreview").src = "{{ asset('assets/imagePH.png') }}";
        document.getElementById("fileInput").value = ""; // Reset the input field
    });
</script>

@endsection
