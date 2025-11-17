<footer class="px-4 lg:px-36 py-8 bg-green-normal text-white">
    <div class="container mx-auto flex flex-wrap">
        <!-- Kolom Pertama -->
        <div class="w-full lg:w-1/4 lg:pr-4">
            <img src="{{ asset('assets/images/logo-puncak-tennis-club.webp') }}" class="h-8 lg:h-24" alt="">
            {{-- <p class="font-poppins text-white text-justify mb-4">
                Find your tennis place
            </p> --}}
        </div>
        <!-- Kolom Kedua -->
        <div class="w-full h-52 flex flex-col lg:h-auto lg:w-1/4 lg:pl-4">
            <h3 class="text-xl font-poppins font-bold mb-4">Navigation</h3>
            <div class="grid grid-cols-2 gap-2">
                <a href="">Booking</a>
                <a href="">Photo</a>
                <a href="">About</a>
                <a href="">Video</a>
                <a href="">Location</a>
                <a href="">Partner</a>
            </div>
        </div>

        <div class="w-full h-52 lg:h-auto lg:w-1/4 lg:pl-4">
            <h3 class="text-xl font-poppins font-bold mb-4">Hubungi Kami</h3>
            <div class="flex gap-3 items-center mb-4">
                <i class="fa-solid fa-phone w-4"></i>
                <span class="font-poppins">+62 00000000</span>
            </div>
            <div class="flex gap-3 items-center mb-4">
                <i class="fa-solid fa-envelope w-4"></i>
                <span class="font-poppins">puncaktennis@gmail.com</span>
            </div>
            <div class="flex gap-3 items-center mb-4">
                <i class="fa-solid fa-location-dot w-4"></i>
                <span class="font-poppins">Jl. Sindang Subur Jl.Gandamanah, Tugu Sel., Kec. Cisarua, Kabupaten Bogor,
                    Jawa Barat 16750, Indonesia</span>
            </div>
        </div>

        <div class="w-full flex justify-center items-center gap-12 h-52 lg:h-auto lg:w-1/4 lg:pl-4">
            <a
                class="grid place-items-center h-fit p-4 bg-white/20 text-white rounded-full hover:bg-white/30 transition">
                <i class="fa-brands fa-whatsapp w-4"></i>
            </a>
            <a
                class="grid place-items-center h-fit p-4 bg-white/20 text-white rounded-full hover:bg-white/30 transition">
                <i class="fa-brands fa-instagram w-4"></i>
            </a>
            <a
                class="grid place-items-center h-fit p-4 bg-white/20 text-white rounded-full hover:bg-white/30 transition">
                <i class="fa-brands fa-tiktok w-4"></i>
            </a>
        </div>
    </div>
</footer>
