<!doctype html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>
        Register
    </title>
    @vite('resources/css/app.css')
    @yield('style')

    <!-- Icons -->
    <script src="https://kit.fontawesome.com/f87eaab4e6.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="font-poppins overflow-x-hidden" data-theme="light">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <main>
        <div class="min-h-screen bg-green-normal grid place-items-center py-8">
            <div
                class="bg-white rounded-3xl shadow-xl overflow-hidden w-full max-w-5xl
              grid grid-cols-1 md:grid-cols-2 md:h-[560px]">
                <div class="p-8 flex flex-col gap-4">
                    <img class="w-20" src="{{ asset('assets/images/puncak-tennisclub-green.png') }}" alt="">
                    @yield('content')
                </div>


                <div class="hidden md:block"> <!-- bisa disembunyikan di mobile -->
                    <img src="{{ asset('assets/images/anastasia-chistik--9Vy4fR_Xo0-unsplash.jpg') }}" alt=""
                        class="w-full h-full object-cover" />
                </div>
            </div>
        </div>

        @if (session('email'))
            <script>
                Swal.fire({
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    title: 'Email atau Password Salah',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    toast: true,
                    position: 'top-end',
                    title: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    title: '{{ session('error') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            </script>
        @endif
    </main>

    <script>
        // place just before </body> or inside DOMContentLoaded
        document.addEventListener('DOMContentLoaded', () => {
            const toggle = document.querySelector('.js-password-toggle');
            const label = document.querySelector('.js-password-label');
            const pwd = document.querySelector('.js-password');

            if (!toggle || !pwd || !label) return;

            // keep aria in-sync and swap icon
            const updateUI = (show) => {
                pwd.type = show ? 'text' : 'password';
                label.setAttribute('aria-pressed', String(show));
                // swap icon (fontawesome example)
                label.innerHTML = show ?
                    '<i class="fa-solid fa-eye-slash" aria-hidden="true"></i>' :
                    '<i class="fa-solid fa-eye" aria-hidden="true"></i>';
            };

            // init (in case)
            updateUI(toggle.checked);

            // react to checkbox changes
            toggle.addEventListener('change', () => updateUI(toggle.checked));

            // support keyboard toggling when label is focused
            label.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    toggle.checked = !toggle.checked;
                    updateUI(toggle.checked);
                }
            });
        });
    </script>

    <!-- Main JS  -->
    <script src="{{ asset('assets/js/app.js') }}"></script>

    <!-- Tailwind Config -->
    {{-- <script src="{{ asset('assets/js/tailwind.config.js') }}"></script>     --}}
</body>

</html>
