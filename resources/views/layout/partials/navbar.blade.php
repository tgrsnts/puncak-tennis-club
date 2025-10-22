<header class="top-0 z-10 fixed bg-transparent shadow-none w-full h-20">
    <div
        class="relative flex lg:flex-row flex-col md:flex-wrap justify-between lg:justify-start md:items-center bg-transparent md:mx-auto px-4 md:px-36 py-4 lg:h-20 overflow-hidden">
        <a href="/" class="flex items-center gap-2 text-2xl whitespace-nowrap">
            <img class="h-8" src="{{ asset('assets/image/logo-navbar.png') }}" alt="">
            <p class="font-semibold text-white">PUNCAK TENNIS CLUB</p>
        </a>

        <!-- Hamburger Menu for Mobile -->
        <input type="checkbox" class="peer hidden" id="navbar-open" />
        <label class="md:hidden top-7 right-8 absolute cursor-pointer" for="navbar-open">
            <span class="sr-only">Toggle Navigation</span>
            <i class="w-6 h-6 text-white fa-solid fa-bars"></i>
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
                    <a href="/katalog">Booking</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('photo') ? 'border-white' : '' }}">
                    <a href="/staycation">Photo</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('video') ? 'border-white' : '' }}">
                    <a href="/staycation">Video</a>
                </li>
                <li
                    class="text-white border-b-2 border-transparent md:mr-12 hover:border-white {{ Request::is('contact') ? 'border-white' : '' }}">
                    <a href="/staycation">Contact</a>
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
