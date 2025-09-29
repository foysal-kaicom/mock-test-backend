@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden">
    <!-- Section Header -->
    <div class="p-2 px-4 d-flex justify-content-between align-items-center" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="text-md m-0">Payment List</h3>

        <!-- Dropdown to filter by status -->
        <form action="" method="GET" class="d-flex gap-2 align-items-center ms-auto">

            <!-- Status Dropdown -->
            <div class="dropdown rounded" style="width: 120px; background-color: hsla(199, 76%, 75%, 0.841); color:#04070a">
                <select class="form-select btn btn-sm" name="status" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <!-- Search Field -->
            <input type="text" name="search" class="form-control form-control-sm" placeholder="Search Booking ID..." style="width:170px;">

            <!-- Submit Button -->
            <button type="submit" class="btn btn-sm btn-primary">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('certificate-claim.list') }}" class="btn btn-sm btn-secondary" title="Reset Filters">
                <i class="fas fa-undo"></i>
            </a>


        </form>

    </div>

    <style>
        .statusbtn-active {
            background-color: hsla(215, 94%, 42%, 0.455);
            cursor: pointer;
        }

        .statusbtn-disabled {
            background-color: hsla(358, 92%, 33%, 0.879);
            cursor: pointer;
        }

        .booking-badge {
            background-color: hsla(203, 58%, 45%, 0.974);
            transition: all 0.3s ease;
            display: inline-block;
            /* required for transform */
        }

        .booking-badge:hover {
            background-color: hsla(225, 89%, 82%, 0.597);
            transform: scale(1.05);
            /* slightly enlarge */
            color: black
        }
    </style>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th class="d-none d-sm-table-cell">Booking ID</th>
                    <th class="d-none d-md-table-cell">Date</th>
                    <th class="d-none d-sm-table-cell">Candidate Name</th>
                    <th class="d-none d-sm-table-cell">Type</th>
                    <th class="d-none d-md-table-cell">Amount</th>
                    <th class="d-none d-md-table-cell">Payment Method</th>
                    <th class="d-none d-md-table-cell">Reference</th>
                    <th class="d-none d-md-table-cell">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td class="d-none d-sm-table-cell">
                        <a href="{{ route('booking.edit', $payment->booking_id) }}" 
                           class="text-primary text-decoration-underline hover-effect">
                            {{ $payment->booking_id }}
                        </a>
                    </td>
                    
                    <td class="d-none d-sm-table-cell">{{ date('Y-m-d',strtotime($payment->created_at)) }}</td>
                    <td class="d-none d-sm-table-cell">{{ $payment->booking->candidate ? $payment->booking->candidate->first_name . ' ' . $payment->booking->candidate->last_name : '-' }}</td>
                    <td class="d-none d-md-table-cell">{{ $payment->type}}</td>
                    <td class="d-none d-sm-table-cell">{{ $payment->amount }}</td>
                    <td class="d-none d-sm-table-cell">{{ $payment->payment_method }}</td>
                    <td class="d-none d-sm-table-cell">{{ $payment->reference }}</td>
                    <td class="d-none d-md-table-cell">
                        <span class="badge 
                            @if($payment->status == 'confirmed') bg-success 
                            @elseif($payment->status == 'pending') bg-warning 
                            @elseif($payment->status == 'rejected') bg-danger 
                            @else bg-secondary 
                            @endif">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </td>
                   
                </tr>
                @endforeach

                @if($payments->isEmpty())
                <tr>
                    <td colspan="11" class="text-center text-muted">No payments found.</td>
                </tr>
                @endif
            </tbody>
        </table>
    </div>
</section>


@endsection