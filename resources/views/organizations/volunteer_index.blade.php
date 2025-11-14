@extends('layouts.volunteer')

@section('title', 'Organisasi')

@section('content')

    {{-- Hero Section --}}
    <section>
        <div class="py-5 mx-auto max-w-5xl">
            <img src="{{ asset('assets/hero/org_event.png') }}" alt="">
        </div>
    </section>

    {{-- Searchbar --}}
    <div class="flex justify-center">
        <form action="{{ route('volunteer.organizations.index') }}" method="get" id="filterForm"
            class="flex flex-wrap gap-5 items-center p-5 bg-white shadow rounded-md justify-center my-5">

            <!-- Search Bar -->
            <div class="flex items-center rounded-md px-3 py-2 w-full md:w-auto bg-gray-200">
                <input type="text" name="name" placeholder="Masukkan nama organisasi"
                    class="outline-none w-full bg-transparent" value="{{ request('name') }}">
                <button type="submit" class="text-blue-500">🔍</button>
            </div>

            <!-- Organization Category -->
            <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
                🏷️
                <select name="organization_category_id" class="bg-transparent outline-none">
                    <option value="">Kategori Organisasi</option>
                    @foreach ($organization_categories as $organization_category)
                        <option value="{{ $organization_category->id }}" @selected(request('organization_category_id') == $organization_category->id)>
                            {{ $organization_category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Province Dropdown -->
            <div class="flex items-center gap-2 rounded-md px-3 py-2 bg-gray-200 w-full md:w-auto">
                🏙️
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
                🌆
                <select name="city_id" id="city" class="bg-transparent outline-none">
                    <option value="">Kota</option>
                    <!-- Data kota dimuat via JS tergantung provinsi -->
                </select>
            </div>

            <!-- Filter Button -->
            <button type="submit" class="bg-[var(--color1)] text-white px-5 py-2 rounded-md hover:bg-[var(--hovercolor1)] cursor-pointer">
                Filter
            </button>
        </form>
    </div>

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