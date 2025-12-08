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

    {{-- <script>
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
    </script> --}}

    <script>
        // ============================================================================
        // FORM HANDLER - Remove empty inputs before submit
        // ============================================================================
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

        // ============================================================================
        // DATEPICKER COMPONENT
        // ============================================================================

        // DOM Elements
        const datepicker = document.querySelector(".datepicker");
        const dateInput = document.querySelector(".date-input");
        const yearInput = datepicker.querySelector(".year-input");
        const monthInput = datepicker.querySelector(".month-input");
        const cancelBtn = datepicker.querySelector(".cancel");
        const applyBtn = datepicker.querySelector(".apply");
        const nextBtn = datepicker.querySelector(".next");
        const prevBtn = datepicker.querySelector(".prev");
        const dates = datepicker.querySelector(".dates");

        // State
        let selectedDate = new Date();
        let year = selectedDate.getFullYear();
        let month = selectedDate.getMonth();

        // --- Event Listeners ---

        // Show datepicker
        dateInput.addEventListener("click", (e) => {
            e.stopPropagation();
            closeAllDropdowns();
            datepicker.hidden = false;
        });

        // Hide datepicker
        cancelBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            datepicker.hidden = true;
        });

        // Close datepicker on outside click
        document.addEventListener("click", (e) => {
            const datepickerContainer = datepicker.parentNode;
            if (!datepickerContainer.contains(e.target)) {
                datepicker.hidden = true;
            }
        });

        // Apply selected date
        applyBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            console.log(selectedDate);
            dateInput.value = formatDate(selectedDate);
            datepicker.hidden = true;
        });

        // Navigation - Next month
        nextBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            if (month === 11) year++;
            month = (month + 1) % 12;
            displayDates();
        });

        // Navigation - Previous month
        prevBtn.addEventListener("click", (e) => {
            e.stopPropagation();
            if (month === 0) year--;
            month = (month - 1 + 12) % 12;
            displayDates();
        });

        // Month input change
        monthInput.addEventListener("change", (e) => {
            e.stopPropagation();
            month = monthInput.selectedIndex;
            displayDates();
        });

        // Year input change
        yearInput.addEventListener("change", (e) => {
            e.stopPropagation();
            const newYear = parseInt(yearInput.value, 10) || new Date().getFullYear();
            year = Math.min(2100, Math.max(1900, newYear));
            yearInput.value = year;
            displayDates();
        });

        // --- Helper Functions ---

        const formatDate = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, "0");
            const d = String(date.getDate()).padStart(2, "0");
            return `${y}-${m}-${d}`;
        };

        const updateYearMonth = () => {
            monthInput.selectedIndex = month;
            yearInput.value = year;
        };

        const handleDateClick = (e) => {
            e.stopPropagation();
            const button = e.target;

            // Remove 'selected' class from other buttons
            const selected = dates.querySelector(".selected");
            selected && selected.classList.remove("selected");

            // Add 'selected' class to current button
            button.classList.add("selected");

            // Set the selected date
            selectedDate = new Date(year, month, parseInt(button.textContent));
        };

        const createButton = (text, isDisabled = false) => {
            const button = document.createElement("button");
            button.type = "button";
            button.textContent = text;
            button.disabled = isDisabled;

            if (!isDisabled) {
                const buttonDate = new Date(year, month, text).toDateString();
                const today = buttonDate === new Date().toDateString();
                const selected = buttonDate === selectedDate.toDateString();

                button.classList.toggle("today", today);
                button.classList.toggle("selected", selected);
            }

            return button;
        };

        // Render dates in calendar
        const displayDates = () => {
            // Update year & month
            updateYearMonth();

            // Clear existing dates
            dates.innerHTML = "";

            // Display last week of previous month
            const lastOfPrevMonth = new Date(year, month, 0);

            for (let i = 0; i <= lastOfPrevMonth.getDay(); i++) {
                // If last day is Saturday, don't show leading dates
                if (lastOfPrevMonth.getDay() === 6) break;

                const text = lastOfPrevMonth.getDate() - lastOfPrevMonth.getDay() + i;
                const button = createButton(text, true);
                dates.appendChild(button);
            }

            // Display current month
            const lastOfMonth = new Date(year, month + 1, 0);

            for (let i = 1; i <= lastOfMonth.getDate(); i++) {
                const button = createButton(i, false);
                button.addEventListener("click", handleDateClick);
                dates.appendChild(button);
            }

            // Display first week of next month
            const firstOfNextMonth = new Date(year, month + 1, 1);

            for (let i = firstOfNextMonth.getDay(); i < 7; i++) {
                // If first day is Sunday, don't show trailing dates
                if (firstOfNextMonth.getDay() === 0) break;

                const text = firstOfNextMonth.getDate() - firstOfNextMonth.getDay() + i;
                const button = createButton(text, true);
                dates.appendChild(button);
            }
        };

        // Initialize datepicker
        displayDates();

        // ============================================================================
        // CATEGORY DROPDOWN
        // ============================================================================

        const categoryDropdown = document.querySelector(".category-dropdown");
        const categoryTrigger = categoryDropdown.querySelector(".dropdown-trigger");
        const categoryPanel = categoryDropdown.querySelector(".dropdown-panel");
        const categoryInput = document.getElementById("categoryInput");
        const categoryLabel = categoryDropdown.querySelector(".dropdown-label");

        // Toggle category dropdown
        categoryTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = categoryDropdown.classList.contains("open");
            closeAllDropdowns();
            datepicker.hidden = true;
            if (!isOpen) {
                categoryPanel.classList.remove("hidden");
                categoryDropdown.classList.add("open");
            }
        });

        // Select category option
        categoryPanel.querySelectorAll("button").forEach(btn => {
            btn.addEventListener("click", () => {
                const value = btn.dataset.value;
                const text = btn.textContent.trim();

                categoryInput.value = value;
                categoryLabel.innerText = text;

                categoryPanel.classList.add("hidden");
                categoryDropdown.classList.remove("open");
            });
        });

        // ============================================================================
        // PROVINCE DROPDOWN
        // ============================================================================

        const provinceDropdown = document.querySelector(".province-dropdown");
        const provinceTrigger = provinceDropdown.querySelector(".dropdown-trigger");
        const provincePanel = provinceDropdown.querySelector(".dropdown-panel");
        const provinceInput = document.getElementById("provinceInput");
        const provinceLabel = provinceDropdown.querySelector(".dropdown-label");

        // Toggle province dropdownD
        provinceTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = provinceDropdown.classList.contains("open");
            closeAllDropdowns();
            datepicker.hidden = true;
            if (!isOpen) {
                provincePanel.classList.toggle("hidden");
                provinceDropdown.classList.toggle("open");
            }
        });

        // Select province option
        provincePanel.querySelectorAll("button").forEach(btn => {
            btn.addEventListener("click", () => {
                const value = btn.dataset.value;
                const text = btn.textContent.trim();

                provinceInput.value = value;
                provinceLabel.innerText = text;

                provincePanel.classList.add("hidden");
                provinceDropdown.classList.remove("open");

                // Auto-load cities for selected province
                loadCities(value);
            });
        });

        // ============================================================================
        // CITY DROPDOWN
        // ============================================================================

        const cityDropdown = document.querySelector(".city-dropdown");
        const cityTrigger = cityDropdown.querySelector(".dropdown-trigger");
        const cityPanel = document.getElementById("cityDropdownPanel");
        const cityInput = document.getElementById("cityInput");
        const cityLabel = cityDropdown.querySelector(".dropdown-label");

        // Get selected values from hidden inputs (not template syntax)
        const getSelectedCity = () => cityInput.value;
        const getSelectedProvince = () => provinceInput.value;

        // Toggle city dropdown
        cityTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            const isOpen = provinceDropdown.classList.contains("open");
            closeAllDropdowns();
            datepicker.hidden = true;
            if (!isOpen) {
                cityPanel.classList.toggle("hidden");
                cityDropdown.classList.toggle("open");
            }
        });

        // Bind click events to city buttons
        function bindCityClick() {
            cityPanel.querySelectorAll("button").forEach(btn => {
                btn.addEventListener("click", () => {
                    const value = btn.dataset.value;
                    const text = btn.textContent.trim();

                    cityInput.value = value;
                    cityLabel.innerText = text;

                    cityPanel.classList.add("hidden");
                    cityDropdown.classList.remove("open");
                });
            });
        }

        // Load city list based on province
        function loadCities(provinceId) {
            cityPanel.innerHTML = `<button type="button">Loading...</button>`;

            if (!provinceId) {
                cityPanel.innerHTML = `<button type="button" data-value="">Semua Kota</button>`;
                bindCityClick();

                // Only reset if no city is selected
                if (!getSelectedCity()) {
                    cityInput.value = "";
                    cityLabel.innerText = "Semua Kota";
                }
                return;
            }

            fetch(`/provinces/${provinceId}/cities`)
                .then(res => res.json())
                .then(data => {
                    const currentSelectedCity = getSelectedCity();
                    let html = `<button type="button" data-value="">Semua Kota</button>`;

                    data.forEach(city => {
                        html += `
                    <button type="button"
                            data-value="${city.id}"
                            class="${currentSelectedCity == city.id ? 'active' : ''}">
                        ${city.name}
                    </button>
                `;
                    });

                    cityPanel.innerHTML = html;

                    // Re-bind click events
                    bindCityClick();

                    // Sync selected city label
                    if (currentSelectedCity) {
                        const activeBtn = cityPanel.querySelector(`button[data-value="${currentSelectedCity}"]`);
                        if (activeBtn) {
                            cityLabel.innerText = activeBtn.textContent.trim();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error loading cities:', error);
                    cityPanel.innerHTML = `<button type="button" data-value="">Error loading cities</button>`;
                    bindCityClick();
                });
        }

        // Initialize city dropdown on page load if province is selected
        const initialProvince = getSelectedProvince();
        if (initialProvince) {
            loadCities(initialProvince);
        }

        // ============================================================================
        // STATUS DROPDOWN
        // ============================================================================

        const statusDropdown = document.querySelector(".status-dropdown");
        console.log(statusDropdown);

        console.log(
            document.querySelector(".status-dropdown .dropdown-trigger")
        );
        if (statusDropdown) {

            const statusTrigger = statusDropdown.querySelector(".dropdown-trigger");
            const statusPanel = statusDropdown.querySelector(".dropdown-panel");
            const statusInput = document.getElementById("stateInput");
            const statusLabel = statusDropdown.querySelector(".dropdown-label");

            // toggle dropdown
            statusTrigger.addEventListener("click", (e) => {
                e.stopPropagation();

                const isOpen = statusDropdown.classList.contains("open");

                closeAllDropdowns();
                datepicker.hidden = true;

                if (!isOpen) {
                    statusPanel.classList.remove("hidden");
                    statusDropdown.classList.add("open");
                }
            });

            // select option
            statusPanel.querySelectorAll("button").forEach(btn => {
                btn.addEventListener("click", () => {

                    const value = btn.dataset.value;
                    const text = btn.textContent.trim();

                    statusInput.value = value;
                    statusLabel.innerText = text;

                    statusPanel.classList.add("hidden");
                    statusDropdown.classList.remove("open");

                });
            });

        }

        // ============================================================================
        // GLOBAL DROPDOWN HANDLER
        // ============================================================================

        // Close all dropdowns on outside click
        document.addEventListener("click", () => {
            closeAllDropdowns();
            datepicker.hidden = true;
        });

        // Helper function to close all dropdowns
        function closeAllDropdowns() {
            document.querySelectorAll(".custom-dropdown").forEach(dd => {
                dd.classList.remove("open");
                dd.querySelector(".dropdown-panel")?.classList.add("hidden");
            });
        }
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
