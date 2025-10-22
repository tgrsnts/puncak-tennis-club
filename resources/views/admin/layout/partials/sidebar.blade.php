<nav id="sidebar"
    class="transition-all duration-300 fixed left-0 h-full w-80 bg-green-normal z-11 flex flex-col gap-1 pr-12 font-sans text-base font-normal text-blue-gray-700">
    @php
        $currentRoute = Request::path();
    @endphp

    <div class="flex flex-col justify-between h-full pb-4">
        <div class="flex flex-col gap-1">
            <div class="flex w-64  h-20 justify-center">
                <a href="/" class="flex items-center gap-2 whitespace-nowrap text-2xl">
                    <img class="h-8" src="{{ asset('assets/images/logo-puncak-tennis-club.png') }}" alt="">                    
                </a>
            </div>

            {{-- <a href="/admin"
                class="mt-4 text-white font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white"> --}}
                <a href="/admin"
                    class="mt-4 {{ $currentRoute == 'admin' ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                <div class="flex w-6 h-6 mr-4 items-center justify-center">
                    <i class="fa-solid fa-dashboard"></i>
                </div>
                Dashboard
            </a>

            <a href="/admin/order"
                class="{{ $currentRoute == 'admin/order' ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                <div class="flex w-6 h-6 mr-4 items-center justify-center">
                    <i class="fa-solid fa-list"></i>
                </div>
                Order List
            </a>

            <a href="/admin/gallery-photo"
                class="{{ $currentRoute == 'admin/gallery-photo' ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                <div class="flex w-6 h-6 mr-4 items-center justify-center">
                    <i class="fa-solid fa-image"></i>
                </div>
                Gallery Photo
            </a>

            <a href="/admin/gallery-video"
                class="{{ $currentRoute == 'admin/gallery-video' ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                <div class="flex w-6 h-6 mr-4 items-center justify-center">
                    <i class="fa-solid fa-video"></i>
                </div>
                Gallery Video
            </a>

            <a href="/admin/timetable"
                class="{{ $currentRoute == 'admin/timetable' ? 'text-white bg-yellow-normal' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
                <div class="flex w-6 h-6 mr-4 items-center justify-center">
                    <i class="fa-solid fa-calendar"></i>
                </div>
                Timetable
            </a>

            <form action="" method="POST" id="logout-form">
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
        {{-- <a href="/admin/profile"
            class="{{ $currentRoute == 'admin/staycation' ? 'text-green-normal bg-white' : 'text-white' }} font-poppins font-semibold flex items-center w-full py-4 pl-16 pr-8 leading-tight transition-all rounded-r-lg outline-none text-start hover:bg-yellow-normal hover:text-white focus:bg-yellow-normal focus:text-white active:bg-yellow-normal active:text-white">
            <div class="flex w-12 h-12 mr-4 items-center justify-center">
                <img class="w-full aspect-square rounded-full"
                    src="{{ Auth()->user()->foto ? asset('storage/' . Auth()->user()->foto) : asset('assets/image/avatar-biru.jpg') }}"
                    alt="Foto Profil" />
            </div>
            <flex class="flex-col">
                <p class="font-semibold">{{ Auth()->user()->nama }}</p>
                <p class="text-sm font-normal">Admin</p>
            </flex>
        </a> --}}
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
