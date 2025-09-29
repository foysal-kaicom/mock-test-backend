@extends('master')

@section('contents')

<div class="flex gap-3 text-xs sm:text-sm font-semibold text-gray-500 items-center w-full mb-[20px]">
    <div class="flex gap-3 items-center">
        <a href={b.to}>
            <p class="cursor-pointer line-clamp-1">
                Candidates
            </p>
        </a>

        <p class="text-xl font-thin">/</p>
        <a href={b.to}>
            <p class="cursor-pointer line-clamp-1 text-blue-500">
                Create New
            </p>
        </a>
    </div>
</div>

<h3 class="text-xl font-semibold p-[12px] mb-[50px] rounded text-black bg-indigo-300">Create Candidate</h3>

<form action="{{ route('candidate.store') }}" method="POST" enctype="multipart/form-data" class="px-10">
    @csrf

    <div class="flex gap-10">

        <!-- Image Upload Section -->
        <div class="flex flex-col items-center text-center w-1/3 p-10 shadow-md border border-gray-100 rounded bg-white">
            <div class="relative border rounded bg-gray-100 flex items-center justify-center size-[300px] overflow-hidden">
                <img id="imagePreview" src="{{ asset('imagePH.png') }}" alt="Display Image" class="size-[300px] object-cover rounded border" />
                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-600 hover:bg-red-800 text-white rounded-full w-7 h-7 flex items-center justify-center">
                    ×
                </button>
            </div>
            <input type="file" accept="image/*" id="fileInput" name="photo" class="hidden" />
            <label for="fileInput" class="mt-3 w-[300px] text-white py-2 px-3 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-700 transition">
                Choose Image
            </label>
            @error('photo')
            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Candidate Details -->
        <div class="w-2/3 p-10 shadow-md border border-gray-100 rounded bg-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <!-- First Name -->
                <div>
                    <label class="block text-sm font-medium mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="First Name.." />
                    @error('first_name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Last Name -->
                <div>
                    <label class="block text-sm font-medium mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Last Name.." />
                    @error('last_name')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="example@xyz.com" />
                    @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                @php
                $minAgeLimit = \Carbon\Carbon::now()->subYears(12)->toDateString();
                @endphp

                <!-- Date of Birth -->
                <div>
                    <label class="block text-sm font-medium mb-1">Date of Birth</label>
                    <input max="{{$minAgeLimit}}" type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('date_of_birth')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label class="block text-sm font-medium mb-1">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="+8801XXXXXXXXX" />
                    @error('phone_number')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium mb-1">Gender</label>
                    <select name="gender" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500 bg-white">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                    @error('gender')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- National ID -->
                <div class="col-span-3">
                    <label class="block text-sm font-medium mb-1">National ID / Passport ID</label>
                    <input type="text" name="national_id" value="{{ old('national_id') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="A0XXXXXXX" />
                    @error('national_id')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Address -->
                <div class="col-span-3">
                    <label class="block text-sm font-medium mb-1">Address</label>
                    <textarea name="address" placeholder="Address" rows="2" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('address') }}</textarea>
                    @error('address')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <!-- Submit -->
            @hasPermission('account.store')
            <div class="flex justify-end mt-6">
                <button type="submit" class="w-[250px] bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded transition">
                    Save
                </button>
            </div>
            @endHasPermission
        </div>
    </div>



</form>

<script>

    // Preview uploaded image
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

    // Remove image (reset to default)
    document.getElementById("removeImage").addEventListener("click", function() {
        document.getElementById("imagePreview").src = "{{ asset('imagePH.png') }}";
        document.getElementById("fileInput").value = "";
        console.log("Image removed, reset to default.");
    });
</script>


@endsection