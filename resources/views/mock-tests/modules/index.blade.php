@extends('master')

@section('contents')

<section class="w-100 bg-white rounded overflow-hidden mb-4">
    <!-- Section Header -->
    <div class="p-2 px-4 d-flex justify-content-between align-items-center bg-indigo-300">
        <h3 class="text-lg font-semibold">Mock Test Modules List</h3>
        <a href="{{ route('mock-test-modules.create') }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-sky-500 text-white hover:bg-sky-600 transition">
            <i class="fa-solid fa-plus"></i> Create New Module
        </a>
    </div>

    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover border align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Exam Name</th>
                    <th>Slug</th>
                    <th>Module Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($modules as $module)
                <tr>
                    <td>{{ $module->id }}</td>
                    <td>{{ $module->exam?->title ?? '-' }}</td>
                    <td>{{ $module->slug }}</td>
                    <td>{{ $module->name }}</td>
                    <td>
                        <form action="{{ route('mock-test-modules.toggleStatus', $module->id) }}" method="POST">
                            @csrf
                            <div class="form-check form-switch toggle-switch-lg">
                                <input class="form-check-input"
                                    type="checkbox"
                                    onchange="this.form.submit()"
                                    {{ $module->status == 'active' ? 'checked' : '' }}>
                            </div>
                        </form>
                    </td>
                    <td class="flex gap-2">
                        <a href="{{ route('mock-test-modules.edit', $module) }}" class="btn btn-sm btn-success">Edit</a>
                        <form action="{{ route('mock-test-modules.destroy', $module) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-3">
            {{ $modules->links() }}
        </div>
    </div>
</section>

@endsection
