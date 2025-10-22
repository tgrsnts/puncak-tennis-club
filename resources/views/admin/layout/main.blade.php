<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @yield('title', 'Default Title')
    </title>
    @vite('resources/css/app.css')
    @yield('style')

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/f87eaab4e6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-poppins overflow-x-hidden">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <!-- Navbar -->


    @include('admin.layout.partials.navbar')
    <div class="flex transition-all duration-300">
        @include('admin.layout.partials.sidebar')
        <div id="mainContent" class="mt-20 ml-80 flex flex-col w-full transition-all duration-300">
            @yield('content')
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const navbar = document.getElementById('navbar');
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggle');
            const content = document.getElementById('mainContent');

            if (toggleBtn && sidebar && content) {
                toggleBtn.addEventListener('click', () => {
                    navbar.classList.toggle('pl-80');
                    navbar.classList.toggle('pl-0');
                    sidebar.classList.toggle('-ml-80');
                    content.classList.toggle('ml-80');
                    content.classList.toggle('ml-0');
                });
            }
        });
    </script>



    {{-- @include('admin.layout.partials.footer') --}}

    <!-- Main JS  -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Tailwind Config -->
    {{-- <script src="{{ asset('assets/js/tailwind.config.js') }}"></script>     --}}
</body>

</html>
