@extends('master')

@section('contents')

<style>
    .toggle-switch-lg .form-check-input {
        width: 3rem;
        height: 1.5rem;
        cursor: pointer;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    .form-check-input:not(:checked) {
        background-color: #ffffff;
        border-color: #777272;
    }

    .form-check-input:focus {
        box-shadow: 0 0 0 0.2rem rgba(40,167,69,.25);
    }

</style>

<section class="w-100 bg-white rounded overflow-hidden">
    <!-- Section Header -->
    <div class="p-2 px-4 d-flex justify-content-between align-items-center" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a">
        <h3 class="text-md m-0">Role List</h3>
        @hasPermission('user.roles.create')
        <a href="{{ route('user.roles.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> Create New Role
        </a>
        @endHasPermission 
    </div>


    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-uppercase text-secondary small">ID</th>
                    <th scope="col" class="d-none d-sm-table-cell text-uppercase text-secondary small">Name</th>
                    <th scope="col" class="d-none d-md-table-cell text-uppercase text-secondary small">Status</th>
                    <th scope="col" class="d-none d-md-table-cell text-uppercase text-secondary small">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td class="d-none d-sm-table-cell">
                       {{ $role->name }}
                    </td>
                    <td class="d-none d-md-table-cell">
                        @hasPermission('user.roles.toggleStatus')
                        <form action="{{ route('user.roles.toggleStatus', $role->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <div class="form-check form-switch toggle-switch-lg">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input toggle-switch" 
                                    id="roleToggle{{ $role->id }}" 
                                    onchange="if(confirm('Are you sure you want to {{ $role->status == 'active' ? 'disable' : 'enable' }} this role?')) { this.form.submit(); } else { this.checked = !this.checked; }"
                                    {{ $role->status == 'active' ? 'checked' : '' }}
                                >
                            </div>
                        </form>
                        @endHasPermission 
                    </td>
                    <td class="d-none d-md-table-cell">
                        @hasPermission('user.roles.edit')
                        <a href="{{ route('user.roles.edit', $role->id) }}" class="badge p-2 bg-success text-white" style="width: 80px">Edit</a>
                        @endHasPermission 
                    </td>
                    
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</section>

@endsection