<header class="flex items-center justify-between p-2 bg-slate-100">
    <div class="flex gap-2 items-center">
        <button id="sidebarToggle" class="hamburg p-2 bg-slate-100 rounded-md hover:bg-slate-50 duration-300 drop-shadow-sm">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
                <path d="M3 4H21V6H3V4ZM3 11H21V13H3V11ZM3 18H21V20H3V18Z"></path>
            </svg>
        </button>
        <h1 class="text-2xl font-[900]">{{ env('APP_NAME') }}</h1>
    </div>


    <div class="flex gap-3 items-center text-gray-600">
        <div class="text-xs">
            <p class="px-2 py-[2px] border rounded border mb-1">{{auth()->user()->name}}</p>
        </div>

        <!-- User Profile Dropdown -->
        <div class="dropdown">
            <img src="{{auth()->user()->image}}" alt="User" class="rounded-circle border dropdown-toggle"
                data-bs-toggle="dropdown" aria-expanded="false" style="width: 40px; height: 40px; cursor: pointer;">
            <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="{{route('users.profile')}}">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="{{route('logout')}}">Logout</a></li>
            </ul>
        </div>
    </div>
</header>