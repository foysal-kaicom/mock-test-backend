@extends('master')

@section('contents')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
    .dataTables_filter {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 600;
        font-size: 18px;
    }

    .dataTables_filter input[type="search"] {
        width: 170px;
        padding: 6px 10px;
        font-size: 14px;
    }

    .dataTables_filter #filterExam {
        width: 130px;
        padding: 6px 10px;
        font-size: 14px;
    }
</style>

<div class="container p-3">
    <div class="mb-4 border-b pb-4 flex justify-between gap-5">
        <h2 class="text-2xl font-semibold text-gray-800 ">Booking List</h2>

        <div class="flex gap-3">
            <!-- Import CSV -->
            {{-- <button
                id="importCsv"
                data-bs-toggle="modal"
                data-bs-target="#importCsvModal"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-sky-500 text-white hover:bg-sky-600 shadow-md transition">
               <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5H13V11H19V13H13V19H11V13H5V11H11Z"></path></svg>
                Import CSV
            </button> --}}

            <!-- Export CSV -->
            <button
                id="exportCsv"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-green-500 text-white hover:bg-green-600 shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4 19H20V12H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V12H4V19ZM14 9V15H10V9H5L12 2L19 9H14Z"></path></svg>
                Export Confirmed CSV
            </button>

            <!-- Export Images -->
            <button
                id="exportImages"
                class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-indigo-500 text-white hover:bg-indigo-600 shadow-md transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M4 19H20V12H22V20C22 20.5523 21.5523 21 21 21H3C2.44772 21 2 20.5523 2 20V12H4V19ZM14 9V15H10V9H5L12 2L19 9H14Z"></path></svg>
                Export Candidate Image
            </button>
        </div>
    </div>


    <table class="min-w-full border border-gray-300 text-sm stripe" id="bookingTable">
        <thead class="bg-indigo-300">
            <tr>
                <th class="px-4 py-3">Booking ID</th>
                <th class="px-4 py-3">Candidate Name</th>
                <th class="px-4 py-3">Examinee Number</th>
                <th class="px-4 py-3">Exam</th>
                <th class="px-4 py-3">Total Payable</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Result</th>
                <th class="px-4 py-3">Payment Status</th>
                <th class="px-4 py-3">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- Populated via DataTables AJAX -->
        </tbody>
    </table>
</div>

<!-- Import CSV Modal -->
<div class="modal fade" id="importCsvModal" tabindex="-1" aria-labelledby="importCsvModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('booking.import.csv') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            {{-- <div class="modal-header">
                <h5 class="modal-title" id="importCsvModalLabel">Import CSV</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body">
                <div class="mb-3">
                    <label for="csv_file" class="form-label">Choose CSV file</label>
                    <input type="file" name="csv_file" id="csv_file" class="form-control" accept=".csv" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Import</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
    </div>
</div>

@push('js')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        let table = $('#bookingTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '{{ route("booking.list") }}',
                data: function(d) {
                    d.status = $('#filterStatus').val();
                    d.exam_id = $('#filterExam').val(); // Send exam_id to the server
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'candidate_name',
                    name: 'candidate_name'
                },
                {
                    data: 'examinee_number',
                    name: 'examinee_number'
                },
                {
                    data: 'exam_title',
                    name: 'exam.title'
                },
                {
                    data: 'total_payable',
                    name: 'total_payable'
                },
                {
                    data: 'status',
                    name: 'status'
                },
                {
                    data: 'result',
                    name: 'result'
                },
                {
                    data: 'payment_status',
                    name: 'payment_status'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],
            initComplete: function() {
                const filter = $('#bookingTable_filter');


                $(document).on('click', '#exportCsv', function() {
                    const statusEl = document.getElementById('filterStatus');
                    const examEl = document.getElementById('filterExam');

                    const status = statusEl.value;
                    const examId = examEl.value;

                    statusEl.style.outline = "none";
                    examEl.style.outline = "none";

                    if (examId == 'all') {
                        alert('Please select exam');
                        examEl.style.outline = "auto red";
                    }
                    else if(status != 'confirmed'){
                        alert('Please select status Confirmed');
                        statusEl.style.outline = "auto red";
                    }
                    else {
                        let url = new URL('{{ route("booking.export.csv") }}', window.location.origin);
                        url.searchParams.append('status', status);
                        url.searchParams.append('exam_id', examId);
                        window.location.href = url.toString();
                    }
                });


                $(document).on('click', '#exportImages', function() {
                    const status = $('#filterStatus').val();
                    const examId = $('#filterExam').val();
                    let url = new URL('{{ route("booking.export.image") }}', window.location.origin);
                    if (status && status !== 'all') url.searchParams.append('status', status);
                    if (examId && examId !== 'all') url.searchParams.append('exam_id', examId);
                    window.location.href = url.toString();
                });

                //Filter Dropdowns (Status, Exam)
                const dropdownHtml = `
                <div class="flex items-center gap-6 ml-6">
                    <!-- Status Dropdown -->
                    <label class="flex text-sm font-medium text-gray-700">
                        <span class="mb-1">Status</span>
                        <select 
                        id="filterStatus" 
                        class="px-3 py-2 rounded-lg border border-gray-300 text-sm shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition">
                        <option value="all" selected>All</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="pending">Pending</option>
                        <option value="cancelled">Cancelled</option>
                        </select>
                    </label>

                    <!-- Exam Dropdown -->
                    <label class="flex text-sm font-medium text-gray-700">
                        <span class="mb-1">Exam</span>
                        <select 
                        id="filterExam" 
                        class="px-3 py-2 rounded-lg border border-gray-300 text-sm shadow-sm bg-white focus:outline-none focus:ring-2 focus:ring-amber-400 focus:border-amber-400 transition">
                        <option value="all" selected>All</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                        @endforeach
                        </select>
                    </label>

                    </div>
            `;

                if (!$('#filterStatus').length && !$('#filterExam').length) {
                    filter.append(dropdownHtml);
                }

                $(document).on('change', '#filterStatus, #filterExam', function() {
                    table.ajax.reload();
                });
            }
        });
    });
</script>


@endpush

@endsection