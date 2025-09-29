@extends('master')

@section('contents')

<!-- Success Message -->
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

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
            border-color: #bcbcbc;
        }
        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(40,167,69,.25);
        }

    </style>

<section class="w-100 bg-white rounded overflow-hidden">
    <!-- Section Header -->
   <div class="p-2 px-4 d-flex justify-content-between align-items-center" style="background-color: hsla(197, 66%, 81%, 0.879);color:#04070a"> 
        <h3 class="text-md m-0">Users List</h3>
        <a href="{{route('users.create')}}" class="btn btn-primary btn-sm" style=" background-color: hsla(227, 64%, 37%, 0.879);">
            <i class="fa-solid fa-plus" style="font-family: &quot;Font Awesome 6 Free&quot;, Bangla965, sans-serif;"></i> Create New User
        </a>
    </div>
    <!-- Table -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th scope="col" class="text-uppercase text-secondary small">ID</th>
                    <th scope="col" class="d-none d-sm-table-cell text-secondary small">Image</th>
                    <th scope="col" class="d-none d-md-table-cell text-secondary small">User Name</th>
                    <th scope="col" class="d-none d-lg-table-cell text-secondary small text-center">Email</th>
                    <th scope="col" class="d-none d-md-table-cell text-secondary small">Last Login</th>
                    <th scope="col" class="d-none d-sm-table-cell text-secondary small">Status</th>
                    <th scope="col" class="d-none d-md-table-cell text-secondary small">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $admin)
                    <tr>
                        <td>{{ $admin->id }}</td>
                        <td><img src="{{ $admin->image ?? asset('imagePH.png') }}" alt="User Photo" style="width: 60px; height: 60px; border-radius: 50%;"></td>
                        <td class="d-none d-md-table-cell">
                            {{ $admin->name }}
                            
                            <!-- Role Badge -->
                            <span class="badge bg-primary text-white" style="font-size: 0.75rem;">
                                {{ $admin->role_name ?? 'N/A' }}
                            </span>
                        </td>
                        
                        <td class="d-none d-lg-table-cell text-center">{{ $admin->email }}</td>

                        <td class="d-none d-md-table-cell">
                          {{ $admin->last_login ? \Carbon\Carbon::parse($admin->last_login)->format('d M, Y h:i A') : 'Never Logged In' }}
                      </td>
                      <td class="d-none d-sm-table-cell">
                        <form action="{{ route('users.toggleStatus', $admin->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            <div class="form-check form-switch toggle-switch-lg">
                                <input 
                                    type="checkbox" 
                                    class="form-check-input toggle-switch" 
                                    id="userToggle{{ $admin->id }}" 
                                    onchange="if(confirm('Are you sure you want to {{ $admin->status == 'active' ? 'disable' : 'enable' }} this user?')) { this.form.submit(); } else { this.checked = !this.checked; }"
                                    {{ $admin->status == 'active' ? 'checked' : '' }}
                                >
                            </div>
                        </form>
                        
                    </td>
                      
                    <td class="d-none d-md-table-cell">
                    <a href="{{ route('users.edit', $admin->id) }}">
                        <button class="badge text-fs px-4 py-2 border-0 rounded bg-primary">Edit</button>
                    </a>   
                </td>            
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

@endsection
