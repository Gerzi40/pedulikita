@extends('layouts.volunteer')

@section('title', 'Organisasi')

@section('content')

    {{-- Hero Section --}}
    <section>
        <div class="px-5 mx-4 lg:mx-auto max-w-5xl">
            <img src="{{ asset('assets/hero/org_event.png') }}" alt="">
        </div>
    </section>

    <!-- MOBILE FILTER TOGGLE -->
    <div class="block lg:hidden px-4 mt-4">
        <button id="toggleFilter"
            class="w-full flex justify-between items-center px-4 py-3 bg-white border border-[var(--color1)] rounded-lg shadow-sm">
            <span class="font-medium text-gray-700">Filter Organisasi</span>
            <svg id="filterArrow" class="w-5 h-5 transition-transform" viewBox="0 0 24 24" fill="none">
                <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" />
            </svg>
        </button>
    </div>

    {{-- Searchbar --}}
    <form action="{{ route('volunteer.organizations.index') }}" method="get" id="filterForm"
        class="mobile-filter hidden
        lg:grid
        grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6
        gap-3 sm:gap-4
        items-center
        p-4 sm:p-6
        bg-white
        shadow-md
        rounded-xl
        mx-auto my-4
        max-w-[90%]">

        <!-- Search Bar -->
        <div
            class="col-span-1
        sm:col-span-2
        md:col-span-3
        lg:col-span-2
        flex items-center gap-2
        px-4 py-2
        bg-gray-100
        border border-gray-200
        rounded-lg
        w-full
        focus-within:ring-2
        focus-within:ring-[var(--color1)]
        transition-all">
            <img src="{{ asset('assets/icons/search.png') }}" alt="Cari" class="w-5 h-5 flex-shrink-0">
            <input type="text" name="name" placeholder="Masukkan nama organisasi"
                class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400" value="{{ request('name') }}">
        </div>

        <!-- Kategori Dropdown -->
        <div class="custom-dropdown category-dropdown">

            <div class="dropdown-trigger">
                <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5">
                <span class="dropdown-label">
                    {{ optional($organization_categories->firstWhere('id', request('organization_category_id')))->name ?? 'Kategori Organisasi' }}
                </span>
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" id="categoryInput" name="organization_category_id"
                value="{{ request('organization_category_id') }}">

            <div class="dropdown-panel z-1 hidden">
                <button type="button" data-value="">Kategori Organisasi</button>

                @foreach ($organization_categories as $cat)
                    <button type="button" data-value="{{ $cat->id }}"
                        class="{{ request('organization_category_id') == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach

            </div>
        </div>


        <!-- Province Dropdown -->
        <div class="custom-dropdown province-dropdown">

            <div class="dropdown-trigger">
                <img src="{{ asset('assets/icons/province.png') }}" class="w-5 h-5">
                <span class="dropdown-label">
                    {{ optional($provinces->firstWhere('id', request('province_id')))->name ?? 'Semua Provinsi' }}
                </span>
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" id="provinceInput" name="province_id" value="{{ request('province_id') }}">

            <div class="dropdown-panel z-1 hidden">
                <button type="button" data-value="">Semua Provinsi</button>

                @foreach ($provinces as $prov)
                    <button type="button" data-value="{{ $prov->id }}"
                        class="{{ request('province_id') == $prov->id ? 'active' : '' }}">
                        {{ $prov->name }}
                    </button>
                @endforeach

            </div>

        </div>

        <!-- City Dropdown -->
        <div class="custom-dropdown city-dropdown">

            <div class="dropdown-trigger">
                <img src="{{ asset('assets/icons/city.png') }}" class="w-5 h-5">
                <span class="dropdown-label">
                    {{ optional($cities ?? collect())->firstWhere('id', request('city_id'))->name ?? 'Semua Kota' }}
                </span>
                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" id="cityInput" name="city_id" value="{{ request('city_id') }}">

            <div class="dropdown-panel z-1 hidden" id="cityDropdownPanel">
                <button type="button" data-value="">Semua Kota</button>
            </div>

        </div>



        <!-- Filter Button -->
        <button type="submit"
            class="w-full
            lg:w-auto
            bg-[var(--color1)]
            text-white
            px-6 py-2.5
            rounded-lg
            font-medium
            shadow
            hover:shadow-md
            transition-all
            hover:bg-[var(--hovercolor1)]
            active:scale-95">
            Cari
        </button>
    </form>

    <section class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-xl font-bold text-[var(--color1)] mb-6">Ayo Eksplor!</h2>
            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6"> {{-- Menyesuaikan grid untuk responsif --}}
                @foreach ($organizations as $org)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Menambahkan rounded-lg dan shadow-md --}}
                        <img src="{{ Storage::disk('s3')->url($org->profile_picture_url) }}" alt="Acara"
                            class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <h3 class="font-bold text-2xl text-[var(--color2)] ">{{ $org->name }}</h3>
                            {{-- Mengubah ukuran font dan menambahkan mb-2 --}}

                            {{-- Lokasi --}}

                            <h1 class="mb-2 font-semibold">
                                {{ count($org->volunteers) }} pengikut
                            </h1>

                            <h1 class="text-md text-gray-600">
                                Sejak {{ \Carbon\Carbon::parse($org->founded_at)->translatedFormat('j F Y') }}
                            </h1>

                            {{-- Tombol Lihat --}}
                            <div class="flex justify-end"> {{-- Menggunakan justify-end untuk memposisikan tombol di kanan --}}
                                <a href="{{ route('volunteer.organizations.show', ['id' => $org->id]) }}"
                                    class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                                {{-- Mengubah button menjadi link a dan menambahkan styling Tailwind --}}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{ $organizations->links() }}

    <script>
        document.addEventListener("DOMContentLoaded", () => {

            // =========================================================================
            // GLOBAL DROPDOWN HANDLER
            // =========================================================================

            function closeAllDropdowns() {
                document.querySelectorAll(".custom-dropdown").forEach(dd => {
                    dd.classList.remove("open");
                    dd.querySelector(".dropdown-panel")?.classList.add("hidden");
                });
            }

            // close all when click outside
            document.addEventListener("click", () => {
                closeAllDropdowns();
            });

            // =========================================================================
            // GENERIC DROPDOWN TOGGLE & SELECT
            // =========================================================================

            document.querySelectorAll(".custom-dropdown").forEach(dropdown => {

                const trigger = dropdown.querySelector(".dropdown-trigger");
                const panel = dropdown.querySelector(".dropdown-panel");
                const input = dropdown.querySelector("input[type='hidden']");
                const label = dropdown.querySelector(".dropdown-label");

                if (!trigger || !panel || !input || !label) return;

                // --- toggle dropdown ---
                trigger.addEventListener("click", (e) => {
                    e.stopPropagation();

                    const isOpen = dropdown.classList.contains("open");

                    closeAllDropdowns();

                    if (!isOpen) {
                        dropdown.classList.add("open");
                        panel.classList.remove("hidden");
                    }
                });

                // --- option select ---
                panel.addEventListener("click", (e) => {
                    const btn = e.target.closest("button");
                    if (!btn) return;

                    e.stopPropagation();

                    const value = btn.dataset.value ?? "";
                    const text = btn.textContent.trim();

                    // set hidden input
                    input.value = value;
                    label.textContent = text;

                    // active class
                    panel.querySelectorAll("button").forEach(b => {
                        b.classList.remove("active");
                    });
                    btn.classList.add("active");

                    dropdown.classList.remove("open");
                    panel.classList.add("hidden");
                });

            });


            // =========================================================================
            // PROVINCE → CITY LOADER
            // =========================================================================

            const provinceInput = document.getElementById("provinceInput");
            const cityInput = document.getElementById("cityInput");
            const cityLabel = document.querySelector(".city-dropdown .dropdown-label");
            const cityPanel = document.getElementById("cityDropdownPanel");

            if (provinceInput && cityInput && cityPanel) {

                async function loadCities(provinceId) {

                    cityPanel.innerHTML = `<button type="button">Loading...</button>`;

                    // reset city
                    if (!provinceId) {
                        cityPanel.innerHTML =
                            `<button type="button" data-value="">Semua Kota</button>`;

                        cityInput.value = "";
                        cityLabel.textContent = "Semua Kota";

                        return;
                    }

                    try {

                        const res = await fetch(`/provinces/${provinceId}/cities`);
                        const data = await res.json();

                        const currentCity = cityInput.value;

                        let html = `<button type="button" data-value="">Semua Kota</button>`;

                        data.forEach(city => {
                            html += `
                        <button type="button"
                            data-value="${city.id}"
                            class="${currentCity == city.id ? 'active' : ''}">
                            ${city.name}
                        </button>
                    `;
                        });

                        cityPanel.innerHTML = html;

                        // sync label on reload
                        if (currentCity) {
                            const activeBtn =
                                cityPanel.querySelector(`button[data-value="${currentCity}"]`);
                            if (activeBtn) {
                                cityLabel.textContent = activeBtn.textContent.trim();
                            }
                        }

                    } catch (err) {
                        console.error("Load cities error:", err);
                        cityPanel.innerHTML =
                            `<button type="button" data-value="">Gagal load kota</button>`;
                    }
                }

                // when province changes
                provinceInput.addEventListener("change", (e) => {
                    loadCities(e.target.value);
                });

                // auto load on page load if province is selected
                if (provinceInput.value) {
                    loadCities(provinceInput.value);
                }

                // change event triggered when select province via dropdown
                document
                    .querySelector(".province-dropdown .dropdown-panel")
                    ?.addEventListener("click", () => {
                        provinceInput.dispatchEvent(new Event("change"));
                    });
            }

            // =========================================================================
            // FORM SUBMIT HANDLER
            // =========================================================================

            const form = document.getElementById("filterForm");

            if (form) {
                form.addEventListener("submit", () => {
                    form
                        .querySelectorAll("input[name], select[name]")
                        .forEach(el => {
                            if (!el.value || el.value.trim() === "") {
                                el.removeAttribute("name");
                            }
                        });
                });
            }

        });
    </script>

    <script>
        const toggleBtn = document.getElementById('toggleFilter');
        const filterForm = document.getElementById('filterForm');
        const arrow = document.getElementById('filterArrow');

        toggleBtn.addEventListener('click', () => {
            filterForm.classList.toggle('hidden');
            arrow.classList.toggle('rotate-180');
        });
    </script>

@endsection
