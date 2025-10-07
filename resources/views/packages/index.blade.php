@extends('master')

@section('contents')
{{-- <div class="container">
    <h2></h2>
    <a href="{{ route('packages.create') }}" class="btn btn-primary">Create Package</a> --}}



<section class="w-100 bg-white rounded overflow-hidden" style="font-family: sans-serif;">
    <div class="py-3 px-4 d-flex justify-content-between align-items-center bg-indigo-300">
        <h3 class="text-lg font-semibold m-0">Package List</h3>
        <a href="{{ route('packages.create') }}" class="flex items-center gap-2 px-8 py-2 rounded-xl text-sm font-medium bg-sky-500 text-white hover:bg-sky-600 transition">
            <i class="fa-solid fa-plus"></i> Packages
        </a>
    </div>


    <!-- Table --> <div class="table-responsive"> 
        <table class="table table-striped table-hover border align-middle"> 
            <thead> 
                <tr> 
                    <th scope="col" class="text-uppercase text-secondary small px-4 py-3">ID</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Name</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Price</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Details</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Sequence</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Status</th> 
                    <th scope="col" class="text-secondary small px-4 py-3">Actions</th> 
                </tr> 
            </thead> 
            <tbody> 
                @foreach($packages as $package) 
                <tr> 
                    <td class="px-4 py-1">{{ $package->id }}</td> 
                    <td class="px-4 py-1">{{ $package->name }}</td> 
                    <td class="px-4 py-1">{{ $package->price }}</td> 
                    <td class="px-4 py-1">{{ $package->short_description }}</td> 
                    <td class="px-4 py-1">{{ $package->order }}</td>
                    <td class="px-4 py-1"> 
                        @if($package->status) 
                            <span class="badge bg-success">Active</span> 
                        @else 
                            <span class="badge bg-secondary">Inactive</span> 
                        @endif
                    </td> 
                    <td class="px-4 py-1"> 
                        <div class="flex gap-2"> 
                            {{-- <a href="{{ route('packages.show', $package->id) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-blue-500 text-white hover:bg-blue-600 shadow-md transition"> 
                                View 
                            </a>  --}}
                            <a href="{{ route('packages.edit', $package->id) }}" class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-green-500 text-white hover:bg-green-600 shadow-md transition"> 
                                Edit 
                            </a> 
                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this package?')" class="inline"> 
                                @csrf
                                @method('DELETE') 
                                <button class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-medium bg-red-500 text-white hover:bg-red-600 shadow-md transition"> 
                                    Delete 
                                </button> 
                            </form> 
                        </div> 
                    </td> 
                </tr> 
                @endforeach 
            </tbody> 
        </table> 
    </div>
</section>


    
    {{-- <table class="table mt-3">
        <thead>
            <tr>
                <th>Name</th><th>Price</th><th>Details</th><th>Status</th><th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($packages as $package)
            <tr>
                <td>{{ $package->name }}</td>
                <td>{{ $package->price }}</td>
                <td>{{ $package->short_description }}</td>
                <td>{{ $package->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <a href="{{ route('packages.show', $package->id) }}" class="btn btn-info">View</a>
                    <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">Delete</button>
                    </form>

                </td>

            </tr>
        @endforeach
        </tbody>
    </table> --}}
{{-- </div> --}}
@endsection
