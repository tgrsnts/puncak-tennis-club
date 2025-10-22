<header id="navbar" class="transition-all duration-300 fixed pl-80 shadow top-0 w-full h-20 bg-white z-10">
    <div
        class="bg-white relative flex justify-between lg:justify-start flex-col lg:flex-row lg:h-20 overflow-visible px-4 md:pl-12 md:pr-36 md:mx-auto md:flex-wrap md:items-center">

        {{-- <div class="relative flex w-80 justify-center">
            <a href="/" class="flex items-center whitespace-nowrap text-2xl">
                <img class="h-8" src="{{ asset('assets/image/logo-ananta-farm-putih.png') }}" alt="">
            </a>
            <button id="sidebarToggle"
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white hover:text-slate-300 text-2xl focus:outline-none z-10">
                ☰
            </button>
        </div> --}}

        <button id="sidebarToggle"
            class="text-green-normal hover:text-green-darker text-2xl focus:outline-none z-10 hover:cursor-pointer">
            ☰
        </button>



        <!-- Hamburger Menu for Mobile -->
        <input type="checkbox" class="peer hidden" id="navbar-open" />
        <label class="absolute top-7 right-8 cursor-pointer md:hidden" for="navbar-open">
            <span class="sr-only">Toggle Navigation</span>
            <i class="fa-solid fa-bars h-6 w-6 text-white"></i>
        </label>

        <!-- Navigation Menu -->
        <nav aria-label="Header Navigation"
            class="peer-checked:max-h-60 max-h-0 w-full lg:w-auto flex-col flex lg:flex-row lg:max-h-full overflow-visible transition-all duration-300 lg:items-center lg:ml-auto">
            <ul
                class="flex flex-col lg:flex-row lg:space-y-0 space-y-4 gap-2 items-center lg:ml-auto font-poppins font-semibold">                
                <!-- DROPDOWN NOTIF -->
                <li class="relative inline-block text-left">
                    <!-- Trigger -->
                    <button id="notif-toggle"
                        class="relative flex items-center gap-2 text-gray-600 font-medium text-sm hover:bg-gray-300 px-4 py-2 rounded-lg"
                        aria-haspopup="true" aria-expanded="false">
                        <!-- Bell icon (SVG, no dependency) -->
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                            <path
                                d="M12 2a6 6 0 00-6 6v2.268c0 .597-.237 1.17-.659 1.591L4.3 12.9a1 1 0 00.7 1.7h14a1 1 0 00.7-1.7l-1.041-1.041a2.25 2.25 0 01-.659-1.591V8a6 6 0 00-6-6z">
                            </path>
                            <path d="M9 18a3 3 0 006 0H9z"></path>
                        </svg>
                        {{-- <span>Pemberitahuan</span> --}}

                        <!-- Badge -->
                        <span id="notif-badge"
                            class="absolute -top-1 -right-1 text-xs bg-red-600 text-white rounded-full px-1.5 py-0.5 hidden">0</span>

                        <!-- Chevron -->
                        {{-- <svg class="w-4 h-4 ml-1" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                clip-rule="evenodd" />
                        </svg> --}}
                    </button>

                    <!-- Menu -->
                    <div id="notif-menu"
                        class="hidden absolute right-0 mt-2 w-80 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-black/5 focus:outline-none z-50">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 py-2 border-b">
                            <div class="font-semibold">Notifikasi</div>
                            <button id="notif-mark-all" class="text-xs text-green-700 hover:underline">Tandai semua
                                dibaca</button>
                        </div>

                        <!-- List -->
                        <ul id="notif-list" class="max-h-80 overflow-y-auto py-2" role="listbox"
                            aria-label="Daftar Notifikasi">
                            <!-- item di-render via JS -->
                        </ul>

                        <!-- Footer -->
                        <div class="px-4 py-2 border-t text-center">
                            <a href="/notifications" class="text-sm text-green-700 hover:underline">Lihat semua</a>
                        </div>
                    </div>
                </li>

                <script>
                    // ====== DATA & STORAGE ======
                    // Contoh data awal; bisa kamu ganti dari server.
                    const DEFAULT_NOTIFS = [{
                            id: 1,
                            title: "Order #AF-1023 diproses",
                            time: "Baru saja",
                            unread: true,
                            link: "/orders/AF-1023"
                        },
                        {
                            id: 2,
                            title: "Stock bibit kale menipis",
                            time: "10 menit lalu",
                            unread: true,
                            link: "/katalog?alert=stock"
                        },
                        {
                            id: 3,
                            title: "Ada 3 pesan masuk dari mitra",
                            time: "1 jam lalu",
                            unread: false,
                            link: "/admin/messages"
                        },
                    ];

                    const LS_KEY = "notif_items_v1";

                    function getNotifs() {
                        try {
                            const saved = JSON.parse(localStorage.getItem(LS_KEY));
                            return Array.isArray(saved) ? saved : DEFAULT_NOTIFS;
                        } catch {
                            return DEFAULT_NOTIFS;
                        }
                    }

                    function setNotifs(items) {
                        localStorage.setItem(LS_KEY, JSON.stringify(items));
                    }

                    // ====== ELEMENTS ======
                    const notifToggle = document.getElementById("notif-toggle");
                    const notifMenu = document.getElementById("notif-menu");
                    const notifBadge = document.getElementById("notif-badge");
                    const notifList = document.getElementById("notif-list");
                    const markAllBtn = document.getElementById("notif-mark-all");

                    // ====== RENDERING ======
                    function renderBadge(items) {
                        const unread = items.filter(n => n.unread).length;
                        if (unread > 0) {
                            notifBadge.textContent = unread > 99 ? "99+" : unread;
                            notifBadge.classList.remove("hidden");
                        } else {
                            notifBadge.classList.add("hidden");
                        }
                    }

                    function renderList(items) {
                        notifList.innerHTML = "";
                        if (items.length === 0) {
                            notifList.innerHTML = `<li class="px-4 py-4 text-sm text-gray-500 text-center">Tidak ada notifikasi</li>`;
                            return;
                        }

                        items.forEach(n => {
                            const li = document.createElement("li");
                            li.role = "option";
                            li.className = "px-4 py-3 hover:bg-gray-50 transition flex items-start gap-3";
                            li.innerHTML = `
        <div class="mt-1">
          <!-- Dot unread -->
          <span class="inline-block w-2 h-2 rounded-full ${n.unread ? "bg-green-600" : "bg-transparent"}"></span>
        </div>
        <div class="flex-1">
          <a href="${n.link}" class="block text-sm ${n.unread ? "font-semibold text-gray-900" : "text-gray-700"}">
            ${n.title}
          </a>
          <div class="text-xs text-gray-500">${n.time}</div>
        </div>
        <button aria-label="Tandai dibaca" data-id="${n.id}"
                class="shrink-0 text-xs px-2 py-1 rounded hover:bg-gray-100 ${n.unread ? "text-green-700" : "text-gray-400"}">
          ${n.unread ? "Tandai dibaca" : "✓"}
        </button>
      `;
                            notifList.appendChild(li);
                        });
                    }

                    function refreshUI() {
                        const items = getNotifs();
                        renderBadge(items);
                        renderList(items);
                    }

                    // ====== MENU CONTROL ======
                    function openNotifMenu() {
                        notifMenu.classList.remove("hidden");
                        notifToggle.setAttribute("aria-expanded", "true");
                    }

                    function closeNotifMenu() {
                        notifMenu.classList.add("hidden");
                        notifToggle.setAttribute("aria-expanded", "false");
                    }

                    function toggleNotifMenu() {
                        const isOpen = !notifMenu.classList.contains("hidden");
                        isOpen ? closeNotifMenu() : openNotifMenu();
                    }

                    // ====== EVENTS ======
                    // Init
                    refreshUI();

                    // Toggle open/close
                    notifToggle.addEventListener("click", (e) => {
                        e.stopPropagation();
                        toggleNotifMenu();
                    });

                    // Klik di luar -> tutup
                    document.addEventListener("click", (e) => {
                        if (!notifMenu.classList.contains("hidden")) {
                            if (!notifMenu.contains(e.target) && !notifToggle.contains(e.target)) closeNotifMenu();
                        }
                    });
                    document.addEventListener("keydown", (e) => {
                        if (e.key === "Escape") closeNotifMenu();
                    });

                    // Delegation: tandai satu notifikasi dibaca
                    notifList.addEventListener("click", (e) => {
                        const btn = e.target.closest("button[data-id]");
                        if (!btn) return;
                        const id = Number(btn.getAttribute("data-id"));
                        const items = getNotifs().map(n => n.id === id ? {
                            ...n,
                            unread: false
                        } : n);
                        setNotifs(items);
                        refreshUI();
                    });

                    // Tandai semua dibaca
                    markAllBtn.addEventListener("click", () => {
                        const items = getNotifs().map(n => ({
                            ...n,
                            unread: false
                        }));
                        setNotifs(items);
                        refreshUI();
                    });
                </script>


                <!-- DROPDOWN LANGUAGE -->
                <div class="relative inline-block text-left">
                    <!-- Trigger -->
                    <button id="lang-toggle"
                        class="flex items-center gap-2 text-gray-600 font-medium text-sm hover:bg-gray-300 px-4 py-2 rounded-lg"
                        aria-haspopup="true" aria-expanded="false">
                        <img id="lang-flag" src="https://flagcdn.com/w20/id.png" width="20" height="15"
                            alt="ID" class="w-5 h-4">
                        <span id="lang-label">Bahasa Indonesia</span>
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd"
                                d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.25 8.29a.75.75 0 01-.02-1.08z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Menu -->
                    <div id="lang-menu"
                        class="hidden absolute right-0 mt-2 w-48 origin-top-right rounded-lg bg-white shadow-lg ring-1 ring-black/5 focus:outline-none z-50">
                        <button type="button" data-lang="id"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-t-lg">
                            <img src="https://flagcdn.com/w80/id.png" width="20" height="15" alt="Indonesia"
                                class="w-5 h-4">
                            Indonesia
                        </button>
                        <button type="button" data-lang="en"
                            class="w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-b-lg">
                            <img src="https://flagcdn.com/w80/gb.png" width="20" height="15" alt="English (UK)"
                                class="w-5 h-4">
                            English
                        </button>
                    </div>
                </div>

                <script>
                    // --- DATA TERJEMAHAN ---
                    const translations = {
                        id: {
                            profile: "Profil",
                            label: "Bahasa Indonesia",
                            flag: "https://flagcdn.com/w80/id.png"
                        },
                        en: {
                            profile: "Profile",
                            label: "English",
                            flag: "https://flagcdn.com/w80/gb.png"
                        }
                    };

                    // --- ELEMENTS ---
                    const profileText = document.getElementById("profile-text"); // pastikan ada di halamanmu
                    const toggleBtn = document.getElementById("lang-toggle");
                    const menu = document.getElementById("lang-menu");
                    const flagImg = document.getElementById("lang-flag");
                    const labelSpan = document.getElementById("lang-label");

                    function applyLanguage(lang) {
                        const t = translations[lang] || translations.id;
                        if (profileText) profileText.textContent = t.profile;
                        document.documentElement.lang = lang;
                        flagImg.src = t.flag;
                        flagImg.alt = lang.toUpperCase();
                        labelSpan.textContent = t.label;
                    }

                    function setLanguage(lang) {
                        localStorage.setItem("locale", lang);
                        applyLanguage(lang);
                        closeMenu();
                    }

                    function openMenu() {
                        menu.classList.remove("hidden");
                        toggleBtn.setAttribute("aria-expanded", "true");
                    }

                    function closeMenu() {
                        menu.classList.add("hidden");
                        toggleBtn.setAttribute("aria-expanded", "false");
                    }

                    function toggleMenu() {
                        const isOpen = !menu.classList.contains("hidden");
                        isOpen ? closeMenu() : openMenu();
                    }

                    // Init
                    const savedLang = localStorage.getItem("locale") || (navigator.language?.startsWith("id") ? "id" : "en");
                    applyLanguage(savedLang);

                    // Events
                    toggleBtn.addEventListener("click", (e) => {
                        e.stopPropagation();
                        toggleMenu();
                    });

                    // Pilih bahasa (delegation)
                    menu.addEventListener("click", (e) => {
                        const btn = e.target.closest("button[data-lang]");
                        if (!btn) return;
                        setLanguage(btn.getAttribute("data-lang"));
                    });

                    // Klik di luar -> tutup
                    document.addEventListener("click", (e) => {
                        if (!menu.classList.contains("hidden")) {
                            if (!menu.contains(e.target) && !toggleBtn.contains(e.target)) closeMenu();
                        }
                    });

                    // Keyboard: Esc tutup, Arrow nav, Enter pilih
                    document.addEventListener("keydown", (e) => {
                        if (e.key === "Escape") closeMenu();
                    });
                </script>


                <li class="text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300">
                    <a href="/profile" class="flex gap-4 items-center">
                        <img src="{{ asset('/assets/images/avatar-biru.jpg') }}" class="w-8 h-8 rounded-full"
                            alt="">
                        <div>
                            <div>Tegar</div>
                            <div class="text-gray-600 text-xs">Admin</div>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>
