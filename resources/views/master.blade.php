<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">


    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Sidebar Styling */
        .sidebar {
            width: 270px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            transition: transform 0.3s ease-in-out;
            z-index: 100;
        }

        /* Sidebar Hidden */
        .sidebar.hidden {
            transform: translateX(-100%);
        }

        /* Main Content Styling */
        .main-content {
            width: calc(100% - 270px);
            margin-left: 270px;
            transition: width 0.3s ease-in-out, margin-left 0.3s ease-in-out;
        }

        /* When Sidebar is Hidden */
        .main-content.expanded {
            width: 100%;
            margin-left: 0;
        }

        .hamburg {
            display: none;
        }

        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            border-radius: 50px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 50px;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 50px;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }


        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 270px;
                height: 100vh;
                position: fixed;
                top: 0;
                left: -300px;
                transition: left 0.3s ease-in-out;
            }

            .sidebar.show {
                left: 0;
            }

            .overlay {
                display: none;
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 99;
            }

            .overlay.show {
                display: block;
            }

            .main-content {
                width: 100%;
                margin-left: 0;
            }

            .hamburg {
                display: block;
            }
        }

    </style>

    @stack('css')

</head>

<body class="">
    <div class="overlay" id="overlay"></div>
    <div class="flex w-full">
        <!-- Sidebar -->


        @include('partials.sidebar')

        <!-- Main Content -->
        <div id="mainContent" class="main-content h-screen bg-slate-100">


            @include('partials.header')
            <!-- main content  -->

            <div class="p-4 bg-white min-h-full rounded-xl">
                @yield('contents')
            </div>


        </div>
    </div>

    {{-- <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


 
    <script>
        const sidebar = document.getElementById("sidebar");
        const mainContent = document.getElementById("mainContent");
        const sidebarToggle = document.getElementById("sidebarToggle");
        const closeSidebar = document.getElementById("closeSidebar");
        const overlay = document.getElementById("overlay");

        function showSidebar() {
            sidebar.classList.add("show");
            overlay.classList.add("show");
        }

        function hideSidebar() {
            sidebar.classList.remove("show");
            overlay.classList.remove("show");
        }

        sidebarToggle.addEventListener("click", showSidebar);
        closeSidebar.addEventListener("click", hideSidebar);
        overlay.addEventListener("click", hideSidebar);

        window.addEventListener("resize", function() {
            if (window.innerWidth > 768) {
                hideSidebar();
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const toggles = document.querySelectorAll('[data-toggle]');

            toggles.forEach(toggle => {
                toggle.addEventListener('click', function(e) {
                    // Prevent collapsing when clicking inside content
                    if (e.target.closest('[data-target]')) return;

                    const targetName = toggle.getAttribute('data-toggle');
                    const content = toggle.querySelector(`[data-target="${targetName}"]`);
                    const dropArrow = toggle.querySelector('.drop-arrow')
                    if (content) {
                        content.classList.toggle('hidden');
                        dropArrow.classList.toggle('rotate-180');
                    }
                });
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const currentPath = window.location.pathname;
 
            document.querySelectorAll(".menu-link").forEach(link => {
                if (link.pathname === currentPath) {
                    // Highlight current link
                    link.classList.add("bg-indigo-700", 'text-white');
 
                    // Check if it's inside a collapsible dropdown
                    const dropdownWrapper = link.closest("[data-target]");
                    if (dropdownWrapper) {
                        dropdownWrapper.classList.remove("hidden");
 
                        const parentToggle = dropdownWrapper.closest("[data-toggle]");
                        if (parentToggle) {
                            const dropArrow = parentToggle.querySelector(".drop-arrow");
                            if (dropArrow) {
                                dropArrow.classList.remove("-rotate-90");
                                dropArrow.classList.add("rotate-180");
                            }
                        }
                    }
                }
            });
        });
 
    </script>


    <script src="https://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>

    {!! Toastr::message() !!}

    <script>
        tinymce.init({
            selector: '#content',
            height: 350,
            menubar: false,
            plugins: [
                'advlist autolink lists link image charmap preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | bold italic backcolor | \
                    alignleft aligncenter alignright alignjustify | \
                    bullist numlist outdent indent | removeformat | help',
            forced_root_block: false
        });
    </script>


    @stack('js')
</body>

</html>