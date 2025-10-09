@extends('master')

@section('contents')
<div class="bg-white rounded shadow-sm">
    <div class="py-3 px-4 d-flex justify-content-between align-items-center bg-indigo-300">
        <h3 class="fs-5 font-semibold">Edit Booking</h3>
        <a href="javascript:void(0);" class="flex items-center gap-2 px-8 py-2 rounded-xl text-sm font-medium bg-sky-500 text-white hover:bg-sky-600 transition btn-add-payment">
            <i class="fa-solid fa-plus"></i> Add Payment
        </a>
    </div>

    <form action="{{ route('booking.update', $booking->id) }}" method="POST" enctype="multipart/form-data" class="bg-white p-4 rounded-bottom">
        @csrf

        <div class="row g-4">
            <!-- Form Fields -->
            <div class="col-md-12">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Candidate</label>
                        <input type="text" name="candidate_id" value="{{ $booking->candidate->prefix }} {{ $booking->candidate->first_name }} {{ $booking->candidate->last_name }} {{ $booking->candidate->surname }}" class="form-control" readonly disabled />
                        @error('candidate_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Exam:</label>
                        <select name="exam_id" class="form-select">
                            @foreach ($exams as $exam)
                                <option value="{{ $exam->id }}" {{ old('exam_id', $booking->exam_id) == $exam->id ? 'selected' : '' }}>
                                    {{ $exam->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('exam_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Center:</label>
                        <select name="center_id" class="form-select" style="max-height: 200px; overflow-y: auto">
                            @foreach ($centers as $center)
                                <option value="{{ $center->id }}" {{ old('center_id', $booking->center_id) == $center->id ? 'selected' : '' }}>
                                    {{ $center->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('center_id')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" style="max-height: 200px; overflow-y: auto;">
                            <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ old('status', $booking->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled" {{ old('status', $booking->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Payment Status</label>
                        <select name="payment_status" class="form-select" disabled>
                            <option value="pending" {{ old('payment_status', $booking->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="success" {{ old('payment_status', $booking->payment_status) == 'success' ? 'selected' : '' }}>Success</option>
                            <option value="failed" {{ old('payment_status', $booking->payment_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="cancelled" {{ old('payment_status', $booking->payment_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        @error('payment_status')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label">Total Payable</label>
                        <input disabled type="number" name="total_payable" value="{{ old('total_payable', $booking->total_payable) }}" class="form-control" />
                        @error('total_payable')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Examinee Number</label>
                        <input type="text" name="examinee_number" value="{{ old('examinee_number', $booking->examinee_number) }}" class="form-control" />
                        @error('examinee_number')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Listening Score</label>
                        <input type="text" name="listening_score" value="{{ old('listening_score', $booking->listening_score) }}" class="form-control" />
                        @error('listening_score')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Reading Score</label>
                        <input type="text" name="reading_score" value="{{ old('reading_score', $booking->reading_score) }}" class="form-control" />
                        @error('reading_score')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Admit card
                          @if($booking->admit_card_file)<a class="text-sm text-blue-400" href="{{$booking->admit_card_file}}" target="_blank">Click to download</a>@endif

                        </label>
                        <input type="file" name="admit_card_file" value="{{ old('admit_card_file', $booking->admit_card_file) }}" class="form-control" />
                        @error('admit_card_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Result file 
                            @if($booking->result_file)<a class="text-sm text-blue-400" href="{{$booking->result_file}}" target="_blank">Click to download</a>@endif
                    </label>
                        <input type="file" name="result_file" value="{{ old('result_file', $booking->result_file) }}" class="form-control" />
                        @error('result_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label">Certificate File
                         @if($booking->certificate_file)<a class="text-sm text-blue-400" href="{{$booking->certificate_file}}" target="_blank">Click to download</a>@endif

                        </label>
                        <input type="file" name="certificate_file" value="{{ old('certificate_file', $booking->certificate_file) }}" class="form-control"/>
                        @error('certificate_file')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Note</label>
                        <textarea placeholder="Keep Notes Regarding this Booking . . ." name="booking_note" class="form-control">{{ old('booking_note', $booking->booking_note) }}</textarea>
                        @error('address')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            <!-- Submit Button -->
            @hasPermission('account.store')
            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="bg-indigo-500 text-white px-5 py-2 rounded-lg w-25">Save</button>
            </div>
            @endHasPermission 
        </div>
    </form>
</div>

    <!-- Add Payment Modal -->
    <div class="modal fade" id="addPaymentModal" tabindex="-1" aria-labelledby="addPaymentModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPaymentModalLabel">Add Payment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addPaymentForm" method="POST" action="{{ route('booking.payment.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" required>
                        </div>

                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <input type="text" class="form-control" id="payment_method" name="payment_method" required>
                        </div>

                        <div class="mb-3">
                            <label for="reference" class="form-label">Reference</label>
                            <input type="text" class="form-control" id="reference" name="reference" required>
                        </div>

                        <div class="mb-3">
                            <label for="additionals" class="form-label">Additional Notes</label>
                            <textarea class="form-control" id="additionals" name="additionals" rows="3"></textarea>
                        </div>

                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        <input type="hidden" name="status" value="success">
                        <input type="hidden" name="type" value="booking">

                        <button type="submit" class="btn btn-primary">Save Payment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('.btn-add-payment').click(function() {
        $('#addPaymentModal').modal('show');
    });
});

</script>
