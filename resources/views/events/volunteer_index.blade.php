@extends('layouts.volunteer')

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
    <form action="{{ route('volunteer.events.index') }}" method="get" id="filterForm"
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
            class="
        col-span-1
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
        transition-all
        ">
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
                                <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="">
                                <p class="text-[var(--color2)]">{{ $event->event_category->name }}</p>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Lokasi">
                                <p class="text-[var(--color2)]">{{ $event->city->name }},
                                    {{ $event->city->province->name }}</p>
                            </div>

                            {{-- Tanggal & Waktu --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Waktu">
                                <p class="text-[var(--color2)]">
                                    {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
                            </div>

                            {{-- Slot Tersedia --}}
                            <div class="flex items-center text-gray-500 text-xs mb-4">
                                <img src="{{ asset('assets/icons/Crowd.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Slot">
                                <p class="text-[var(--color2)]">Tersedia
                                    {{ $event->available_slot - $event->volunteer_count }} slot</p>
                            </div>

                            {{-- Tombol Lihat --}}
                            <div class="flex justify-end">
                                <a href="{{ route('volunteer.events.show', ['id' => $event->id]) }}"
                                    class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{ $events->links() }}

    {{-- <style>
        :root {
            --color1: #2170B8;
            --color1-soft: #70a0cc;
        }

        /* ---------- INPUT AREA ---------- */

        .datepicker-container {
            position: relative;
            display: inline-block;
            width: 100%;
        }

        /* Icon styling - menggunakan img yang ada */
        .datepicker-container>img {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            opacity: .90;
            pointer-events: none;
            /* z-index: 1; */
        }

        .date-input {
            width: 100%;
            padding: 10px 12px 10px 38px;
            font-size: 0.95rem;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background-color: #f5f5f5;
            outline: none;
            color: #374151;
            cursor: pointer;
        }

        .date-input::placeholder {
            color: #9ca3af;
        }

        .date-input:focus {
            border-color: var(--color1);
            box-shadow: 0 0 0 2px rgba(33, 112, 184, .15);
        }


        /* ---------- DATEPICKER POPUP ---------- */

        .datepicker {
            position: absolute;
            left: 0;
            top: calc(100% + 6px);
            /* z-index: 30; */
            background: #fff;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            width: max-content;
        }


        /* ---------- HEADER ---------- */

        .datepicker-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            gap: 8px;
        }

        .datepicker-header>div {
            display: flex;
            gap: 6px;
        }

        .datepicker-header select,
        .datepicker-header input {
            font-size: 14px;
            padding: 4px 6px;
            border-radius: 6px;
            border: 1px solid #e5e7eb;
            outline: none;
        }

        .datepicker-header select:focus,
        .datepicker-header input:focus {
            border-color: var(--color1);
        }

        .datepicker-header button {
            background: transparent;
            border: none;
            font-weight: 600;
            color: #6b7280;
            cursor: pointer;
            padding: 4px 8px;
        }

        .datepicker-header button:hover {
            color: var(--color1);
        }


        /* ---------- GRID ---------- */

        .days,
        .dates {
            display: grid;
            grid-template-columns: repeat(7, 36px);
            gap: 6px;
            margin-block: 10px;
        }

        .days span {
            font-size: 11px;
            font-weight: 700;
            color: #6b7280;
            text-align: center;
        }


        /* ---------- DATE BUTTON ---------- */

        .dates button {
            border: none;
            background: transparent;
            border-radius: 8px;
            font-size: 13px;
            color: #374151;
            width: 36px;
            height: 36px;
            cursor: pointer;
        }

        .dates button:disabled {
            opacity: .3;
            cursor: not-allowed;
        }

        /* hover */
        .dates button:not(:disabled):hover {
            background: rgba(33, 112, 184, .12);
        }

        /* today style */
        .dates button.today {
            background: var(--color1);
            color: #fff;
        }

        /* selected style */
        .dates button.selected {
            background: var(--color1-soft);
            color: var(--color1);
            font-weight: 600;
        }


        /* ---------- FOOTER ---------- */

        .datepicker-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .datepicker-footer button {
            padding: 6px 14px;
            border-radius: 6px;
            font-size: 12px;
            border: none;
            cursor: pointer;
        }

        /* cancel */
        .cancel {
            background: #f1f5f9;
            color: #374151;
        }

        .cancel:hover {
            background: #e2e8f0;
        }

        /* apply */
        .apply {
            background: var(--color1);
            color: #fff;
        }

        .apply:hover {
            background: #1a5a93;
        }

        /* ===== CUSTOM DROPDOWN ===== */

        .custom-dropdown {
            position: relative;
            width: 100%;
            /* Add this */
        }

        .dropdown-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 10px 12px;
            background: #f9fafb;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            cursor: pointer;
            position: relative;
            /* Add this */
            /* z-index: 2; */
            /* Add this */
        }

        .dropdown-trigger:hover {
            border-color: var(--color1);
        }

        .dropdown-label {
            flex: 1;
            color: #374151;
            font-size: 14px;
            white-space: nowrap;
            /* Add this to prevent text wrapping */
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .arrow {
            transition: .2s;
            flex-shrink: 0;
            /* Add this to prevent arrow from shrinking */
        }

        .custom-dropdown.open .arrow {
            transform: rotate(180deg);
        }

        /* ===== PANEL ===== */

        .dropdown-panel {
            position: absolute;
            top: calc(100% + 6px);
            left: 0;
            right: 0;
            /* Change from width: 100% to right: 0 */
            background: white;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .08);
            overflow: hidden;
            /* z-index: 40; */
            max-height: 300px;
            overflow-y: auto;
        }

        .dropdown-panel button {
            width: 100%;
            padding: 10px 12px;
            text-align: left;
            border: none;
            background: transparent;
            cursor: pointer;
            font-size: 14px;
            transition: background 0.2s ease;
            /* Add smooth transition*/
        }

        .dropdown-panel button:hover {
            background: var(--color1-soft);
            color: var(--color1);
        }

        .dropdown-panel button.active {
            background: var(--color1);
            color: #fff;
        }

        .dropdown-trigger:focus,
        .dropdown-trigger:focus-visible,
        .custom-dropdown.open .dropdown-trigger {
            outline: none;
            border-color: var(--color1);
            box-shadow: 0 0 0 2px rgba(33, 112, 184, .15);
        }

        /* .hidden {
            display: none;
        } */
    </style> --}}

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
    </script> --}}

    {{-- <script>
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
        const datepicker = document.querySelector(".datepicker");
        const dateInput = document.querySelector(".date-input");
        const yearInput = datepicker.querySelector(".year-input");
        const monthInput = datepicker.querySelector(".month-input");
        const cancelBtn = datepicker.querySelector(".cancel");
        const applyBtn = datepicker.querySelector(".apply");
        const nextBtn = datepicker.querySelector(".next");
        const prevBtn = datepicker.querySelector(".prev");
        const dates = datepicker.querySelector(".dates");

        let selectedDate = new Date();
        let year = selectedDate.getFullYear();
        let month = selectedDate.getMonth();

        // show datepicker
        dateInput.addEventListener("click", () => {
            datepicker.hidden = false;
        });

        // hide datepicker
        cancelBtn.addEventListener("click", () => {
            datepicker.hidden = true;
        });

        // close datepicker on outside click
        document.addEventListener("click", (e) => {
            const datepickerContainer = datepicker.parentNode;
            if (!datepickerContainer.contains(e.target)) {
                datepicker.hidden = true;
            }
        });

        const formatDate = (date) => {
            const y = date.getFullYear();
            const m = String(date.getMonth() + 1).padStart(2, "0");
            const d = String(date.getDate()).padStart(2, "0");
            return `${y}-${m}-${d}`;
        };

        // handle apply button click event
        applyBtn.addEventListener("click", () => {
            // set the selected date to date input
            console.log(selectedDate)
            // dateInput.value = selectedDate.toISOString().split("T")[0];
            dateInput.value = formatDate(selectedDate);


            // hide datepicker
            datepicker.hidden = true;
        });

        // handle next month nav
        nextBtn.addEventListener("click", () => {
            if (month === 11) year++;
            month = (month + 1) % 12;
            displayDates();
        });

        // handle prev month nav
        prevBtn.addEventListener("click", () => {
            if (month === 0) year--;
            month = (month - 1 + 12) % 12;
            displayDates();
        });

        // handle month input change event
        monthInput.addEventListener("change", () => {
            month = monthInput.selectedIndex;
            displayDates();
        });

        // handle year input change event
        yearInput.addEventListener("change", () => {
            const newYear = parseInt(yearInput.value, 10) || new Date().getFullYear();
            year = Math.min(2100, Math.max(1900, newYear));
            yearInput.value = year;
            displayDates();
        });

        const updateYearMonth = () => {
            monthInput.selectedIndex = month;
            yearInput.value = year;
        };

        const handleDateClick = (e) => {
            const button = e.target;

            // remove the 'selected' class from other buttons
            const selected = dates.querySelector(".selected");
            selected && selected.classList.remove("selected");

            // add the 'selected' class to current button
            button.classList.add("selected");

            // set the selected date
            selectedDate = new Date(year, month, parseInt(button.textContent));
        };

        // render the dates in the calendar interface
        const displayDates = () => {
            // update year & month whenever the dates are updated
            updateYearMonth();

            // clear the dates
            dates.innerHTML = "";

            //* display the last week of previous month

            // get the last date of previous month
            const lastOfPrevMonth = new Date(year, month, 0);

            for (let i = 0; i <= lastOfPrevMonth.getDay(); i++) {
                // if the last day is Saturday don't show the leading dates
                if (lastOfPrevMonth.getDay() === 6) break;

                const text = lastOfPrevMonth.getDate() - lastOfPrevMonth.getDay() + i;
                const button = createButton(text, true);
                dates.appendChild(button);
            }

            //* display the current month

            // get the last date of the month
            const lastOfMonth = new Date(year, month + 1, 0);

            for (let i = 1; i <= lastOfMonth.getDate(); i++) {
                const button = createButton(i, false);
                button.addEventListener("click", handleDateClick);
                dates.appendChild(button);
            }

            //* display the first week of next month

            const firstOfNextMonth = new Date(year, month + 1, 1);

            for (let i = firstOfNextMonth.getDay(); i < 7; i++) {
                // if the first day starts on Sunday don't show the trailing dates
                if (firstOfNextMonth.getDay() === 0) break;

                const text = firstOfNextMonth.getDate() - firstOfNextMonth.getDay() + i;
                const button = createButton(text, true);
                dates.appendChild(button);
            }
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

        displayDates();
    </script>

    <script>
        const categoryDropdown = document.querySelector(".category-dropdown");
        const categoryTrigger = categoryDropdown.querySelector(".dropdown-trigger");
        const categoryPanel = categoryDropdown.querySelector(".dropdown-panel");
        const categoryInput = document.getElementById("categoryInput");
        const categoryLabel = categoryDropdown.querySelector(".dropdown-label");

        categoryTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            categoryPanel.classList.toggle("hidden");
            categoryDropdown.classList.toggle("open");
        });

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

        /* close dropdown on outside click */
        document.addEventListener("click", () => {
            categoryPanel.classList.add("hidden");
            categoryDropdown.classList.remove("open");
        });
    </script>

    <script>
        const provinceDropdown = document.querySelector(".province-dropdown");
        const provinceTrigger = provinceDropdown.querySelector(".dropdown-trigger");
        const provincePanel = provinceDropdown.querySelector(".dropdown-panel");
        const provinceInput = document.getElementById("provinceInput");
        const provinceLabel = provinceDropdown.querySelector(".dropdown-label");


        provinceTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            // closeAllDropdowns(); // optional helper
            provincePanel.classList.toggle("hidden");
            provinceDropdown.classList.toggle("open");
        });

        provincePanel.querySelectorAll("button").forEach(btn => {
            btn.addEventListener("click", () => {
                const value = btn.dataset.value;
                const text = btn.textContent.trim();

                provinceInput.value = value;
                provinceLabel.innerText = text;

                provincePanel.classList.add("hidden");
                provinceDropdown.classList.remove("open");

                // ✅ Kalau nanti mau autoload kota:
                loadCities(value);
            });
        });

        document.addEventListener("click", () => {
            closeAllDropdowns();
        });

        function closeAllDropdowns() {
            document.querySelectorAll(".custom-dropdown").forEach(dd => {
                dd.classList.remove("open");
                dd.querySelector(".dropdown-panel")?.classList.add("hidden");
            });
        }
    </script>

    <script>
        const selectedCity = "{{ request('city_id') }}";

        const cityDropdown = document.querySelector(".city-dropdown");
        const cityTrigger = cityDropdown.querySelector(".dropdown-trigger");
        const cityPanel = document.getElementById("cityDropdownPanel");
        const cityInput = document.getElementById("cityInput");
        const cityLabel = cityDropdown.querySelector(".dropdown-label");

        /* open / close */
        cityTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            closeAllDropdowns();
            cityDropdown.classList.toggle("open");
            cityPanel.classList.toggle("hidden");
        });

        /* select city */
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

        /* load city list */
        function loadCities(provinceId) {

            cityPanel.innerHTML = `<button type="button">Loading...</button>`;

            if (!provinceId) {
                cityPanel.innerHTML = `<button type="button" data-value="">Semua Kota</button>`;
                bindCityClick();

                cityInput.value = "";
                cityLabel.innerText = "Semua Kota";
                return;
            }

            fetch(`/provinces/${provinceId}/cities`)
                .then(res => res.json())
                .then(data => {
                    let html = `<button type="button" data-value="">Semua Kota</button>`;

                    data.forEach(city => {
                        html += `
                    <button type="button"
                            data-value="${city.id}"
                            class="${selectedCity == city.id ? 'active' : ''}">
                        ${city.name}
                    </button>
                `;
                    });

                    cityPanel.innerHTML = html;

                    // re-bind events
                    bindCityClick();

                    // sync selected on reload
                    if (selectedCity) {
                        const activeBtn = cityPanel.querySelector(`button[data-value="${selectedCity}"]`);
                        if (activeBtn) {
                            cityLabel.innerText = activeBtn.textContent.trim();
                        }
                    }
                });
        }
    </script> --}}

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
