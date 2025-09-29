@extends('master')

@section('contents')
<div class="container mx-auto p-4">
    @if($bookings->count()>0)
    <h3 class="text-xl font-semibold p-[12px] mb-[30px] rounded text-black bg-indigo-300">{{optional($bookings[0]->candidate)->full_name}}'s Booking List</h3>

    <div class="overflow-x-auto bg-white shadow rounded-lg">
        <table class="min-w-full divide-y divide-gray-200" id="bookingTable">
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
                @forelse($bookings as $key => $booking)
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
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $booking->payment_status === 'success' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
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
    @else
    <h2 class="text-2xl font-semibold text-gray-300 mb-4 border-b">No booking found</h2>

    @endif
    <div class="pt-4">
        <a class="px-4 py-2 rounded-lg text-sm font-medium bg-indigo-500 text-white hover:bg-indigo-600 shadow-md transition" href="{{route('candidate.list')}}">Back</a>

    </div>

</div>
@endsection
