<nav id="sidebar"
    class="-ml-80 lg:ml-0 transition-all duration-300 fixed left-0 h-full w-80 bg-green-normal z-11 flex flex-col gap-1 pr-12 font-sans text-base font-normal text-blue-gray-700">
    <div class="flex flex-col justify-between h-full pb-4">
        <div class="flex flex-col items-between h-full">
            <div class="flex flex-col gap-1">
                <div class="flex w-64  h-20 justify-center">
                    <a href="/" class="flex items-center gap-2 whitespace-nowrap text-2xl">
                        <img class="h-8" src="{{ asset('assets/images/logo-puncak-tennis-club.webp') }}"
                            alt="">
                    </a>
                </div>

                <a href="/booking"
                    class="{{ Request::is('*/booking*') ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                    <div class="flex w-6 h-6 mr-4 items-center justify-center">
                        <i class="fa-solid fa-list"></i>
                    </div>
                    Booking
                </a>

                <a href="/history"
                    class="{{ Request::is('*/history*') ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                    <div class="flex w-6 h-6 mr-4 items-center justify-center">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    Riwayat Booking
                </a>
            </div>

        </div>
        <div class="flex flex-col gap-1">
            @if (Auth()->user())
                @if (Auth()->user()->role == 'admin')
                    <a href="/profile"
                        class="{{ Request::is('*/profile') ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                        <img src="{{ asset('/assets/images/avatar-biru.webp') }}" class="w-8 h-8 mr-4 rounded-full"
                            alt="">
                        <div>
                            <div>{{ Auth()->user()->name }}</div>
                        </div>
                    </a>
                    <a href="{{ route('admin.index') }}"
                        class="lg:hidden {{ Request::is('*/profile') ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                        <div class="flex w-6 h-6 mr-4 items-center justify-center">
                            <i class="fa-solid fa-gear"></i>
                        </div>
                        Admin
                    </a>
                @else
                    <a href="/profile"
                        class="{{ Request::is('*/profile') ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                        <img src="{{ asset('/assets/images/avatar-biru.webp') }}" class="w-8 h-8 mr-4 rounded-full"
                            alt="">
                        <div>
                            <div>{{ Auth()->user()->name }}</div>
                        </div>
                    </a>
                @endif
            @endif

            <form action="{{ route('logout', app()->getLocale()) }}" method="POST" id="logout-form">
                @csrf
                <button type="button" onclick="validatelogout()"
                    class="text-white font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                    <div class="flex w-6 h-6 mr-4 items-center justify-center">
                        <i class="fa-solid fa-right-from-bracket"></i>
                    </div>
                    Log Out
                </button>
            </form>
        </div>
    </div>
    <script>
        function validatelogout() {
            Swal.fire({
                title: 'Apakah anda yakin ingin logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yakin',
                cancelButtonColor: '#fb2c36',
                confirmButtonColor: '#157c74'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</nav>
