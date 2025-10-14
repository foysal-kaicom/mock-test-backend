@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden">
    <div class="py-3 px-4 d-flex justify-content-between align-items-center bg-indigo-300">
        <h3 class="text-lg font-semibold m-0">Mock Test Reports</h3>
    </div>

    <!-- Filters -->
    <div class="px-4 py-3 d-flex gap-3 flex-wrap bg-light align-items-center">
        <form id="filterForm" class="d-flex gap-2 flex-wrap align-items-center">
            <select name="candidate_id" class="form-select w-auto">
                <option value="">-- Select Candidate --</option>
                @foreach($candidates as $candidate)
                    <option value="{{ $candidate->id }}">{{ $candidate->full_name }}</option>
                @endforeach
            </select>

            <select name="exam_id" class="form-select w-auto">
                <option value="">-- Select Exam --</option>
                @foreach($exams as $exam)
                    <option value="{{ $exam->id }}">{{ $exam->title }}</option>
                @endforeach
            </select>

            <input type="text" name="date_range" id="date_range" class="form-control w-auto" placeholder="Select Date Range" autocomplete="off">

            <button type="button" id="filterBtn" class="btn btn-primary">Filter</button>
            <button type="button" id="resetBtn" class="btn btn-secondary">Reset</button>
        </form>
    </div>

    <!-- Table -->
    <div class="table-responsive px-4 py-3">
        <table id="reportTable" class="table table-striped table-hover border align-middle">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Candidate</th>
                    <th>Exam</th>
                    {{-- <th>Question Set</th> --}}
                    <th>Results</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</section>

@push('css')
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('js')
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Date Range Picker JS -->
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">

    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>

    <!-- JSZip (for Excel export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- pdfmake (for PDF export) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Buttons HTML5 export -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>




    <script>
        $(document).ready(function() {

            // Date Range Picker
            $('#date_range').daterangepicker({
                autoUpdateInput: false,
                locale: { format: 'YYYY-MM-DD', cancelLabel: 'Clear' },
                ranges: {
                    'Today': [moment(), moment()],
                    'This Week': [moment().startOf('week'), moment().endOf('week')],
                    'Last Week': [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                }
            });

            $('#date_range').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
            });

            $('#date_range').on('cancel.daterangepicker', function() {
                $(this).val('');
            });

            // Initialize DataTable
            var table = $('#reportTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('mock-tests.reports.list') }}",
                    data: function(d) {
                        d.candidate_id = $('select[name=candidate_id]').val();
                        d.exam_id = $('select[name=exam_id]').val();
                        d.date_range = $('#date_range').val();
                    }
                },
                columns: [
                    { data: 'date', name: 'date' },
                    { data: 'candidate', name: 'candidate' },
                    { data: 'exam', name: 'exam' },
                    // { data: 'question_set', name: 'question_set' },
                    { data: 'results', name: 'results', orderable: false, searchable: false }
                ],
                order: [[0, 'desc']],
                pageLength: 25,
                dom: 'Bfrtip', // Add this to show buttons
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: 'Excel',
                        filename: function() {
                            let nameParts = [];
                            let candidate = $('select[name="candidate_id"] option:selected').text();
                            let exam = $('select[name="exam_id"] option:selected').text();
                            let dateRange = $('input[name="date_range"]').val();

                            if (candidate && candidate !== '-- Select Candidate --') nameParts.push(candidate);
                            if (exam && exam !== '-- Select Exam --') nameParts.push(exam);
                            if (dateRange) nameParts.push(dateRange.replace(/\s/g, '')); // remove spaces

                            return nameParts.length ? nameParts.join('_') : 'MockTestReport';
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        filename: function() {
                            let nameParts = [];
                            let candidate = $('select[name="candidate_id"] option:selected').text();
                            let exam = $('select[name="exam_id"] option:selected').text();
                            let dateRange = $('input[name="date_range"]').val();

                            if (candidate && candidate !== '-- Select Candidate --') nameParts.push(candidate);
                            if (exam && exam !== '-- Select Exam --') nameParts.push(exam);
                            if (dateRange) nameParts.push(dateRange.replace(/\s/g, ''));

                            return nameParts.length ? nameParts.join('_') : 'MockTestReport';
                        }
                    },
                    {
                        extend: 'csvHtml5',
                        text: 'CSV',
                        filename: function() {
                            let nameParts = [];
                            let candidate = $('select[name="candidate_id"] option:selected').text();
                            let exam = $('select[name="exam_id"] option:selected').text();
                            let dateRange = $('input[name="date_range"]').val();

                            if (candidate && candidate !== '-- Select Candidate --') nameParts.push(candidate);
                            if (exam && exam !== '-- Select Exam --') nameParts.push(exam);
                            if (dateRange) nameParts.push(dateRange.replace(/\s/g, ''));

                            return nameParts.length ? nameParts.join('_') : 'MockTestReport';
                        }
                    }
                ],
            });

            // Filter button
            $('#filterBtn').click(function() {
                table.ajax.reload();
            });

            // Reset button
            $('#resetBtn').click(function() {
                $('select[name=candidate_id], select[name=exam_id]').val('');
                $('#date_range').val('');
                table.ajax.reload();
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            // Make dropdowns searchable
            $('select[name="candidate_id"], select[name="exam_id"]').select2({
                placeholder: "Select an option",
                allowClear: true,
                width: '200px'  // adjust width as needed
            });

            // Your existing code (daterangepicker, DataTable, etc.)
        });
    </script>
@endpush
@endsection
