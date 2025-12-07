@extends('layouts.guest')

@section('title', 'Acara')

@section('content')

    {{-- Hero Section --}}
    <section>
        <div class="py-5 mx-auto max-w-5xl">
            <img src="{{ asset('assets/hero/hero_event.png') }}" alt="">
        </div>
    </section>

    <!-- MOBILE FILTER TOGGLE -->
    <div class="block lg:hidden px-4 mt-4">
        <button id="toggleFilter"
            class="w-full flex justify-between items-center px-4 py-3 bg-white border border-[var(--color1)] rounded-lg shadow-sm">
            <span class="font-medium text-gray-700">Filter Acara</span>
            <svg id="filterArrow" class="w-5 h-5 transition-transform" viewBox="0 0 24 24" fill="none">
                <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" />
            </svg>
        </button>
    </div>

    {{-- Searchbar --}}
    <form action="{{ route('guest.events.index') }}" method="get" id="filterForm"
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
            <input type="text" name="name" placeholder="Masukkan nama acara"
                class="bg-transparent outline-none w-full text-gray-700 placeholder-gray-400" value="{{ request('name') }}">
        </div>

        <!-- Date Picker -->
        <div class="datepicker-container">
            <img src="{{ asset('assets/icons/calendar.png') }}" alt="Tanggal" class="w-5 h-5 flex-shrink-0">
            <input type="text" class="date-input" name="date" placeholder="Pilih Tanggal"
                value="{{ request('date') }}" />

            <div class="datepicker z-1" hidden>
                <!-- .datepicker-header -->
                <div class="datepicker-header">
                    <button class="prev" type="button">Prev</button>

                    <div>
                        <select class="month-input">
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                        </select>
                        <input type="number" class="year-input" min="1900" max="2100" />
                    </div>

                    <button class="next" type="button">Next</button>
                </div>
                <!-- /.datepicker-header -->

                <!-- .days -->
                <div class="days">
                    <span>Sun</span>
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                </div>
                <!-- /.days -->

                <!-- .dates -->
                <div class="dates"></div>
                <!-- /.dates -->

                <!-- .datepicker-footer -->
                <div class="datepicker-footer">
                    <button class="cancel" type="button">Cancel</button>
                    <button class="apply" type="button">Apply</button>
                </div>
                <!-- /.datepicker-footer -->
            </div>
        </div>

        <!-- Kategori Dropdown -->
        <div class="custom-dropdown category-dropdown">

            <div class="dropdown-trigger">
                <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5">

                <span class="dropdown-label">
                    {{ optional($event_categories->firstWhere('id', request('event_category_id')))->name ?? 'Semua Kategori' }}
                </span>

                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" name="event_category_id" id="categoryInput" value="{{ request('event_category_id') }}">

            <div class="dropdown-panel z-1 hidden">
                <button type="button" data-value="">Semua Kategori</button>

                @foreach ($event_categories as $cat)
                    <button type="button" data-value="{{ $cat->id }}"
                        class="{{ request('event_category_id') == $cat->id ? 'active' : '' }}">
                        {{ $cat->name }}
                    </button>
                @endforeach
            </div>

        </div>

        <!-- Province Dropdown -->
        {{-- <div
            class="flex items-center gap-2 px-4 py-2 bg-gray-100 border border-gray-200 rounded-lg w-full md:w-auto focus-within:ring-2 focus-within:ring-[var(--color1)] transition-all">
            <img src="{{ asset('assets/icons/province.png') }}" alt="Provinsi" class="w-5 h-5 flex-shrink-0">
            <select name="province_id" id="province"
                class="bg-transparent outline-none text-gray-700 cursor-pointer appearance-none pr-8 bg-no-repeat bg-right">
                <option value="">Semua Provinsi</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}
        <div class="custom-dropdown province-dropdown">

            <div class="dropdown-trigger" tabindex="0">
                <img src="{{ asset('assets/icons/province.png') }}" class="w-5 h-5">

                <span class="dropdown-label">
                    {{ optional($provinces->firstWhere('id', request('province_id')))->name ?? 'Semua Provinsi' }}
                </span>

                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" name="province_id" id="provinceInput" value="{{ request('province_id') }}">

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
        <!-- CITY DROPDOWN (CUSTOM) -->
        <div class="custom-dropdown city-dropdown">

            <div class="dropdown-trigger" tabindex="0">
                <img src="{{ asset('assets/icons/city.png') }}" class="w-5 h-5">

                <span class="dropdown-label">
                    {{ optional($cities ?? collect())->firstWhere('id', request('city_id'))->name ?? 'Semua Kota' }}
                </span>

                <svg class="arrow" width="16" height="16" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" stroke="#6b7280" stroke-width="2" fill="none" />
                </svg>
            </div>

            <input type="hidden" name="city_id" id="cityInput" value="{{ request('city_id') }}">

            <div class="dropdown-panel z-1 hidden" id="cityDropdownPanel">
                <button type="button" data-value="">Semua Kota</button>
                <!-- Cities will be injected here by AJAX -->
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                            class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <h3 class="font-semibold text-base text-[var(--color2)] mb-2">{{ $event->name }}</h3>
                            
                            {{-- Kategori --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3 object-contain" alt="">
                                <p class="text-[var(--color2)]">{{ $event->event_category->name }}</p>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Lokasi">
                                <p class="text-[var(--color2)]">{{ $event->city->name }}, {{ $event->city->province->name }}</p>
                            </div>

                            {{-- Tanggal & Waktu --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Waktu">
                                <p class="text-[var(--color2)]">{{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
                            </div>

                            {{-- Slot Tersedia --}}
                            <div class="flex items-center text-gray-500 text-xs mb-4">
                                <img src="{{ asset('assets/icons/Crowd.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Slot">
                                <p class="text-[var(--color2)]">Tersedia {{ $event->available_slot - $event->volunteer_count }} slot</p>
                            </div>

                            {{-- Tombol Lihat --}}
                            <div class="flex justify-end">
                                <a href="{{ route('guest.events.show', ['id' => $event->id]) }}"
                                    class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{ $events->links() }}

    <script>
        const selectedCity = "{{ request('city_id') }}";

        $(document).ready(function() {
            $('#province').on('change', function() {
                const provinceId = $(this).val();

                if (provinceId) {
                    $.get(`/provinces/${provinceId}/cities`, function(data) {
                        let options = '<option></option>';
                        data.forEach(city => {
                            options +=
                                `<option value="${city.id}" ${selectedCity == city.id ? 'selected' : ''}>${city.name}</option>`;
                        });
                        $('#city').html(options);
                    });
                } else {
                    $('#city').html('<option></option>');
                }
            });

            if ($('#province').val()) {
                $('#province').trigger('change');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('filterForm');
            if (!form) return;

            form.addEventListener('submit', function() {
                form.querySelectorAll('input[name], select[name]').forEach(el => {
                    if (!el.value || el.value.trim() === '') {
                        el.removeAttribute('name');
                    }
                });
            });
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
