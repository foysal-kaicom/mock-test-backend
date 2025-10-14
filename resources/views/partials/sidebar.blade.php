<div id="sidebar" class="sidebar p-4 bg-white text-gray-800 min-h-screen space-y-3 shadow-lg overflow-y-auto max-h-screen">
    <div class="flex items-center justify-center border-b pb-2 border-gray-200">
        <img src="{{ asset('logo/logo.png') }}" alt="Logo" class="h-20 w-auto rounded-full">
        <button id="closeSidebar" class="bg-gray-100 rounded-lg p-1.5 hover:bg-gray-200 transition-colors duration-200 md:hidden">
            <i class="fas fa-times text-gray-600 text-sm"></i>
        </button>
    </div>

    <div class="cursor-pointer">
        <a href="{{ route('user.dashboard') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Dashboard</p>
        </a>
    </div>

    <div class="cursor-pointer" data-toggle="candidate">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-users text-indigo-500 text-base"></i>
                <p class="text-sm">Candidates</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-200 space-y-2 text-gray-600 hidden" data-target="candidate">
            <a href="{{ route('candidate.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-user-friends text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">All Candidates</p>
            </a>
            <a href="{{ route('candidate.create') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-user-plus text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">Create New</p>
            </a>
        </div>
    </div>

    {{-- <div class="cursor-pointer" data-toggle="cms">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-broom text-indigo-500 text-base"></i>
                <p class="text-sm">CMS</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-200 space-y-2 text-gray-600 hidden" data-target="cms">
            <a href="{{ route('news.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-newspaper text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">News or Blogs</p>
            </a>
            <a href="{{ route('testimonials.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-comment text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">Testimonials</p>
            </a>
            <a href="{{ route('faq.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-question-circle text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">FAQ</p>
            </a>
        </div>
    </div> --}}


    <div class="cursor-pointer">
        <a href="{{ route('exam.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fas fa-tachometer-alt text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Exams</p>
        </a>
    </div>

    {{-- <div class="cursor-pointer">
        <a href="{{ route('exam.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fas fa-file-alt text-indigo-500 text-base"></i>
            <p class="font-medium text-sm"></p>
        </a>
    </div> --}}

    <div class="cursor-pointer">
        {{-- <a href="{{ route('center.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fas fa-map-marker-alt text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Exam Centers</p>
        </a> --}}
    </div>

    {{-- <div class="cursor-pointer" data-toggle="import">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa fa-cloud-download text-indigo-500 text-base"></i>
                <p class="text-sm">Import</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-200 space-y-2 text-gray-600 hidden" data-target="import">
            <a href="{{ route('booking.import') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-file-arrow-down text-indigo-500 text-base"></i>
                    <p class="font-medium text-sm">Import Booking</p>
            </a>
             <a href="{{ route('import.examinee.csv.view') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-id-card text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Examinee ID Import</p>
            </a>
        
        <a href="{{ route('import.show') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
        <i class="fa-solid fa-file-arrow-down text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Admit/Certificate</p>
            </a>

        <a href="{{ route('import.result.csv') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
        <i class="fa-solid fa-file-csv text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Result</p>
            </a>
        </div>
    </div> --}}

    

    <div class="cursor-pointer">
        {{-- <a href="{{ route('booking.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fa-calendar-days text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Booking</p>
        </a> --}}
    </div>


    {{-- <div class="cursor-pointer">
        <a href="{{ route('payment.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fa-credit-card text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Payments</p>
        </a>
    </div> --}}

    <div class="cursor-pointer">
        {{-- <a href="{{ route('agents.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fa-magnet text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Agents</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('accountings.index') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fa-calculator text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Accountings</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('support.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fas fa-comments text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Support</p>
        </a> --}}
    </div>

    <!-- mock test -->
    <div class="cursor-pointer" data-toggle="mocktest">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                 <i class="fa-solid fa-headphones text-indigo-500 text-base"></i>
                <p class="text-sm">Mock Test</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        
        <div class="mt-1 ml-3 pl-3 border-l border-gray-200 space-y-2 text-gray-600 hidden" data-target="mocktest">

            <a href="{{ route('mock-test-modules.index') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-layer-group text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Modules</p>
            </a>

             <a href="{{ route('mock-tests.module-section.info') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-cubes-stacked text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Sections</p>
            </a>
        
            <a href="{{ route('mock-tests.question.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-regular fa-circle-check text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Questions Setup</p>
            </a>

            <a href="{{ route('mock-tests.reports.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-chart-line text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Mock Test Reports</p>
            </a>

            {{-- <a href="{{ route('demo-questions.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa fa-folder-open text-indigo-500 text-base"></i>
                <p class="font-medium text-sm">Demo Questions</p>
            </a> --}}
        </div>
    </div>


    <div class="cursor-pointer">
        {{-- <a href="{{ route('promotions.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fa-solid fa fas fa-bullhorn text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Promitions</p>
        </a> --}}
    </div>

    <div class="cursor-pointer">
        {{-- <a href="{{ route('certificate-claim.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <i class="fas fa-certificate text-indigo-500 text-base"></i>
            <p class="font-medium text-sm">Certificates</p>
        </a> --}}
    </div>

    <!-- Packages -->
    <div class="cursor-pointer" data-toggle="packages">
        <div class="flex justify-between items-center py-2 px-3 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fa-solid fa-box-open text-indigo-500"></i>
                <p class="text-sm">Packages</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="ml-5 pl-3 border-l border-gray-200 mt-1 space-y-2 text-gray-600 hidden" data-target="packages">
            <a href="{{ route('packages.index') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-list text-indigo-500"></i>
                <p class="text-sm">All Packages</p>
            </a>
            <a href="{{ route('packages.create') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fa-solid fa-plus text-indigo-500"></i>
                <p class="text-sm">Add Package</p>
            </a>
        </div>
    </div>


    <div class="cursor-pointer" data-toggle="account-settings">
        <div class="flex justify-between items-center py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
            <div class="flex items-center gap-2 font-medium">
                <i class="fas fa-cog text-indigo-500 text-base"></i>
                <p class="text-sm">Settings</p>
            </div>
            <i class="fas fa-chevron-down text-gray-500 text-sm drop-arrow transition-transform duration-300 -rotate-90"></i>
        </div>
        <div class="mt-1 ml-3 pl-3 border-l border-gray-200 space-y-2 text-gray-600 hidden" data-target="account-settings">
            <a href="{{ route('user.roles.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-user-shield text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">Role</p>
            </a>
            <a href="{{ route('users.list') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-user text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">User</p>
            </a>
            <a href="{{ route('business-settings.edit', 1) }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-briefcase text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">Business Setting</p>
            </a>
            <!-- <a href="/yo" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-indigo-50 hover:text-indigo-700 transition-colors duration-200">
                <i class="fas fa-key text-indigo-500 text-base"></i>
                <p class="m-0 text-sm">Change Password</p>
            </a> -->
        </div>
    </div>


    <div class="cursor-pointer">

        <a href="{{ route('logout') }}" class="menu-link flex items-center gap-2 py-1.5 px-2 rounded-lg hover:bg-red-50 hover:text-red-700 transition-colors duration-200 w-full text-left">
            <i class="fas fa-sign-out-alt text-red-500 text-base"></i>
            <p class="font-medium text-sm">Logout</p>
        </a>

    </div>
</div>

<style>
    .sidebar {
        box-shadow: 2px 0 10px rgba(0, 0, 0, 0.05);
    }

    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: #f3f4f6;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #c7d2fe;
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: #a5b4fc;
    }

    .menu-link {
        position: relative;
        transition: all 0.2s ease;
    }

    .menu-link:hover {
        transform: translateX(2px);
    }

    .menu-link::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        height: 100%;
        width: 3px;
        background: linear-gradient(180deg, #6366f1 0%, #8b5cf6 100%);
        transform: scaleY(0);
        transition: transform 0.2s ease;
        border-radius: 0 2px 2px 0;
    }

    .menu-link:hover::before {
        transform: scaleY(1);
    }

    .drop-arrow {
        transition: transform 0.3s ease;
    }

    .drop-arrow.rotated {
        transform: rotate(0deg);
    }

    [data-target].hidden {
        display: none;
    }

    [data-target]:not(.hidden) {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Dropdown toggle functionality
        const dropdowns = document.querySelectorAll('[data-toggle]');
        
        dropdowns.forEach(dropdown => {
            const toggleElement = dropdown.querySelector('.flex.justify-between.items-center');
            const targetName = dropdown.getAttribute('data-toggle');
            const content = dropdown.querySelector(`[data-target="${targetName}"]`);
            const arrow = dropdown.querySelector('.drop-arrow');

            if (toggleElement && content) {
                toggleElement.style.cursor = 'pointer';
                
                toggleElement.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Toggle the dropdown
                    if (content.classList.contains('hidden')) {
                        content.classList.remove('hidden');
                        if (arrow) arrow.classList.add('rotated');
                    } else {
                        content.classList.add('hidden');
                        if (arrow) arrow.classList.remove('rotated');
                    }
                });
            }
        });

        // Close sidebar button
        const closeSidebarBtn = document.getElementById('closeSidebar');
        if (closeSidebarBtn) {
            closeSidebarBtn.addEventListener('click', function() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.style.display = 'none';
                }
            });
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />