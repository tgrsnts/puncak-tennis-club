<header id="navbar" class="top-0 z-10 fixed bg-transparent shadow-none w-full h-20">
    <div
        class="relative flex lg:flex-row flex-col md:flex-wrap justify-between lg:justify-start md:items-center bg-transparent md:mx-auto px-4 md:px-36 py-4 lg:h-20 overflow-hidden">
        <a href="/" class="flex items-center gap-2 text-2xl whitespace-nowrap">
            <img class="h-8" src="{{ asset('assets/image/logo-navbar.webp') }}" alt="">
            <p class="font-semibold text-white" id="navbar-title">PUNCAK TENNIS CLUB</p>
        </a>

        <!-- Hamburger Menu for Mobile -->
        <input type="checkbox" class="peer hidden" id="navbar-open" />
        <label class="md:hidden top-7 right-8 absolute cursor-pointer" for="navbar-open">
            <span class="sr-only">Toggle Navigation</span>
            <i class="w-6 h-6 text-white fa-solid fa-bars" id="navbar-icon"></i>
        </label>

        <!-- Navigation Menu -->
        <nav aria-label="Header Navigation"
            class="flex lg:flex-row flex-col lg:items-center bg-transparent lg:ml-auto w-full lg:w-auto max-h-0 lg:max-h-full peer-checked:max-h-60 overflow-hidden transition-all duration-300">
            <ul
                class="flex lg:flex-row flex-col items-center space-y-4 lg:space-y-0 lg:ml-auto font-poppins font-semibold">
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('/') ? 'border-white' : '' }}">
                    <a href="/">Home</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('katalog') ? 'border-white' : '' }}">
                    <a href="/booking">Booking</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('photo') ? 'border-white' : '' }}">
                    <a href="/photo">Photo</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('video') ? 'border-white' : '' }}">
                    <a href="/video">Video</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('contact') ? 'border-white' : '' }}">
                    <a href="/contact">Contact</a>
                </li>
                @auth
                    <li
                        class="hover:bg-white/10 focus:bg-white/10 md:mr-12 px-4 py-2 border-2 border-white hover:border-green-normal focus:border-green-normal text-white">
                        <a href="/admin">Dashboard</a>
                    </li>
                @else
                    <a class="hover:bg-white/10 focus:bg-white/10 md:mr-12 px-4 py-2 border-2 border-white hover:border-green-normal focus:border-green-normal text-white cursor-pointer"
                        href="/login">Masuk</a>
                @endauth
            </ul>
        </nav>
    </div>
</header>

<script>
    const isGuest = @json(!Auth::check());
    const isHome = @json(Request::is('/'));

    const navbar = document.getElementById("navbar");
    const title = document.getElementById("navbar-title");
    const icon = document.getElementById("navbar-icon");
    const links = document.querySelectorAll(".nav-link a");

    function applyNavbarStyle() {
        if (window.scrollY > 20 || (isGuest && !isHome)) {
            navbar.classList.remove("bg-transparent");
            navbar.classList.add("bg-green-normal", "shadow-md");
            title.classList.add("text-white");
            icon.classList.add("text-white");
            links.forEach(link => link.classList.add("text-white"));
        } else {
            navbar.classList.add("bg-transparent");
            navbar.classList.remove("bg-green-normal", "shadow-md");
            title.classList.add("text-white");
            icon.classList.add("text-white");
            links.forEach(link => link.classList.add("text-white"));
        }
    }

    window.addEventListener("scroll", applyNavbarStyle);
    window.addEventListener("load", applyNavbarStyle);
</script>
