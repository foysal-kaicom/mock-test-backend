@extends('master')

@section('contents')

<section class="container py-5">
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <!-- Banner / Header -->
        <div class="relative bg-gradient-to-r from-indigo-500 to-purple-600 h-40">
            <div class="absolute -bottom-12 left-8 flex items-center">
                <img 
                    src="{{ $superAdmin->image ?? asset('assets/imagePH.png') }}" 
                    alt="Profile Picture" 
                    class="w-28 h-28 rounded-full border-4 border-white shadow-lg object-cover"
                >
                <div class="ml-4 text-white">
                    <h2 class="text-2xl font-semibold">{{ $superAdmin->name }}</h2>
                    <p class="text-sm opacity-80 text-blue-800 mt-2">{{ $superAdmin->email }}</p>
                </div>
            </div>
        </div>

        <!-- Profile Details -->
        <div class="pt-16 px-8 pb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Role -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <span class="text-xs font-semibold text-gray-500">Role</span>
                    <p class="mt-1 text-lg">{{ $superAdmin->roles->name ?? 'N/A' }}</p>
                </div>
                <!-- Status -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <span class="text-xs font-semibold text-gray-500">Status</span>
                    <p class="mt-1">
                        <span class="px-3 py-1 rounded-full text-white text-sm
                            {{ $superAdmin->status === 'active' ? 'bg-green-500' : 'bg-gray-400' }}">
                            {{ ucfirst($superAdmin->status) }}
                        </span>
                    </p>
                </div>
                <!-- Last Login -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <span class="text-xs font-semibold text-gray-500">Last Login</span>
                    <p class="mt-1 text-lg">
                        {{ $superAdmin->last_login ? $superAdmin->last_login->diffForHumans(): 'Never' }}
                    </p>
                </div>
                <!-- Last Login IP -->
                <div class="bg-gray-50 p-4 rounded-lg shadow-sm">
                    <span class="text-xs font-semibold text-gray-500">Last Login IP</span>
                    <p class="mt-1 text-lg">{{ $superAdmin->last_login_ip ?? 'N/A' }}</p>
                </div>
            </div>

            <!-- Action Buttons -->
            @hasPermission('super-admin.update')
            <div class="mt-6 flex gap-3">
                <a href="{{ route('users.edit', $superAdmin->id) }}" 
                   class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded-lg shadow transition">
                    Edit Profile
                </a>
                <a href="{{ route('user.dashboard') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2 rounded-lg shadow transition">
                    Back to Dashboard
                </a>
            </div>
            @endHasPermission
        </div>
    </div>
</section>

@endsection
