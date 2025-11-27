    <header id="navbar" class="transition-all duration-300 fixed lg:pl-80 shadow top-0 w-full h-20 bg-white z-10">
        <div
            class="bg-white relative flex justify-between lg:justify-start flex-col lg:flex-row lg:h-20 overflow-visible px-4 md:pl-12 md:pr-36 md:mx-auto md:flex-wrap md:items-center">

            <div class="relative flex w-full lg:w-fit justify-center lg:justify-start items-center">
                <a href="/" class="lg:hidden flex items-center whitespace-nowrap text-2xl">
                    <img class="w-32" src="{{ asset('assets/images/puncak-tennisclub-green.webp') }}" alt="">
                </a>
                <button id="sidebarToggle"
                    class="h-20 w-full lg:w-fit  flex items-center justify-end lg:justify-start text-green-normal hover:text-green-darker text-2xl focus:outline-none z-10 hover:cursor-pointer">
                    ☰
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav aria-label="Header Navigation"
                class="hidden peer-checked:max-h-60 max-h-0 w-full lg:w-auto flex-col lg:flex lg:flex-row lg:max-h-full overflow-visible transition-all duration-300 lg:items-center lg:ml-auto">
                <ul
                    class="flex flex-col lg:flex-row lg:space-y-0 space-y-4 gap-2 items-center lg:ml-auto font-poppins font-semibold">
                    @if (Auth()->user())
                        <li class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                            @if (Auth()->user()->role == 'admin')
                                <div class="flex gap-4 items-center">
                                    <a href="/profile">
                                        <img src="{{ asset('/assets/images/avatar-biru.webp') }}"
                                            class="w-8 h-8 rounded-full" alt="">
                                    </a>

                                    <div class="flex flex-col">
                                        <a href="/profile" class="font-medium">
                                            {{ Auth()->user()->name }}
                                        </a>

                                        <a href="{{ route('admin.index') }}"
                                            class="text-xs text-gray-500 hover:text-gray-700">
                                            Admin
                                        </a>
                                    </div>
                                </div>
                            @else
                                <a href="/profile" class="flex gap-4 items-center">
                                    <img src="{{ asset('/assets/images/avatar-biru.webp') }}" class="w-8 h-8 rounded-full"
                                        alt="">
                                    <div>
                                        <div>{{ Auth()->user()->name }}</div>
                                    </div>
                                </a>
                            @endif
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </header>
