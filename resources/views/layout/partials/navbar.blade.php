<header id="navbar" class="top-0 z-10 fixed bg-green-normal lg:bg-transparent shadow-none w-full h-20">
    <div
        class="relative flex lg:flex-row flex-col md:flex-wrap justify-between lg:justify-between md:items-center bg-transparent md:mx-auto md:px-12 py-4 lg:h-20 overflow-hidden">

        <svg class="hidden lg:block absolute z-0 h-20" xmlns="http://www.w3.org/2000/svg" width="1443" height="102"
            viewBox="0 0 1443 102" fill="none">
            <path
                d="M1443 -6C1293.59 -5.99978 1331.25 101.964 1214.99 101.964L228.008 101.964C111.752 101.964 149.412 -5.9996 0 -6L1443 -6Z"
                fill="white" />
        </svg>

        <a href="/" class="z-10 flex items-center gap-2 text-2xl whitespace-nowrap w-fit">
            <img class="h-12" src="{{ asset('assets/images/logo-puncak-tennis-club.webp') }}" alt="">
            {{-- <p class="font-semibold text-white" id="navbar-title">PUNCAK TENNIS CLUB</p> --}}
        </a>

        <!-- Hamburger Menu for Mobile -->
        <input type="checkbox" class="peer hidden" id="navbar-open" />
        <label class="md:hidden top-7 right-8 absolute cursor-pointer" for="navbar-open">
            <span class="sr-only">Toggle Navigation</span>
            <i class="w-6 h-6 text-white fa-solid fa-bars" id="navbar-icon"></i>
        </label>

        <!-- Navigation Menu -->
        <nav aria-label="Header Navigation"
            class="z-10 flex lg:flex-row flex-col lg:items-center bg-green-normal lg:bg-transparent w-full lg:w-auto max-h-0 lg:max-h-full peer-checked:max-h-full peer-checked:pb-4 overflow-hidden transition-all duration-300">
            <ul
                class="flex lg:flex-row flex-col items-center space-y-4 lg:space-x-12 lg:space-y-0 font-poppins font-semibold">
                <li
                    class="text-green-normal border-b-2 border-transparent hover:border-green-normal {{ Request::is('/') ? 'border-green-normal' : '' }}">
                    <a href="/">Home</a>
                </li>
                <li
                    class="text-green-normal border-b-2 border-transparent hover:border-green-normal {{ Request::is('katalog') ? 'border-green-normal' : '' }}">
                    <a href="/booking">Booking</a>
                </li>
                <li
                    class="text-green-normal border-b-2 border-transparent hover:border-green-normal {{ Request::is('photo') ? 'border-green-normal' : '' }}">
                    <a href="#photo">Photo</a>
                </li>
                <li
                    class="text-green-normal border-b-2 border-transparent hover:border-green-normal {{ Request::is('video') ? 'border-green-normal' : '' }}">
                    <a href="/video">Video</a>
                </li>
                <li
                    class="text-green-normal border-b-2 border-transparent hover:border-green-normal {{ Request::is('contact') ? 'border-green-normal' : '' }}">
                    <a href="#contact">Contact</a>
                </li>

                @auth
                    <a href="/admin"
                        class="inline lg:hidden z-10 rounded-full hover:bg-white focus:bg-white px-8 py-2 border-2 border-white hover:text-green-normal hover:border-green-normal focus:border-green-normal text-white">
                        Dashboard
                    </a>
                @else
                    <a class="inline lg:hidden z-10 rounded-full hover:bg-white focus:bg-white px-8 py-2 border-2 border-white hover:text-green-normal hover:border-green-normal focus:border-green-normal text-white cursor-pointer"
                        href="/login">Masuk</a>
                @endauth
            </ul>
        </nav>
        @auth
            <a href="/booking"
                class="lg:inline hidden  z-10 rounded-full hover:bg-white focus:bg-white px-8 py-2 border-2 border-white hover:text-green-normal hover:border-green-normal focus:border-green-normal text-white">
                Dashboard
            </a>
        @else
            <a class="lg:inline hidden  z-10 rounded-full hover:bg-white focus:bg-white px-8 py-2 border-2 border-white hover:text-green-normal hover:border-green-normal focus:border-green-normal text-white cursor-pointer"
                href="/login">Masuk</a>
        @endauth
    </div>
</header>

<script>
    const isGuest = @json(!Auth::check());
    const isHome = @json(Request::is('/'));

    const navbar = document.getElementById('navbar');
    const title = document.getElementById('navbar-title'); // bisa null
    const icon = document.getElementById('navbar-icon');
    const links = document.querySelectorAll('#navbar nav a'); // ambil semua <a> menu
    const svgPath = document.querySelector('#navbar svg path');

    function colorLinks(toWhite) {
        links.forEach(a => {
            if (toWhite) {
                a.classList.add('text-white');
                a.classList.remove('text-green-normal');
            } else {
                a.classList.remove('text-white');
                a.classList.add('text-green-normal');
            }
        });
    }

    function applyNavbarStyle() {
        const scrolledOrInner = (window.scrollY > 100) || (isGuest && !isHome);
        const isDesktop = window.innerWidth >= 1024;

        if (isDesktop) {
            // Desktop: transparan di home-top, hijau kalau scroll>0 atau guest+inner
            if (scrolledOrInner) {
                navbar.classList.remove('lg:bg-transparent');
                navbar.classList.add('lg:bg-green-normal', 'shadow-md');
            } else {
                navbar.classList.remove('lg:bg-green-normal', 'shadow-md');
                navbar.classList.add('bg-transparent');
            }
        } else {
            // Mobile: SELALU HIJAU
            navbar.classList.add('bg-green-normal');
            navbar.classList.remove('bg-transparent');

            // Shadow cuma kalau scroll > 0 / guest+inner
            if (scrolledOrInner) {
                navbar.classList.add('shadow-md');
            } else {
                navbar.classList.remove('shadow-md');
            }
        }

        // title (kalau ada)
        if (title) {
            title.classList.toggle('text-white', scrolledOrInner);
            title.classList.toggle('text-green-normal', !scrolledOrInner);
        }

        // icon hamburger
        if (icon) {
            icon.classList.toggle('text-white', scrolledOrInner);
            icon.classList.toggle('text-green-normal', !scrolledOrInner);
        }

        if (title) {
            const makeTitleWhite = !isDesktop || scrolledOrInner;
            title.classList.toggle('text-white', makeTitleWhite);
            title.classList.toggle('text-green-normal', !makeTitleWhite);
        }

        // ===== ICON HAMBURGER =====
        if (icon) {
            const makeIconWhite = !isDesktop || scrolledOrInner;
            icon.classList.toggle('text-white', makeIconWhite);
            icon.classList.toggle('text-green-normal', !makeIconWhite);
        }

        // ===== LINK COLOR =====
        // Mobile: selalu putih. Desktop: putih kalau scrolledOrInner, hijau kalau home-top.
        const makeLinksWhite = !isDesktop || scrolledOrInner;
        colorLinks(makeLinksWhite);

        // SVG fill
        if (svgPath) {
            svgPath.setAttribute('fill', scrolledOrInner ? '#388132' : 'white');
        }
    }

    window.addEventListener('scroll', applyNavbarStyle, {
        passive: true
    });
    window.addEventListener('load', applyNavbarStyle);
</script>
