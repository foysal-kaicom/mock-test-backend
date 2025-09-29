@extends('master')

@section('contents')

<div class="bg-white rounded shadow-sm">
    <div class="text-dark p-3 rounded-top" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="fs-5">Edit Certificate Payment</h3>
    </div>

    <form action="{{ route('certificate-claim.update', $certificatePayment->id) }}" method="POST" class="bg-white p-4 rounded-bottom">
        @csrf

        <div class="row g-4">

            <div class="col-md-3">
                <label class="form-label">Sender Number</label>
                <input type="text" name="sender_number" value="{{ old('sender_number', $certificatePayment->sender_number) }}" class="form-control" />
                @error('sender_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Amount</label>
                <input type="number" step="0.01" name="amount" value="{{ old('amount', $certificatePayment->amount) }}" class="form-control" disabled/>
                @error('amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Received Amount</label>
                <input type="number" step="0.01" name="received_amount" value="{{ old('received_amount', $certificatePayment->received_amount) }}" class="form-control" />
                @error('received_amount')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Payment Status</label>
                <select name="status" class="form-select">
                    <option value="pending" {{ $certificatePayment->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ $certificatePayment->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ $certificatePayment->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="failed" {{ $certificatePayment->status == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                @error('status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Transaction Number</label>
                <input type="text" name="trx_number" value="{{ old('trx_number', $certificatePayment->trx_number) }}" class="form-control" />
                @error('trx_number')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Delivery Status</label>
                <select name="delivery_status" class="form-select">
                    <option value="pending" {{ $certificatePayment->delivery_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="delivered" {{ $certificatePayment->delivery_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                </select>
                @error('delivery_status')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">Certificate Claim Format</label>
                <select name="claimed_format" class="form-select">
                    <option value="hard-copy" {{ $certificatePayment->claimed_format == 'hard-copy' ? 'selected' : '' }}>Hard Copy</option>
                    <option value="soft-copy" {{ $certificatePayment->claimed_format == 'soft-copy' ? 'selected' : '' }}>Soft Copy</option>
                    <option value="both" {{ $certificatePayment->claimed_format == 'both' ? 'selected' : '' }}>Both</option>
                </select>
                @error('claimed_format')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Delivery Date</label>
                <input type="date" name="delivery_date" value="{{ old('delivery_date', date('Y-m-d',strtotime($certificatePayment->delivery_date))) }}" class="form-control" />
                @error('delivery_date')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-6">
                <label class="form-label">Delivery Note</label>
                <textarea name="delivery_note" class="form-control" rows="3">{{ old('delivery_note', $certificatePayment->delivery_note) }}</textarea>
                @error('delivery_note')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="col-md-10">
                <label class="form-label">Certificate Payment Remarks</label>
                <textarea name="remarks" class="form-control" rows="3">{{ old('remarks', $certificatePayment->remarks) }}</textarea>
                @error('remarks')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <button type="submit" name="action" value="update_edit_booking" class="btn btn-success w-25">Update & Edit Booking</button>
                <button type="submit" name="action" value="update" class="btn btn-primary w-25">Update</button>
            </div>
            
        </div>
    </form>
</div>

@endsection
