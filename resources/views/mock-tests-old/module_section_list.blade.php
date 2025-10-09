@extends('master')

@section('contents')

<section class="bg-white rounded overflow-hidden">
    <!-- Section Header -->
    <div class="p-2 px-4 bg-indigo-300 flex justify-between items-center">
        <h3 class="font-semibold text-lg">Mock Test Modules & Sections</h3>
        <!-- Optionally, you could have a button to add new modules here -->
    </div>

    <style>
        .table {
            width: 100%; /* Ensure the table spans the entire width */
            border-collapse: collapse; /* Collapses the borders into one */
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd; /* Borders for each cell */
        }

        .table th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        .table tbody tr:hover {
            background-color: #f0f0f0; /* Hover effect on rows */
        }

        .table td {
            vertical-align: top; /* Align content at the top */
        }

        .list-unstyled {
            margin: 0;
            padding: 0;
            list-style-type: none;
        }

        .list-unstyled li {
            padding-left: 15px; /* Indentation for sections */
            padding: 8px 0;
        }

        /* Optional: Make the table take almost the full height of the page */
        .table-container {
            height: calc(100vh - 100px); /* Adjust this height based on your needs */
            overflow-y: auto;
        }

        .action-btn {
            background-color: #007bff; /* Blue button */
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 5px;
        }

        .action-btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }

        /* This is to make sure the module cell spans across all its sections */
        .module-name {
            vertical-align: middle;
        }
    </style>

    <!-- Table Container (Scrollable) -->
    <div class="table-container">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-uppercase text-secondary small px-3 py-2">Module</th>
                    <th scope="col" class="text-uppercase text-secondary small px-3 py-2">Sections</th>
                    <th scope="col" class="text-uppercase text-secondary small px-3 py-2">Actions</th> <!-- New column for actions -->
                </tr>
            </thead>
            <tbody>
                @foreach($modules as $module)
                    @foreach($module->sections as $index => $section)
                    <tr>
                        <!-- Module name only once, it spans across all sections under that module -->
                        @if ($index == 0)
                            <td class="module-name" rowspan="{{ count($module->sections) }}">
                                <div class="font-weight-bold">{{ $module->name }}</div>
                            </td>
                        @endif

                        <td class="px-3 py-2">{{ $section->title }}</td>

                        <!-- New Actions column with Edit button -->
                        <td class="px-3 py-2">
                            <a href="{{ route('mock-tests.section.edit', $section->id) }}" class="action-btn">
                                Edit
                            </a>
                        </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
