@extends('layouts.volunteer')

@section('title', 'Acara')

@section('content')

    {{-- Hero Section --}}
    <section>
        <div class="py-5 mx-auto max-w-5xl">
            <img src="{{ asset('assets/hero/hero_event.png') }}" alt="">
        </div>
    </section>

    {{-- Searchbar --}}
    <form action="{{ route('volunteer.events.index') }}" method="get" id="filterForm"
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

        <!-- Filter Button -->
        <button type="submit" class="bg-[var(--color1)] text-white px-5 py-2 rounded-md hover:bg-[var(--hovercolor1)] cursor-pointer">
            Cari
        </button>
    </form>

    <section class="py-10">
        <div class="container mx-auto px-4">
            <h2 class="text-xl font-bold text-[var(--color1)] mb-6">Ayo Eksplor!</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Menyesuaikan grid untuk responsif --}}
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Menambahkan rounded-lg dan shadow-md --}}
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
                            <div class="flex items-center text-gray-500 text-xs mb-1"> {{-- Menambahkan items-center dan mb-1 --}}
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Lokasi"> {{-- Menyesuaikan ukuran icon --}}
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
                                {{-- Menambahkan teks "Tersedia ... slot" --}}
                            </div>

                            {{-- Tombol Lihat --}}
                            <div class="flex justify-end"> {{-- Menggunakan justify-end untuk memposisikan tombol di kanan --}}
                                <a href="{{ route('volunteer.events.show', ['id' => $event->id]) }}"
                                    class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                                {{-- Mengubah button menjadi link a dan menambahkan styling Tailwind --}}
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

@endsection
