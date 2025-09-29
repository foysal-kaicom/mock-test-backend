@extends('master')

@section('contents')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<style>
    .dataTables_filter {
        display: flex;
        justify-content: space-between;
        align-items: right;
        margin-bottom: 10px;
    }

    .dataTables_filter label {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check-input.toggle-switch {
        width: 3rem;
        height: 1.6rem;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
</style>

<div class="container p-3">
    <h2 class="text-2xl font-semibold text-gray-800 mb-4 border-b pb-2">Candidate List</h2>

    <table class="min-w-full border border-gray-300 text-sm stripe" id="candidateTable">
        <thead class="bg-indigo-300">
            <tr>
                <th class="border border-gray-300 px-4 py-3 text-left">ID</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Photo</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Name</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Email</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Gender</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Phone</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Status</th>
                <th class="border border-gray-300 px-4 py-3 text-left">Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- DataTables will populate this -->
        </tbody>
    </table>
</div>

@push('js')
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(function() {
        let table = $('#candidateTable').DataTable({
            processing: true,
            serverSide: true,
            destroy: true,
            ajax: {
                url: '{{ route("candidate.list") }}',
                data: function(d) {
                    d.status = $('#filterStatus').val(); // Send dropdown value to backend
                    d.living_country = $('#filterLivingCountry').val();
                }
            },
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'photo',
                    name: 'photo'
                },
                {
                    data: 'name',
                    name: 'name',
                    orderable: false,
                    searchable: true
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'gender',
                    name: 'gender'
                },
                {
                    data: 'phone_number',
                    name: 'phone_number'
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ],

            initComplete: function() {
                const filter = $('#candidateTable_filter');
                const dropdownHtml = `
                  <div class="flex items-center gap-2 ml-4">
                        <label for="filterLivingCountry" class="text-sm font-medium text-gray-700 whitespace-nowrap">
                        Living Country:
                        </label>
                        <select id="filterLivingCountry" 
                        class="border border-gray-300 text-sm rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="all">All Countries</option>
                            <option value="Bangladesh">Bangladesh</option>
                            <option value="Japan">Japan</option>
                        </select>
                    </div>
                    <div class="flex items-center gap-2 ml-4">
                        <label for="filterStatus" class="text-sm font-medium text-gray-700 whitespace-nowrap">
                        Candidate Status:
                        </label>
                        <select id="filterStatus" 
                        class="border border-gray-300 text-sm rounded-lg px-3 py-1.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none">
                            <option value="active" selected>Active Candidates</option>
                            <option value="all">All Candidates</option>
                        </select>
                    </div>
                `;

                if (!$('#filterStatus').length) {
                    filter.append(dropdownHtml);
                }

                $(document).on('change', '#filterStatus, #filterLivingCountry', function() {
                    table.ajax.reload();
                });
            }

        });
    });
</script>

<script>
    document.addEventListener('change', function(e) {
        if (!e.target.matches('.toggle-switch')) return;
        const checkbox = e.target;
        const form = checkbox.closest('form');

        if (confirm('Do you want to change status?')) {
            form.submit();
        } else {
            checkbox.checked = !checkbox.checked;
        }
    });
</script>


@endpush

@endsection