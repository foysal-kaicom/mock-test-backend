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
                Edit Create
            </p>
        </a>
    </div>
</div>

<h3 class="text-xl font-semibold p-[12px] mb-[50px] bg-indigo-300 rounded text-black">Edit Candidate</h3>

<form action="{{ route('candidate.update', $candidate->id) }}" method="POST" enctype="multipart/form-data" class="px-10">
    @csrf
    @method('put')
    <div class="flex gap-10">
        <!-- Image Upload -->
        <div class="flex flex-col items-center text-center w-1/3 p-10 shadow-md border border-gray-100 rounded bg-white">
            <div class="relative border rounded bg-gray-100 flex items-center justify-center size-[300px] overflow-hidden">
                <img id="imagePreview" src="{{ $candidate->photo ? asset($candidate->photo) : asset('imagePH.png') }}" alt="Display Image" class="size-[300px] object-cover rounded border" />
                <button type="button" id="removeImage" class="absolute top-2 right-2 bg-red-600 hover:bg-red-800 text-white rounded-full w-7 h-7 flex items-center justify-center">
                    ×
                </button>
            </div>
            <input type="file" accept="image/*" id="fileInput" name="photo" class="d-none" />
            <label for="fileInput" class="mt-3 w-[300px] text-white py-2 px-3 rounded cursor-pointer bg-indigo-500 hover:bg-indigo-700 transition">Choose Image</label>
            @error('photo')
            <div class="text-danger"></div>
            @enderror
        </div>

        <!-- Form Fields -->
        <div class="w-2/3 p-10 shadow-md border border-gray-100 rounded bg-white">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="">
                    <label class="block text-sm font-medium mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name', $candidate->first_name )}}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('first_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="">
                    <label class="block text-sm font-medium mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name', $candidate->last_name) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('last_name')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="">
                    <label class="block text-sm font-medium mb-1">Email</label>
                    <input type="text" readonly value="{{ old('email', $candidate->email) }}" class="w-full bg-white border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" disabled />
                    @error('email')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
                @php
                $minAgeLimit = \Carbon\Carbon::now()->subYears(12)->toDateString();
                @endphp


                <div class="">
                    <label class="block text-sm font-medium mb-1">Date of birth</label>
                    <input type="date" name="date_of_birth" max={{$minAgeLimit}}
                        value="{{ old('date_of_birth', \Carbon\Carbon::parse($candidate->date_of_birth)->format('Y-m-d')) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('date_of_birth')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="phone_number" value="{{ old('phone_number', $candidate->phone_number) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('phone_number')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="">
                    <label class="form-label">Gender</label>
                    <select name="gender" class="w-full bg-white border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="male" {{ old('gender', $candidate->gender) == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender', $candidate->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @error('gender')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>


                <div class="col-span-3">
                    <label class="form-label">National ID / Passport ID</label>
                    <input type="text" name="national_id" value="{{ old('national_id', $candidate->national_id) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('national_id')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-span-3">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" value="{{ old('address', $candidate->address) }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    @error('address')
                    <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label class="form-label" for="currently_living_country">Currently Living In</label>
                    <select name="currently_living_country" id="currently_living_country" class="w-full bg-white border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        <option value="">-- Select Country --</option>
                        <option value="Bangladesh" @if( $candidate->currently_living_country =='Bangladesh') selected @endif>Bangladesh</option>
                        <option value="Japan" @if( $candidate->currently_living_country =='Japan') selected @endif>Japan</option>
                    </select>
                </div>


                <!-- Submit Button -->
                @hasPermission('account.store')
                <div class="w-full flex items-end justify-end">
                    <button type="submit" class="w-[250px] bg-indigo-500 hover:bg-indigo-700 text-white py-2 px-4 rounded transition">Save</button>
                </div>
                @endHasPermission

            </div>
        </div>

    </div>

</form>

<h3 class="text-xl font-semibold p-[12px] mb-[50px] bg-indigo-300 rounded text-black mt-[50px]">Recent Booking</h3>

<div class="overflow-x-auto mt-4">
    <table class="min-w-full divide-y divide-gray-200 border" id="bookingTable">
        <thead class="bg-indigo-300 text-gray-700">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">#</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Booking ID</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Exam</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Center</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Total Payable</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Payment Status</th>
                <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider">Result</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($candidate->bookings as $key => $booking)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2">{{ $key + 1 }}</td>
                <td class="px-4 py-2">{{ $booking->id }}</td>
                <td class="px-4 py-2">{{ $booking->exam->title ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $booking->center->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ number_format($booking->total_payable, 2) }}</td>
                <td class="px-4 py-2">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $booking->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($booking->status) }}
                    </span>
                </td>
                <td class="px-4 py-2">
                    <span class="px-3 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $booking->payment_status === 'success' ? 'bg-green-100 text-green-800' : ($booking->payment_status === 'pending'?'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($booking->payment_status) }}
                    </span>
                </td>
                <td class="px-4 py-2">{{ $booking->result ?? 'Pending' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="px-4 py-3 text-center text-gray-500">No bookings found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- JavaScript for Image Preview -->
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