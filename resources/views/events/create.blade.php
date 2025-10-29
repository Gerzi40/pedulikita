@extends('layouts.organization')

@section('title', 'Buat Acara')

@section('content')
<div class="max-w-7xl mx-auto px-6 py-10">
    <h1 class="text-3xl font-semibold mb-8 text-gray-800">Buat Acara anda,</h1>

    <form action="{{ route('organization.events.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Nama Acara -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Acara <span class="text-red-500">*</span></label>
                <input type="text" name="name" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('name') }}" required />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori Acara -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                <select name="event_category_id" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                        @foreach ($event_categories as $event_category)
                            <option value="{{ $event_category->id }}"
                                {{ old('event_category_id') == $event_category->id ? 'selected' : '' }}>
                                {{ $event_category->name }}
                            </option>
                        @endforeach
                    </select>
                @error('event_category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Slot tersedia -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Slot tersedia <span class="text-red-500">*</span></label>
                <input type="number" name="available_slot" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('available_slot') }}" required />
                @error('available_slot')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Tanggal -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal <span class="text-red-500">*</span></label>
                <input type="date" name="date" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('date') }}" required />
                @error('date')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Acara Mulai -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Acara Mulai <span class="text-red-500">*</span></label>
                <input type="time" name="start_time" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('start_time') }}" required />
                @error('start_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Acara Berakhir -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Acara Berakhir</label>
                <input type="time" name="end_time" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('end_time') }}" required />
                @error('end_time')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Keterangan -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan Acara <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5" class="w-full border rounded-md px-4 py-2 text-sm" required>{{ old('description') }}</textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Lokasi -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Acara <span class="text-red-500">*</span></label>
            <input type="text" id="location" name="location" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('location') }}" required />
            <ul id="suggestions" class="bg-white border w-full z-10 hidden rounded-md shadow-md text-sm"></ul>
            <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}" />
            <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}" />
            <input type="hidden" name="city" id="city" value="{{ old('city') }}" />
            @error('location')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('latitude')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('longitude')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('city')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Upload Gambar -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar <span class="text-red-500">*</span></label>
            <input type="file" id="image" name="image" accept="image/*" class="text-sm cursor-pointer" required />
            <img id="preview" class="mt-2 max-h-48 hidden rounded-md" />
            <p class="text-gray-500 text-xs mt-2">Feature Image must be at least 1170 pixels wide by 504 pixels high.<br>Valid file formats: JPG, GIF, PNG.</p>
            @error('image')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-3 pt-4">
            <a href="{{ route('organization.events.index') }}"
                class="px-6 py-2 border border-gray-400 text-gray-700 rounded-md hover:bg-gray-100">Kembali</a>
            <button type="submit"
                class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Buat</button>
        </div>
    </form>
</div>

<!-- Preview Image Script -->
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const [file] = e.target.files;
        const preview = document.getElementById('preview');
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>

<!-- Location Suggestions Script -->
<script>
    const input = document.getElementById('location');
    const suggestionsBox = document.getElementById('suggestions');
    const latitude_element = document.getElementById('latitude');
    const longitude_element = document.getElementById('longitude');
    const city_element = document.getElementById('city');

    let timeout = null;
    input.addEventListener('input', () => {
        clearTimeout(timeout);

        const query = input.value.trim();
        if (query.length < 3) {
            suggestionsBox.classList.add('hidden');
            suggestionsBox.innerHTML = '';
            return;
        }

        timeout = setTimeout(searchLocation, 500);
    });

    async function searchLocation() {

        latitude_element.value = ''
        longitude_element.value = ''
        city_element.value = ''

        const query = input.value.trim();

        const res = await fetch(`https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&accept-language=id-ID&countrycodes=id&q=${query}`);
        const data = await res.json();

        suggestionsBox.innerHTML = '';
        if (!data.length) {
            suggestionsBox.classList.add('hidden');
            return;
        }
        
        data.forEach(location => {
            const name = location.name
            const display_name = location.display_name
            const arr = display_name.split(', ')
            const city = location.address.county || location.address.city || location.address.town || location.address.region

            if (!city) return

            const city_index = arr.indexOf(city)
            const province = arr[city_index+1]
            const latitude = location.lat
            const longitude = location.lon

            const str = `${name}, ${city}, ${province}`

            const li = document.createElement('li');
            li.textContent = str;
            li.className = 'cursor-pointer hover:bg-gray-100 px-4 py-2';
            li.onclick = () => {
                input.value = li.textContent;
                latitude_element.value = latitude;
                longitude_element.value = longitude;
                city_element.value = city;
                suggestionsBox.classList.add('hidden');
            };

            suggestionsBox.appendChild(li);
        });

        if (suggestionsBox.innerHTML != '') {
            suggestionsBox.classList.remove('hidden');
        }
    }

    document.addEventListener('click', e => {
        if (!suggestionsBox.contains(e.target) && e.target !== input) {
            suggestionsBox.classList.add('hidden');
        }
    });
</script>
@endsection
