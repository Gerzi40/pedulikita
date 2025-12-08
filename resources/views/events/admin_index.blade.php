@extends('layouts.admin')

@section('title', 'Acara')

@section('content')

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

    <form action="{{ route('admin.events.index') }}" method="get" id="filterForm"
        class="mobile-filter hidden
        lg:grid
        grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-8
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
            {{-- <button type="submit" class="text-blue-500 flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button> --}}
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

        <div class="custom-dropdown status-dropdown">

            <div class="dropdown-trigger">
                <img src="{{ asset('assets/icons/status.png') }}" class="w-5 h-5">

                <span class="dropdown-label">
                    {{ ucfirst(request('state')) ?: 'Status' }}
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

                <button type="button" data-value="finished" class="{{ request('state') == 'finished' ? 'active' : '' }}">
                    Selesai
                </button>

                <button type="button" data-value="reviewed" class="{{ request('state') == 'reviewed' ? 'active' : '' }}">
                    Diulas
                </button>
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

    <div class="bg-white rounded-lg shadow-sm border mt-5 border-gray-200 overflow-hidden">
        <!-- Table Container with horizontal scroll -->
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
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Kategori</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Lokasi</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                            Poin</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                            Slot</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                            Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($events as $key => $event)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Row Number -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div
                                    class="flex items-center justify-center w-8 h-8 bg-gray-100 rounded-full text-sm font-medium text-gray-600">
                                    {{ $key + 1 }}
                                </div>
                            </td>

                            <!-- Event Details -->
                            <td class="px-6 py-4">
                                <div class="space-y-1">
                                    <div class="font-semibold text-gray-900 leading-tight">
                                        {{ Str::limit($event->name, 25) }}
                                    </div>
                                    <div class="flex items-center text-xs text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    </div>
                                </div>
                            </td>

                            <!-- Description -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700 leading-relaxed">
                                    {{ Str::limit($event->description, 40) }}
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-700">
                                    {{ $event->event_category->name }}
                                </div>
                            </td>

                            <!-- Location -->
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
                                        {{ $event->city->name }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $event->city->province->name }}</div>
                                </div>
                            </td>

                            <!-- Points -->
                            <td class="px-6 py-4 text-center">
                                @if ($event->point == null)
                                    <span
                                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                        N/A
                                    </span>
                                @else
                                    <div
                                        class="inline-flex flex-col items-center px-3 py-2 rounded-full bg-blue-100 text-blue-800">
                                        <span class="text-sm font-bold">{{ $event->point }}</span>
                                        <span class="text-xs font-medium">pts</span>
                                    </div>
                                @endif
                            </td>

                            <!-- Available Slots -->
                            <td class="px-6 py-4 text-center">
                                <div class="flex flex-col items-center space-y-1">
                                    <span class="text-sm font-semibold text-gray-900">{{ $event->available_slot }}</span>
                                    <span class="text-xs text-gray-500">relawan</span>
                                </div>
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-center">
                                @if ($event->state == 'approved')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Disetujui
                                    </span>
                                @elseif($event->state == 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Diproses
                                    </span>
                                @elseif($event->state == 'finished')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        Selesai
                                    </span>
                                @elseif($event->state == 'reviewed')
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        Diulas
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                {{-- <div class="flex items-center {{ $event->state == 'pending' ? 'justify-start space-x-2' : 'justify-center' }}"> --}}
                                <div class="flex items-center justify-center">
                                    <a href="{{ route('admin.events.show', ['id' => $event->id]) }}"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition-colors duration-150 group"
                                        title="View Event">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>
                                    {{-- @if($event->state == 'pending')
                                        <form action="{{ route('admin.events.destroy', ['id' => $event->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this event? This action cannot be undone.')"
                                            class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition-colors duration-150 group"
                                                title="Delete Event">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @endif --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State (if no events) -->
        @if ($events->isEmpty())
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak terdapat acara</h3>
            </div>
        @endif

        <!-- Pagination (if you're using pagination) -->
        @if (method_exists($events, 'links'))
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                {{ $events->links() }}
            </div>
        @endif
    </div>

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
