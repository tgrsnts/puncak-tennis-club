<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        @yield('title', 'Default Title')
    </title>
    @vite('resources/css/app.css')

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

    <!-- Main JS  -->
    <script src="{{ asset('assets/js/app.js') }}"></script>


    <!-- Tailwind Config -->
    {{-- <script src="{{ asset('assets/js/tailwind.config.js') }}"></script>     --}}

    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sections = document.querySelectorAll("section");
            // const navDivs = document.querySelectorAll("nav div div");
            // const navLinks = document.querySelectorAll("nav div div a");
            const navLinks = document.querySelectorAll("header div nav ul li a");

            window.addEventListener("scroll", handleNavbar);

            function handleNavbar() {
                // let current = "";

                // sections.forEach(section => {
                //     const sectionTop = section.offsetTop;
                //     if (pageYOffset >= sectionTop - 50) {
                //         current = section.getAttribute("id");
                //     }
                // });

                // navDivs.forEach(div => {
                //     div.classList.remove("border-red-600");
                // });

                // navLinks.forEach(link => {
                //     if (link.getAttribute("href").includes(current)) {
                //         link.parentElement.classList.add("border-red-600");
                //     }
                // });

                let current = "";

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    if (pageYOffset >= sectionTop - 50) {
                        current = section.getAttribute("id");
                    }
                });

                navLinks.forEach(link => {
                    // link.classList.remove("border-white");
                    link.parentElement.classList.remove("border-white");
                    if (link.getAttribute("href").includes(current)) {
                        // link.classList.add("border-white");
                        link.parentElement.classList.add("border-white");
                    }
                });
            }
        });
    </script> --}}
</body>

</html>
