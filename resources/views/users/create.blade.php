@extends('master')

@section('contents')


<div class="rounded shadow-sm">
    <div class=" text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="fs-5">Create User</h3>
    </div>

    <!-- Form Start -->
   
    <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">

        @csrf <!-- CSRF Token for security -->

        <div class="row g-4">
        <!-- Image Upload Section -->
        <div class="col-md-3 text-center">
            <div class="position-relative border rounded bg-light d-flex align-items-center justify-content-center h-75">
                <img id="imagePreview" src="{{ asset('assets/imagePH.png') }}" alt="Display Image" class="w-100 h-100 object-fit-cover rounded"/>
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

        <div class="col-md-9">
          <div class="row g-3">
            <!-- Name Field -->
            <div class="col-md-4">
                <label class="form-label">User Name</label>
                <input required type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ old('name') }}" />
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Field -->
            <div class="col-md-4">
                <label class="form-label">Email</label>
                <input required type="email" name="email" class="form-control" placeholder="Enter Email" value="{{ old('email') }}" />
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Field -->
            <div class="col-md-4">
                <label class="form-label">Password</label>
                <input required type="password" name="password" class="form-control" placeholder="Enter Password" />
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

        </div>

            <div class="row g-3 mt-3">
               <!-- Confirm Password Field -->
              <div class="col-md-4">
                  <label class="form-label">Confirm Password</label>
                  <input required type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" />
                  @error('password_confirmation')
                      <div class="text-danger">{{ $message }}</div>
                  @enderror
              </div>
          
                <!-- Role Selection -->
                <div class="col-md-4">
                    <label class="form-label">Role</label>
                    <select required name="role_id" class="form-select">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
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
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @hasPermission('users.store')
            <div class="row g-3 mt-3">
              <div class="col-12 text-end">
                  <button type="submit" class="btn btn-primary px-4">Save</button>
              </div>
          </div>
          @endHasPermission 
        </div>
    </form>
    <!-- Form End -->
</div>
</div>

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
        document.getElementById("imagePreview").src = "{{ asset('assets/img/default-image.jpg') }}";
        document.getElementById("fileInput").value = ""; // Reset the input field
    });
</script>

@endsection
