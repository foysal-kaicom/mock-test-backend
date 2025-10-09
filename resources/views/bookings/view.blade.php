@extends('master')

@section('contents')

<div class="container">
    <div class="mb-4 text-center fw-bold" style="font-size: 0.7cm">Booking Details</div>

    {{-- Candidate Info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header text-white fs-5" style="background-color: hsla(233, 63%, 52%, 0.879);">Candidate Information</div>
        <div class="card-body row">
            <div class="col-md-3 text-center">
                @if($booking->candidate->photo)
                    <img src="{{ asset($booking->candidate->photo) }}" alt="Candidate Photo" class="img-thumbnail rounded" style="width: 220px; height: 220px; object-fit: cover;">
                @else
                    <img src="{{ asset('imagePH.png') }}" alt="No Photo" class="img-thumbnail rounded" style="width: 220px; height: 220px; object-fit: cover;">
                @endif
            </div>
            <div class="col-md-9">
                <div class="row row-cols-1 row-cols-md-2 g-3">
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Name</small>
                            <div class="fw-semibold fs-6">
                                {{ $booking->candidate->prefix }} {{ $booking->candidate->first_name }} {{ $booking->candidate->last_name }} {{ $booking->candidate->surname }}
                            </div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Email</small>
                            <div class="fw-semibold fs-6">{{ $booking->candidate->email }}</div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Phone</small>
                            <div class="fw-semibold fs-6">{{ $booking->candidate->phone_number }}</div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Date of Birth</small>
                            <div class="fw-semibold fs-6">{{ \Carbon\Carbon::parse($booking->candidate->date_of_birth)->format('Y-m-d') }}</div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Gender</small>
                            <div class="fw-semibold fs-6">{{ ucfirst($booking->candidate->gender) }}</div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Nationality</small>
                            <div class="fw-semibold fs-6">{{ $booking->candidate->nationality }}</div>
                        </div>
                    </div>
            
                    <div>
                        <div class="border-bottom pb-2">
                            <small class="text-muted">Status</small>
                            <div class="fw-semibold fs-8">
                                <span class="badge 
                                    {{ $booking->candidate->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($booking->candidate->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header text-white fs-5" style="background-color: hsla(198, 69%, 53%, 0.879);">Booking Details</div>
        <div class="card-body row row-cols-1 row-cols-md-2 g-3">
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Status</small>
                    <div class="fw-semibold fs-6">
                        <span class="badge 
                            {{ $booking->status === 'confirmed' ? 'bg-success' : 
                               ($booking->status === 'pending' ? 'bg-secondary' : 'bg-danger') }}">
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Payment Status</small>
                    <div class="fw-semibold fs-6">
                        <span class="badge 
                            {{ $booking->payment_status === 'success' ? 'bg-success' : 
                               ($booking->payment_status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                            {{ ucfirst($booking->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Total Payable</small>
                    <div class="fw-semibold fs-6">৳{{ number_format($booking->total_payable, 2) }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Result</small>
                   
                    <div class="fw-semibold fs-6">
                         @if($booking->result)
                     Listening:  <span class="badge bg-success">{{ $booking->listening_score ?? 'N/A' }}</span>  
                      Reading: <span class="badge bg-success">{{ $booking->reading_score ?? 'N/A' }}</span>  
                      Total: <span class="badge bg-primary">{{ $booking->result ?? 'N/A' }}</span>  
                    @else
                       <span class="badge bg-success">N/A</span>  
                    @endif
                    </div>
                    
                </div>
            </div>
    
            <div class="col-md-12">
                <div class="border-bottom pb-2">
                    <small class="text-muted">Booking Note</small>
                    <div class="fw-semibold fs-6">{{ $booking->booking_note ?? 'None' }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Certificate Claimed</small>
                    <div class="fw-semibold fs-6">
                        <span class="badge {{ $booking->is_certificate_claimed ? 'bg-success' : 'bg-secondary' }}">
                            {{ $booking->is_certificate_claimed ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Certificate Claimed At</small>
                    <div class="fw-semibold fs-6">
                        {{ $booking->certificate_claimed_at ? \Carbon\Carbon::parse($booking->certificate_claimed_at)->format('Y-m-d H:i') : 'Not yet' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header text-white fs-5" style="background-color: hsla(274, 72%, 50%, 0.879);">Payment Information</div>
        <div class="card-body row row-cols-1 row-cols-md-2 g-3">

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Payment Type</small>
                    <div class="fw-semibold fs-6 text-capitalize">
                        @if(!empty($booking->payment?->type))
                            <span class="badge bg-info text-white">{{ $booking->payment->type }}</span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
            </div>            
            
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Amount</small>
                    <div class="fw-semibold fs-6">
                        @if(!empty($booking->payment?->amount))
                            ৳{{ number_format($booking->payment->amount, 2) }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Method</small>
                    <div class="fw-semibold fs-6">
                        @if(!empty($booking->payment?->payment_method))
                            {{ ucfirst($booking->payment->payment_method) }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Status</small>
                    <div class="fw-semibold fs-6">
                        @if(!empty($booking->payment?->status))
                            <span class="badge 
                                {{ $booking->payment->status === 'success' ? 'bg-success' : 
                                ($booking->payment->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                {{ ucfirst($booking->payment->status) }}
                            </span>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Reference / TRX ID</small>
                    <div class="fw-semibold fs-6">
                        {{ $booking->payment?->reference ?? '—' }}
                    </div>
                </div>
            </div>

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Payment Date</small>
                    <div class="fw-semibold fs-6">
                        @if(!empty($booking->payment?->created_at))
                            {{ \Carbon\Carbon::parse($booking->payment->created_at)->format('Y-m-d H:i') }}
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </div>
                </div>
            </div>

            @php
                $additionals = [];
            
                if (!empty($booking->payment?->additionals)) {
                    $decoded = json_decode($booking->payment->additionals, true);
                    if (is_array($decoded)) {
                        $additionals = $decoded;
                    }
                }
            @endphp
            
            @if(!empty($additionals))
                {{-- Modal Trigger Button --}}
                <div class="col-md-12 mt-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#gatewayModal">
                        View Full Payment Gateway Data
                    </button>
                </div>
            
                {{-- Modal --}}
                <div class="modal fade" id="gatewayModal" tabindex="-1" aria-labelledby="gatewayModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title" id="gatewayModalLabel">Full Payment Gateway Data</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row row-cols-1 row-cols-md-2 g-3">
                                    @foreach($additionals as $key => $value)
                                        <div>
                                            <div class="border-bottom pb-2">
                                                <small class="text-muted text-uppercase">{{ str_replace('_', ' ', $key) }}</small>
                                                <div class="fw-semibold fs-6 text-break">{{ $value ?? '—' }}</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        
        </div>
    </div>

    {{-- Exam Info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header text-white fs-5" style="background-color: hsla(149, 61%, 40%, 0.879);">Exam Information</div>
        <div class="card-body row row-cols-1 row-cols-md-2 g-3">
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Title</small>
                    <div class="fw-semibold fs-6">{{ $booking->exam->title }}</div>
                </div>
            </div>

            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Examinee Number</small>
                    <div class="fw-semibold fs-6">
                        @if(!empty($booking->examinee_number))
                        <div class="fw-semibold fs-6">{{ $booking->examinee_number }}</div>
                    @else
                        <span class="text-muted">N/A</span>
                    @endif

                    </div>

                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Exam Date</small>
                    <div class="fw-semibold fs-6">{{ $booking->exam->exam_date }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Start Time</small>
                    <div class="fw-semibold fs-6">{{ $booking->exam->start_time }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">End Time</small>
                    <div class="fw-semibold fs-6">{{ $booking->exam->end_time }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Fee</small>
                    <div class="fw-semibold fs-6">৳{{ number_format($booking->exam->fee, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- Center Info --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-secondary text-white fs-5">Exam Center</div>
        <div class="card-body row row-cols-1 row-cols-md-2 g-3">
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Center Name</small>
                    <div class="fw-semibold fs-6">{{ $booking->center->name }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Address</small>
                    <div class="fw-semibold fs-6">{{ $booking->center->address }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Phone</small>
                    <div class="fw-semibold fs-6">{{ $booking->center->contact_phone }}</div>
                </div>
            </div>
    
            <div>
                <div class="border-bottom pb-2">
                    <small class="text-muted">Email</small>
                    <div class="fw-semibold fs-6">{{ $booking->center->contact_email }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- File Previews --}}
    @if($booking->result_file || $booking->admit_card_file || $booking->certificate_file)
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-dark text-white fs-5">Attached Documents</div>
        <div class="card-body row row-cols-1 row-cols-md-2 g-4">
            @if($booking->result_file)
                <div>
                    <small class="text-muted">Result File</small>
                    <iframe src="{{ asset($booking->result_file) }}" frameborder="0"  style="width: 95%; max-width: 1000px; height: 600px;"  class="border rounded shadow-sm"></iframe>
                </div>
            @endif

            @if($booking->admit_card_file)
                <div>
                    <small class="text-muted">Admit Card</small>
                    <iframe src="{{ asset($booking->admit_card_file) }}" frameborder="0"  style="width: 95%; max-width: 1000px; height: 600px;"  class="border rounded shadow-sm"></iframe>
                </div>
            @endif

            @if($booking->certificate_file)
                <div style="position: relative; left:270px">
                    <small class="text-muted">Certificate File</small>
                    <iframe src="{{ asset($booking->certificate_file) }}" frameborder="0"  style="width: 100%; max-width: 1000px; height: 600px;"  class="border rounded shadow-sm"></iframe>
                </div>
            @endif
        </div>
    </div>
    @endif


    <div class="text-end">
        <a href="{{ route('booking.list') }}" class="btn btn-outline-dark">← Back to Booking List</a>
    </div>
</div>

@endsection
