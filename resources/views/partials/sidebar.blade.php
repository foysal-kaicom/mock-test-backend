<div id="sidebar" class="sidebar p-4 bg-gray-900 text-gray-100 min-h-screen space-y-3 shadow-lg overflow-y-auto max-h-screen">
    <div class="flex items-center justify-between border-b pb-2 border-gray-700">
        <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="h-10 w-auto rounded-full">
        <button id="closeSidebar" class="bg-gray-700 rounded-lg p-1.5 hover:bg-gray-600 transition-colors duration-200 md:hidden">
            <i class="fas fa-times text-gray-300 text-sm"></i>
        </button>
    </div>

    <div class="cursor-pointer">
        <a href="{{ route('user.dashboard') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Dashboard</p>
        </a>
    </div>

    <div class="cursor-pointer" data-toggle="candidate">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-users text-indigo-400 text-base"></i>
                <p class="text-sm">Candidates</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-2 text-gray-400 hidden" data-target="candidate">
            <a href="{{ route('candidate.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-user-friends text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">All Candidates</p>
            </a>
            <a href="{{ route('candidate.create') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-user-plus text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">Create New</p>
            </a>
        </div>
    </div>

    <div class="cursor-pointer" data-toggle="candidate">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-broom text-indigo-400 text-base"></i>
                <p class="text-sm">CMS</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-2 text-gray-400 hidden" data-target="candidate">
            {{-- <a href="{{ route('news.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-newspaper text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">News or Blogs</p>
            </a> --}}
            {{-- <a href="{{ route('testimonials.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-comment text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">Testimonials</p>
            </a> --}}
            {{-- <a href="{{ route('faq.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-question-circle text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">FAQ</p>
            </a> --}}
        </div>
    </div>

    <div class="cursor-pointer">
        <a href="{{ route('exam.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-file-alt text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Exams</p>
        </a>
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('center.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-map-marker-alt text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Exam Centers</p>
        </a> --}}
    </div>

    <div class="cursor-pointer" data-toggle="candidate">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa fa-cloud-download text-indigo-400 text-base"></i>
                <p class="text-sm">Import</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-2 text-gray-400 hidden" data-target="candidate">
            {{-- <a href="{{ route('booking.import') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-file-arrow-down text-indigo-400 text-base"></i>
                    <p class="font-medium text-sm">Import Booking</p>
            </a> --}}
             {{-- <a href="{{ route('import.examinee.csv.view') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-id-card text-indigo-400 text-base"></i>
                <p class="font-medium text-sm">Examinee ID Import</p>
            </a> --}}
        
        {{-- <a href="{{ route('import.show') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
        <i class="fa-solid fa-file-arrow-down text-indigo-400 text-base"></i>
                <p class="font-medium text-sm">Admit/Certificate</p>
            </a>

        <a href="{{ route('import.result.csv') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
        <i class="fa-solid fa-file-csv text-indigo-400 text-base"></i>
                <p class="font-medium text-sm">Result</p>
            </a> --}}
        </div>
    </div>

    

    <div class="cursor-pointer">
        {{-- <a href="{{ route('booking.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa-calendar-days text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Booking</p>
        </a> --}}
    </div>


    <div class="cursor-pointer">
        <a href="{{ route('payment.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa-credit-card text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Payments</p>
        </a>
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('agents.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa-magnet text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Agents</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('accountings.index') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa-calculator text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Accountings</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('support.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fas fa-comments text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Support</p>
        </a> --}}
    </div>

    <!-- mock test -->
    <div class="cursor-pointer" data-toggle="candidate">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                 <i class="fa-solid fa-headphones text-indigo-400 text-base"></i>
                <p class="text-sm">Mock Test</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-2 text-gray-400 hidden" data-target="candidate">
             <a href="{{ route('mock-tests.module-section.info') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-cubes-stacked text-indigo-400 text-base"></i>
                <p class="font-medium text-sm">Modules & Sections</p>
            </a>
        
        <a href="{{ route('mock-tests.question.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
        <i class="fa-regular fa-circle-check text-indigo-400 text-base"></i>
                <p class="font-medium text-sm">Questions Setup</p>
            </a>

         {{-- <a href="{{ route('demo-questions.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa fa-folder-open text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Demo Questions</p>
        </a> --}}
        </div>
    </div>


    <div class="cursor-pointer">
        {{-- <a href="{{ route('promotions.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fa-solid fa fas fa-bullhorn text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Promitions</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('certificate-claim.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <i class="fas fa-certificate text-indigo-400 text-base"></i>
            <p class="font-medium text-sm">Certificates</p>
        </a> --}}
    </div>

    <div class="cursor-pointer" data-toggle="account-settings">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-cog text-indigo-400 text-base"></i>
                <p class="text-sm">Settings</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-700 space-y-2 text-gray-400 hidden" data-target="account-settings">
            <a href="{{ route('user.roles.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-user-shield text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">Role</p>
            </a>
            <a href="{{ route('users.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-user text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">User</p>
            </a>
            {{-- <a href="{{ route('business-settings.edit', 1) }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-briefcase text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">Business Setting</p>
            </a> --}}
            <!-- <a href="/yo" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fas fa-key text-indigo-400 text-base"></i>
                <p class="m-0 text-sm">Change Password</p>
            </a> -->
        </div>
    </div>
        <!-- Packages -->
    <div class="cursor-pointer" data-toggle="packages">
        <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa-solid fa-box-open text-indigo-400"></i>
                <p class="text-sm">Packages</p>
            </div>
            <i class="fas fa-chevron-down text-gray-400 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="ml-5 pl-3 border-l border-gray-700 mt-1 space-y-2 text-gray-400 hidden" data-target="packages">
            <a href="{{ route('packages.index') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-list text-indigo-400"></i>
                <p class="text-sm">All Packages</p>
            </a>
            <a href="{{ route('packages.create') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-700 hover:text-white transition-colors duration-200">
                <i class="fa-solid fa-plus text-indigo-400"></i>
                <p class="text-sm">Add Package</p>
            </a>
        </div>
    </div>

    <div class="cursor-pointer">

        <a href="{{ route('logout') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-red-600 hover:text-white transition-colors duration-200 w-full text-left">
            <i class="fas fa-sign-out-alt text-red-400 text-base"></i>
            <p class="font-medium text-sm">Logout</p>
        </a>

    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />