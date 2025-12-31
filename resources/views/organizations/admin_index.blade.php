@extends('layouts.admin')

@section('title', 'Organisasi')

@section('content')

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

        <form action="{{ route('admin.organizations.index') }}" method="get" id="filterForm"
            class="mobile-filter hidden
            lg:grid
            grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-7
            gap-3 sm:gap-4
            items-center
            p-4 sm:p-6
            bg-white
            shadow-md
            rounded-xl
            mx-auto my-4
            max-w-[95%]">

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
                    class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400"
                    value="{{ request('name') }}">
            </div>

            <div class="custom-dropdown status-dropdown">

                @php
                    $statusMap = [
                        'pending'  => 'Diproses',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        'blocked'  => 'Diblokir',
                    ];
                @endphp

                <div class="dropdown-trigger">
                    <img src="{{ asset('assets/icons/status.png') }}" class="w-5 h-5">

                    <span class="dropdown-label">
                        {{ $statusMap[request('state')] ?? 'Status' }}
                    </span>

                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                        <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                    </svg>
                </div>

                <input type="hidden" id="stateInput" name="state" value="{{ request('state') }}">

                <div class="dropdown-panel z-1 hidden">
                    <button type="button" data-value="">Status</button>

                    <button type="button" data-value="pending" class="{{ request('state') == 'pending' ? 'active' : '' }}">
                        Diproses
                    </button>

                    <button type="button" data-value="approved" class="{{ request('state') == 'approved' ? 'active' : '' }}">
                        Disetujui
                    </button>

                    <button type="button" data-value="rejected" class="{{ request('state') == 'rejected' ? 'active' : '' }}">
                        Ditolak
                    </button>

                    <button type="button" data-value="blocked" class="{{ request('state') == 'blocked' ? 'active' : '' }}">
                        Diblokir
                    </button>
                </div>

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

    <div x-data="{ showConfirmModal: false, formToSubmit: null }" class="bg-white rounded-lg shadow-sm border mt-5 border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                            Nama</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px]">
                            Deskripsi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Lokasi</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[180px]">
                            Email</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Telepon</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Berdiri</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($organizations as $key => $organization)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-medium text-gray-600">
                                    {{ $key + 1 }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        @if ($organization->profile_picture_url)
                                            <img class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                                src="{{ Storage::disk('s3')->url($organization->profile_picture_url) }}"
                                                alt="{{ $organization->name }}"
                                                onerror="this.src='https://via.placeholder.com/48x48/E5E7EB/9CA3AF?text={{ substr($organization->name, 0, 2) }}'">
                                        @else
                                            <div
                                                class="h-12 w-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-sm font-medium text-gray-600">
                                                    {{ substr($organization->name, 0, 2) }}
                                                </span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="space-y-1">
                                        <div class="font-semibold text-gray-900 leading-tight">
                                            {{ Str::limit($organization->name, 25) }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 leading-relaxed">
                                    {{ Str::limit($organization->description, 60) }}
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-sm font-medium text-gray-900">
                                        <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $organization->city_name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $organization->province_name }}</div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <div>
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            {{ $organization->email }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    @if (isset($organization->phone))
                                        <div class="flex items-center text-sm text-gray-900">
                                            <svg class="w-3 h-3 mr-1 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                            <div>
                                                {{ $organization->phone }}
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500">-</span>
                                    @endif
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    <div class="inline-flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($organization->founded_at)->locale('id')->isoFormat('D MMM YYYY') }}
                                    </div>
                                </div>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($organization->state == 'approved')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Disetujui
                                    </span>
                                @elseif($organization->state == 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Diproses
                                    </span>
                                @elseif($organization->state == 'rejected')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Ditolak
                                    </span>
                                @elseif($organization->state == 'blocked')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-200 text-gray-700 border border-gray-300">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Diblokir
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('admin.organizations.show', ['id' => $organization->id]) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150 group"
                                        title="View Organization">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    {{-- <form action="{{ route('admin.organizations.destroy', ['id' => $organization->id]) }}"
                                        method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            @click="formToSubmit = $el.closest('form'); showConfirmModal = true"
                                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150 group cursor-pointer"
                                            title="Delete Organization">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($organizations->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak terdapat organisasi</h3>
            </div>
        @endif

        @if (method_exists($organizations, 'links'))
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $organizations->links() }}
            </div>
        @endif

        {{-- <div x-show="showConfirmModal" style="display: none;" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-white/30">
            <div @click.away="showConfirmModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Penghapusan</h3>
                <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus organisasi ini? Tindakan ini tidak
                    dapat dibatalkan.</p>
                <div class="flex justify-end gap-4">
                    <button type="button" @click="showConfirmModal = false"
                        class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300 cursor-pointer">
                        Batal
                    </button>
                    <button type="button" @click="formToSubmit.submit()"
                        class="px-4 py-2 bg-[#960018] text-white rounded-lg hover:bg-[#7E191B] transition duration-300 cursor-pointer">
                        Ya, Hapus
                    </button>
                </div>
            </div>
        </div> --}}

    </div>

    {{-- {{ $organizations->links() }} --}}

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

@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3500)"

        x-transition:enter-start="-translate-y-3 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-3 opacity-0"
        
        class="fixed top-20 right-6 z-50"
    >
        <div 
            class="flex items-center gap-3 bg-white border border-green-500 
                   text-green-600 px-5 py-3 rounded-md shadow-lg"
        >
            {{-- CHECK ICON --}}
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="font-medium text-sm">
                {{ session('success') }}
            </span>
        </div>
    </div>
@endif