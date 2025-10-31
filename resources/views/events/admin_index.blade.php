@extends('layouts.admin')

@section('title', 'Acara')

@section('content')

    <form action="{{ route('admin.events.index') }}" method="get" id="filterForm"
        class="flex flex-wrap gap-3 items-center p-5 bg-white shadow rounded-md justify-center mx-40 my-5">

        <!-- Search Bar -->
        <div class="flex items-center rounded-md px-3 py-2 w-full md:w-auto bg-gray-200">
            <input type="text" name="name" placeholder="Masukkan nama acara" class="outline-none w-full"
                value="{{ request('name') }}">
            <button type="submit" class="text-blue-500">
                <img src="{{ asset('assets/icons/search.png') }}" alt="Cari" class="w-5 h-5">
            </button>
        </div>

        <!-- Kategori Dropdown -->
        <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
            <img src="{{ asset('assets/icons/category.png') }}" alt="Kategori" class="w-5 h-5">
            <select name="event_category_id" class="bg-transparent outline-none">
                <option value="">Kategori</option>
                @foreach ($event_categories as $event_category)
                    <option value="{{ $event_category->id }}" @selected(request('event_category_id') == $event_category->id)>
                        {{ $event_category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Date Picker -->
        <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 cursor-pointer w-full md:w-auto">
            <img src="{{ asset('assets/icons/calendar.png') }}" alt="Tanggal" class="w-5 h-5">
            <input type="date" name="date" class="bg-transparent outline-none font-normal"
                value="{{ request('date', \Carbon\Carbon::now()->format('Y-m-d')) }}">
        </div>

        <!-- Province Dropdown -->
        <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
            <img src="{{ asset('assets/icons/province.png') }}" alt="Provinsi" class="w-5 h-5">
            <select name="province_id" id="province" class="bg-transparent outline-none">
                <option value="">Provinsi</option>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(request('province_id') == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- City Dropdown -->
        <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
            <img src="{{ asset('assets/icons/city.png') }}" alt="Kota" class="w-5 h-5">
            <select name="city_id" id="city" class="bg-transparent outline-none">
                <option value="">Kota</option>
                <!-- Data kota dimuat via JS tergantung provinsi -->
            </select>
        </div>

        <!-- Status Filter -->
        <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
            <img src="{{ asset('assets/icons/status.png') }}" alt="Status" class="w-5 h-5">
            <select name="state" class="bg-transparent outline-none">
                <option value="">Status</option>
                <option value="pending" @selected(request('state') == 'pending')>Pending</option>
                <option value="approved" @selected(request('state') == 'approved')>Approved</option>
                <option value="finished" @selected(request('state') == 'finished')>Finished</option>
            </select>
        </div>

        <!-- Filter Button -->
        <button type="submit" class="bg-[var(--color1)] text-white px-5 py-2 rounded-md hover:bg-[var(--hovercolor1)] cursor-pointer">
            Cari
        </button>
    </form>



    {{-- @foreach ($events as $event)
        <li>
            <a href="{{ route('admin.events.show', ['id' => $event->id]) }}">
                {{ $event }}
            </a>
        </li>
    @endforeach --}}

    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <!-- Table Header -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Events Management</h3>
            <p class="text-sm text-gray-600 mt-1">Manage and monitor volunteer events</p>
        </div>

        <!-- Table Container with horizontal scroll -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-16">#
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[200px]">
                            Event Details</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[250px]">
                            Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Kategori</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider min-w-[150px]">
                            Location</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-20">
                            Points</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-24">
                            Slots</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-32">
                            Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-28">
                            Actions</th>
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
                                    <span class="text-xs text-gray-500">volunteers</span>
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
                                        Approved
                                    </span>
                                @elseif($event->state == 'pending')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        Pending
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        {{ $event->state }}
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-start space-x-2">
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
                                    @if($event->state == 'pending')
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
                                    @endif
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
                <h3 class="mt-2 text-sm font-medium text-gray-900">No events found</h3>
                <p class="mt-1 text-sm text-gray-500">Get started by creating a new event.</p>
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

@endsection
