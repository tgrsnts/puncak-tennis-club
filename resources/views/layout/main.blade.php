<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @yield('title', 'Default Title')
    </title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
    <!-- Icons -->
    <script src="https://kit.fontawesome.com/f87eaab4e6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-poppins">
    <!-- Navbar -->
    @include('layout.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layout.partials.footer')

    @stack('scripts')

</body>

</html>
