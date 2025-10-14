@extends('master')

@section('contents')

<div class="">

    <div class="bg-white rounded" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0px 2px rgba(0, 0, 0, 0.1), 4px 0 6px rgba(0, 0, 0, 0.1), 0px 0 2px rgba(0, 0, 0, 0.1);">
        <form action="{{ route('business-settings.general') }}" method="POST" enctype="multipart/form-data" >
            @csrf
        <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
            <h3 class="fs-5">Edit Business Settings</h3>
        </div>
        <div class="row g-4 p-4">
@if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
            <!-- Form Fields -->
            <div class="col-md-9">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Business name</label>
                        <input type="text" name="business_name" value="{{ old('business_name', $bsData->business_name) }}" class="form-control" />
                        @error('business_name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Email</label>
                        <input type="email" name="business_email" value="{{ old('business_email' , $bsData->business_email) }}" class="form-control" />
                        @error('business_email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Phone</label>
                        <input type="text" name="business_phone" value="{{ old('business_phone' , $bsData->business_phone) }}" class="form-control" />
                        @error('business_phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Website URL</label>
                        <input type="text" name="website_url" value="{{ old('website_url' , $bsData->website_url) }}" class="form-control" />
                        @error('website_url')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Bkash Number</label>
                        <input type="text" name="bkash_number" value="{{ old('bkash_number' , $bsData->bkash_number) }}" class="form-control" />
                        @error('bkash_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Certificate Amount</label>
                        <input type="text" name="certificate_amount" value="{{ old('certificate_amount' , $bsData->certificate_amount) }}" class="form-control" />
                        @error('certificate_amount')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Address</label>
                        <textarea name="address" class="form-control">{{ old('address', $bsData->address) }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

              <!-- Image Upload -->
              {{-- <div class="col-md-3 text-center">
                <div class="position-relative border rounded bg-light  d-flex" style="left: 40px; height:160px; width:200px">
                    <img id="imagePreview" src="{{ $bsData->logo ? asset($bsData->logo) : asset('imagePH.png') }}" alt="Display Image" class="w-100 h-100 object-fit-cover rounded"/>
                </div>
                <input type="file" accept="image/*" id="fileInput" name="logo" class="d-none" />
                <label for="fileInput" class="position-relative btn btn-dark mt-2" style="left:15px;width:200px">Choose Logo</label>
                @error('logo')
                    <div class="text-danger"></div>
                @enderror
            </div> --}}
            <div class="col-md-3 text-center">
                <div class="position-relative border rounded bg-light d-flex" style="left: 40px; height:160px; width:200px">
                    <img id="imagePreview" 
                        src="{{ $bsData->logo ? asset('storage/' . $bsData->logo) : asset('imagePH.png') }}" 
                        alt="Display Image" 
                        class="w-100 h-100 object-fit-cover rounded"/>
                </div>

                <input type="file" accept="image/*" id="fileInput" name="logo" class="d-none" />
                <label for="fileInput" class="position-relative btn btn-dark mt-2" style="left:15px;width:200px">
                    Choose Logo
                </label>

                @error('logo')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>


                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary w-25">Save</button>
                </div>
            </form>    
        </div>
    </div>
   
    <div class="bg-white rounded mt-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0px 2px rgba(0, 0, 0, 0.1), 4px 0 6px rgba(0, 0, 0, 0.1), 0px 0 2px rgba(0, 0, 0, 0.1);">
        <form action="{{ route('business-settings.legal') }}" method="POST" enctype="multipart/form-data" >
            @csrf
        <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
            <h3 class="fs-5">Legal Information</h3>
        </div>
        <div class="row g-4 p-4">
                <!-- Form Fields -->
                <div class="col-md-12">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">TIN Number</label>
                            <input type="text" name="tin_number" value="{{ old('tin_number', $bsData->tin_number) }}" class="form-control" />
                            @error('tin_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">BIN Number</label>
                            <input type="text" name="bin_number" value="{{ old('bin_number', $bsData->bin_number) }}" class="form-control" />
                            @error('bin_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Trade License</label>
                            <input type="text" name="trade_license" value="{{ old('trade_license', $bsData->trade_license) }}" class="form-control" />
                            @error('trade_license')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Certification Docs</label>
                            <input type="file" name="certification_docs" value="{{ old('certification_docs') }}" class="form-control" />
                            @error('certification_docs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Authorized Docs</label>
                            <input type="file" name="authorized_docs" value="{{ old('authorized_docs') }}" class="form-control" />
                            @error('authorized_docs')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Legal Docs (Choose multiple)</label>
                            <input type="file" name="legal_docs[]" value="{{ old('legal_docs') }}" class="col-md-3 form-control" multiple />
                            @error('legal_docs')
                            <div class="text-danger">
                                {{ $message }}
                            </div>
                        @enderror
                        </div>
                    </div>
                </div>
                 <!-- Submit Button -->
                 <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary w-25">Save</button>
                </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    
    <div class="bg-white rounded ml-6 mr-6" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0px 2px rgba(0, 0, 0, 0.1), 4px 0 6px rgba(0, 0, 0, 0.1), 0px 0 2px rgba(0, 0, 0, 0.1);">
        <form action="{{ route('business-settings.social') }}" method="POST" enctype="multipart/form-data" >
            @csrf
        <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
            <h3 class="fs-5">Social Media Links</h3>
        </div>
        <div class="row g-4 p-4">
    
                <!-- Form Fields -->
                <div class="col-md-9">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Facebook URL</label>
                            <input type="text" name="facebook_url" value="{{ old('facebook_url', $bsData->facebook_url) }}" class="form-control" />
                            @error('facebook_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Twitter URL</label>
                            <input type="text" name="twitter_url" value="{{ old('twitter_url', $bsData->twitter_url) }}" class="form-control" />
                            @error('twitter_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Linkedin URL</label>
                            <input type="text" name="linkedin_url" value="{{ old('linkedin_url', $bsData->linkedin_url) }}" class="form-control" />
                            @error('linkedin_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Youtube URL</label>
                            <input type="text" name="youtube_url" value="{{ old('youtube_url', $bsData->youtube_url) }}" class="form-control" />
                            @error('youtube_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Instagram URL</label>
                            <input type="text" name="instagram_url" value="{{ old('instagram_url', $bsData->instagram_url) }}" class="form-control"/>
                            @error('instagram_url')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
    
                <!-- Image Upload -->
                <div class="col-md-3 text-center">
                    <div class="position-relative border rounded bg-light  d-flex" style="left: 60px; height:120px; width:180px">
                        <img id="imagePreviewicon" src="{{ $bsData->favicon_icon ? asset($bsData->favicon_icon) : asset('imagePH.png') }}" alt="Display Image" class="w-100 h-100 object-fit-cover rounded"/>
                    </div>
                    <input type="file" accept="image/*" id="fileInputicon" name="favicon_icon" class="d-none" />
                    <label for="fileInputicon" class="position-relative btn btn-dark mt-2" style="left:23px;width:181px">Choose Favicon</label>
                    @error('favicon_icon')
                        <div class="text-danger"></div>
                    @enderror
                </div>
                <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary w-25">Save</button>
                </div>
            </div>
        </form>    
    </div>

    <div class="bg-white rounded m-4" style="box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1), 0 0px 2px rgba(0, 0, 0, 0.1), 4px 0 6px rgba(0, 0, 0, 0.1), 0px 0 2px rgba(0, 0, 0, 0.1);">
        <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
            <h3 class="fs-5">Policies</h3>
        </div>
        <div class="row g-4 p-4">
            <form action="{{ route('business-settings.policies') }}" method="POST" >
                @csrf 
            
                <div class="form-group mb-4">
                    <label for="privacy_policy" style="margin-left: 4px; font-weight: bold; font-size:18px">Privacy Policy</label>
                    <textarea id="content" name="privacy_policy" class="form-control">{{ old('privacy_policy', $bsData->privacy_policy ) }}</textarea>
                </div>
            
                <div class="form-group mb-4">
                    <label for="terms_and_conditions" style="margin-left: 4px; font-weight: bold; font-size:18px">Terms and Conditions</label>
                    <textarea id="terms" name="terms_and_conditions" class="form-control">{{ old('terms_and_conditions',  $bsData->terms_and_conditions) }}</textarea>
                </div>
            
                <div class="form-group mb-4">
                    <label for="return_policy" style="margin-left: 4px; font-weight: bold; font-size:18px">Return Policy</label>
                    <textarea id="return" name="return_policy" class="form-control">{{ old('return_policy',  $bsData->return_policy) }}</textarea>
                </div>
           
              <!-- Submit Button -->
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-primary w-25">Save</button>
                </div>
            </form>
        </div>
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

    document.getElementById("fileInputicon").addEventListener("change", function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById("imagePreviewicon").src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    
    // Trigger the change event on page load to set the correct initial state
    document.getElementById('urlTypeSelect').dispatchEvent(new Event('change'));

    document.getElementById("removeImage").addEventListener("click", function() {
        document.getElementById("imagePreview").src = "{{ asset('assets/img/default-image.jpg') }}";
        document.getElementById("fileInput").value = ""; // Reset the input field
    });
</script>


@endsection

@push('js')
    <script>
        tinymce.init({
            selector: '#terms',
            height: 350,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help',
            forced_root_block: false
        });
    </script>
        <script>
            tinymce.init({
                selector: '#return',
                height: 350,
                menubar: false,
                plugins: [
                    'advlist autolink lists link image charmap preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | bold italic backcolor | \
                        alignleft aligncenter alignright alignjustify | \
                        bullist numlist outdent indent | removeformat | help',
                forced_root_block: false
            });
        </script>
@endpush