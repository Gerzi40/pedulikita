@extends('layouts.admin')

@section('title', 'Admin Organizations Create')

@section('content')

    <div class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-semibold mb-8 text-gray-800">Daftarkan Organisasi anda,</h1>

        <form action="{{ route('admin.organizations.store') }}" method="post" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama Organisasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi <span class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('name') }}" placeholder="Masukkan nama organisasi" required />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Organisasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Organisasi <span class="text-red-500">*</span></label>
                    <select name="organization_category_id" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                        @foreach ($organization_categories as $organization_category)
                            <option value="{{ $organization_category->id }}" {{ old('organization_category_id') == $organization_category->id ? 'selected' : '' }}>
                                {{ $organization_category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Tanggal didaftarkan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal didaftarkan <span class="text-red-500">*</span></label>
                    <input type="date" name="founded_at" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('founded_at') }}" required />
                    @error('founded_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kota -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span class="text-red-500">*</span></label>
                    <select name="city_id" id="city" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span class="text-red-500">*</span></label>
                    <select name="province_id" id="province" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram <span class="text-red-500">*</span></label>
                    <input type="text" name="instagram" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('instagram') }}" placeholder="Masukkan akun instagram" required />
                    @error('instagram')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('phone') }}" placeholder="Masukkan nomor telepon" required />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('email') }}" placeholder="Masukkan alamat email" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                <input type="password" name="password" class="w-full border rounded-md px-4 py-2 text-sm" placeholder="Masukkan password" required />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan <span class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="w-full border rounded-md px-4 py-2 text-sm" placeholder="Ceritakan secara detail organisasi anda" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar <span class="text-red-500">*</span></label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="text-sm cursor-pointer" required />
                <img id="preview" class="mt-2 max-h-48 hidden rounded-md" />
                <p class="text-gray-500 text-xs mt-2">Feature Image must be at least 1170 pixels wide by 504 pixels high.<br>Valid file formats: JPG, GIF, PNG.</p>
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button" class="px-6 py-2 border border-gray-400 text-gray-700 rounded-md hover:bg-gray-100">Kembali</button>
                <button type="submit" class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Buat</button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>

    <script>
        $('#province').on('change', function() {
            const provinceId = $(this).val();

            if (provinceId) {
                $.get(`/provinces/${provinceId}/cities`, function(data) {
                    let options = '<option hidden></option>';
                    data.forEach(city => {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('#city').html(options);
                });
            } else {
                $('#city').html('<option hidden></option>');
            }
        });
    </script>

@endsection
