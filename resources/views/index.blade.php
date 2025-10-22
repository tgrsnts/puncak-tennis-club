@extends('layout.main')
@section('title', 'Home Page')
@section('content')
    <!-- Hero -->
    <section id="hero">
        <div class="relative bg-cover bg-center h-screen"
            style="background-image: url('/assets/images/moises-alex-WqI-PbYugn4-unsplash.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 -bottom-36 flex justify-center drop-shadow-2xl">
                <div class="bg-white p-8 rounded-3xl flex flex-col gap-4">
                    <div class="gap-2">
                        <h1 class="font-semibold text-green-600 text-3xl">Welcome</h1>
                        <p>Book your coaching tennis now!</p>
                    </div>
                    <div class="flex gap-4 border border-gray-400 p-6 rounded-full">
                        <div class="flex items-center gap-4 pr-8">
                            <i class="fa-solid fa-location-dot w-4 text-gray-700"></i>
                            <div class="flex flex-col">
                                <div class="font-bold">Location</div>
                                <div class="text-gray-700">Add Destination</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pr-8">
                            <i class="fa-solid fa-calendar w-4 text-gray-700"></i>
                            <div class="flex flex-col">
                                <div class="font-bold">Date</div>
                                <div class="text-gray-700">Choose Date</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pr-8">
                            <i class="fa-solid fa-user w-4 text-gray-700"></i>
                            <div class="flex flex-col">
                                <div class="font-bold">Coach</div>
                                <div class="text-gray-700">Select Coach</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pr-8">
                            <i class="fa-solid fa-location-dot w-4 text-gray-700"></i>
                            <div class="flex flex-col">
                                <div class="font-bold">Location</div>
                                <div class="text-gray-700">Add Destination</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="h-screen bg-white">

    </section>

    <!-- Testimonial -->
    <section>
        <div class="relative bg-cover bg-center h-screen"
            style="background-image: url('/assets/images/renith-r-MLU_X1d3ofQ-unsplash.jpg');">
            <div class="absolute inset-0 bg-black opacity-50"></div>
            <div class="absolute inset-x-0 flex justify-center drop-shadow-2xl">
                <div class="flex flex-col gap-20 py-20">
                    <div class="font-bold text-white text-4xl">Testimoni</div>
                    <div class="flex gap-8">
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                        <div class="flex flex-col gap-4 bg-white pt-16 p-4 w-80 rounded-lg relative">
                            <img src="{{ asset('/assets/images/Ellipse 7.png') }}" class="w-20 absolute -top-10"
                                alt="">
                            <div class="font-semibold">Tegar Santoso</div>
                            <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Non magnam exercitationem veniam
                                ea, sint aliquid provident reiciendis impedit esse minima!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
