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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('name') }}" placeholder="Masukkan nama organisasi" required />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jenis Organisasi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Organisasi <span
                            class="text-red-500">*</span></label>
                    <select name="organization_category_id" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                        @foreach ($organization_categories as $organization_category)
                            <option value="{{ $organization_category->id }}"
                                {{ old('organization_category_id') == $organization_category->id ? 'selected' : '' }}>
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
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal didaftarkan <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="founded_at" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('founded_at') }}" required />
                    @error('founded_at')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Provinsi -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span
                            class="text-red-500">*</span></label>
                    <select name="province_id" id="province" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}"
                                {{ old('province_id') == $province->id ? 'selected' : '' }}>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kota -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span
                            class="text-red-500">*</span></label>
                    <select name="city_id" id="city" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option value="" hidden>Please select one</option>
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Instagram -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="instagram" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('instagram') }}" placeholder="Masukkan akun instagram" required />
                    @error('instagram')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('phone') }}" placeholder="Masukkan nomor telepon" required />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Alamat Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('email') }}" placeholder="Masukkan alamat email" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password <span
                        class="text-red-500">*</span></label>
                <x-input-password type="password" name="password" id="password" placeholder="Masukkan password"
                    class="w-full border rounded-md px-4 py-2 text-sm" value="{{ old('password') }}" required />
                {{-- <input type="password" name="password" class="w-full border rounded-md px-4 py-2 text-sm"
                    value="{{ old('password') }}" placeholder="Masukkan password" required /> --}}
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Keterangan -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan <span
                        class="text-red-500">*</span></label>
                <textarea name="description" rows="5" class="w-full border rounded-md px-4 py-2 text-sm"
                    placeholder="Ceritakan secara detail organisasi anda" required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Upload Gambar -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar <span
                        class="text-red-500">*</span></label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                    class="text-sm cursor-pointer" required />
                <img id="preview" class="mt-2 max-h-48 hidden rounded-md" />
                <p class="text-gray-500 text-xs mt-2">Feature Image must be at least 1170 pixels wide by 504 pixels
                    high.<br>Valid file formats: JPG or PNG.</p>
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Gambar <span
                        class="text-red-500">*</span></label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                    class="text-sm cursor-pointer" {{ isset($user) ? '' : (old('temp_image_path') ? '' : 'required') }} />

                <!-- Hidden field untuk menyimpan temporary path -->
                <input type="hidden" id="temp_image_path" name="temp_image_path" value="{{ old('temp_image_path') }}" />

                <!-- Container untuk gambar -->
                <div id="image-container" class="mt-2">
                    @if (old('temp_image_path'))
                        <!-- Tampilkan gambar yang sudah diupload sebelumnya -->
                        <div id="existing-image-wrapper">
                            <img src="{{ asset('temp/' . old('temp_image_path')) }}" class="max-h-48 rounded-md border"
                                alt="Previously Uploaded" />
                            <div class="flex items-center justify-between mt-1">
                                <p class="text-green-600 text-xs">✓ File sudah diupload:
                                    {{ old('temp_original_name', 'uploaded_image') }}</p>
                                <button type="button" onclick="removeExistingImage()"
                                    class="text-red-600 text-xs hover:text-red-800">Hapus</button>
                            </div>
                        </div>
                    @endif

                    <!-- Preview untuk gambar baru -->
                    <img id="preview" class="mt-2 max-h-48 hidden rounded-md border" />
                </div>

                <!-- Status upload -->
                <div id="upload-status" class="mt-1 text-xs"></div>

                <p class="text-gray-500 text-xs mt-2">Feature Image must be at least 1170 pixels wide by 504 pixels
                    high.<br>Valid file formats: JPG, GIF, PNG.</p>
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('temp_image_path')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" id="temp_original_name" name="temp_original_name"
                value="{{ old('temp_original_name') }}" /> --}}

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4">
                <button type="button"
                    class="px-6 py-2 border border-gray-400 text-gray-700 rounded-md hover:bg-gray-100">Kembali</button>
                <button type="submit"
                    class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Buat</button>
            </div>
        </form>
    </div>

    {{-- <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script> --}}
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            // Sembunyikan dan kosongkan preview lama terlebih dahulu
            preview.style.display = 'none';
            preview.src = '';

            const [file] = e.target.files;

            if (file) {
                // --- ⚙️ VALIDASI DIMULAI ---

                // 1. Tentukan aturan validasi
                const allowedExtensions = ['jpg', 'jpeg', 'png'];
                const maxSizeInBytes = 2 * 1024 * 1024; // 2MB

                // 2. Cek ekstensi file
                const fileExtension = file.name.split('.').pop().toLowerCase();
                if (!allowedExtensions.includes(fileExtension)) {
                    alert('File tidak valid! Harap unggah file dengan ekstensi .jpg atau .png.');
                    e.target.value = ''; // Mengosongkan input file yang tidak valid
                    return; // Hentikan proses
                }

                // 3. Cek ukuran file
                if (file.size > maxSizeInBytes) {
                    alert('Ukuran file terlalu besar! Ukuran maksimal adalah 2MB.');
                    e.target.value = ''; // Mengosongkan input file yang tidak valid
                    return; // Hentikan proses
                }

                // --- ✅ VALIDASI BERHASIL ---

                // Jika lolos, tampilkan pratinjau
                preview.src = URL.createObjectURL(file);
                preview.style.display = 'block';
            }
        });
    </script>
    {{-- <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('preview');
            const status = document.getElementById('upload-status');
            const tempPath = document.getElementById('temp_image_path');
            const tempOriginalName = document.getElementById('temp_original_name');
            const existingWrapper = document.getElementById('existing-image-wrapper');

            if (file) {
                // Show preview immediately
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');

                // Hide existing image wrapper
                if (existingWrapper) {
                    existingWrapper.style.display = 'none';
                }

                status.innerHTML = '<span class="text-blue-600">Sedang mengupload...</span>';

                // Prepare form data
                const formData = new FormData();
                formData.append('image', file);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute(
                'content'));

                // Upload via AJAX
                fetch('/temp-upload', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Update hidden fields
                            tempPath.value = data.filename;
                            tempOriginalName.value = file.name;

                            status.innerHTML = '<span class="text-green-600">✓ File berhasil diupload</span>';

                            // Remove required attribute since we now have temp file
                            document.getElementById('profile_picture').removeAttribute('required');
                        } else {
                            status.innerHTML = '<span class="text-red-600">✗ Upload gagal: ' + (data.message ||
                                'Unknown error') + '</span>';

                            // Clear temp path on failure
                            tempPath.value = '';
                            tempOriginalName.value = '';
                        }
                    })
                    .catch(error => {
                        status.innerHTML = '<span class="text-red-600">✗ Error saat upload</span>';
                        console.error('Upload error:', error);

                        // Clear temp path on error
                        tempPath.value = '';
                        tempOriginalName.value = '';
                    });
            } else {
                // No file selected, hide preview
                preview.classList.add('hidden');
                status.innerHTML = '';

                // Show existing image wrapper if available
                if (existingWrapper) {
                    existingWrapper.style.display = 'block';
                }

                // If no existing temp image, add required back
                if (!tempPath.value) {
                    document.getElementById('profile_picture').setAttribute('required', 'required');
                }
            }
        });

        function removeExistingImage() {
            const existingWrapper = document.getElementById('existing-image-wrapper');
            const tempPath = document.getElementById('temp_image_path');
            const tempOriginalName = document.getElementById('temp_original_name');
            const fileInput = document.getElementById('profile_picture');

            // Hide existing image
            if (existingWrapper) {
                existingWrapper.style.display = 'none';
            }

            // Clear temp path
            tempPath.value = '';
            tempOriginalName.value = '';

            // Add required attribute back
            fileInput.setAttribute('required', 'required');

            // Clear file input
            fileInput.value = '';

            // Hide preview
            document.getElementById('preview').classList.add('hidden');

            // Clear status
            document.getElementById('upload-status').innerHTML = '';
        }

        // Initialize on page load
        window.addEventListener('DOMContentLoaded', function() {
            const tempPath = document.getElementById('temp_image_path');
            const fileInput = document.getElementById('profile_picture');

            // If we have temp image, remove required attribute
            if (tempPath.value) {
                fileInput.removeAttribute('required');
            }
        });
    </script> --}}

    {{-- <script>
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
    </script> --}}

    <script>
        $(document).ready(function() {
            // Function to load cities based on a province ID and a pre-selected city ID
            function loadCities(provinceId, selectedCityId) {
                if (provinceId) {
                    $.get(`/provinces/${provinceId}/cities`, function(data) {
                        let options = '<option value="" hidden>Please select one</option>';
                        data.forEach(city => {
                            // Check if the current city ID matches the selected city ID
                            const isSelected = city.id == selectedCityId ? 'selected' : '';
                            options +=
                                `<option value="${city.id}" ${isSelected}>${city.name}</option>`;
                        });
                        $('#city').html(options);
                    });
                } else {
                    $('#city').html('<option value="" hidden>Please select one</option>');
                }
            }

            // Handle province change event
            $('#province').on('change', function() {
                const provinceId = $(this).val();
                // Pass null for the selected city ID since we're starting fresh
                loadCities(provinceId, null);
            });

            // Initial load on page load
            // Get the old province and city values from the Blade view
            const oldProvinceId = '{{ old('province_id') }}';
            const oldCityId = '{{ old('city_id') }}';

            // If there's an old province ID, load the corresponding cities and set the selected city
            if (oldProvinceId) {
                loadCities(oldProvinceId, oldCityId);
            }
        });
    </script>

@endsection
