@extends('layouts.admin')

@section('title', 'Admin Organizations Edit')

@section('content')

    {{-- <form action="{{ route('admin.organizations.update', ['id' => $organization->id]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div>
            Name:
            <input type="text" name="name" class="border-2 border-solid" value="{{ old('name', $organization->user->name) }}" required />
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Category:
            <select name="organization_category_id" class="border-2 border-solid" required>
                <option hidden></option>
                @foreach ($organization_categories as $organization_category)
                    <option value="{{ $organization_category->id }}" @selected(old('organization_category_id', $organization->organization_category_id) == $organization_category->id)>
                        {{ $organization_category->name }}
                    </option>
                @endforeach
            </select>
            @error('organization_category_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Province:
            <select name="province_id" id="province" class="border-2 border-solid" required>
                @foreach ($provinces as $province)
                    <option value="{{ $province->id }}" @selected(old('province_id', $organization->city->province_id) == $province->id)>
                        {{ $province->name }}
                    </option>
                @endforeach
            </select>
            @error('province_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            City:
            <select name="city_id" id="city" class="border-2 border-solid" required>
                @foreach ($organization->city->province->cities as $city)
                    <option value="{{ $city->id }}" @selected(old('city_id', $organization->city_id) == $city->id)>
                        {{ $city->name }}
                    </option>
                @endforeach
            </select>
            @error('city_id')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Founded At:
            <input type="date" name="founded_at" class="border-2 border-solid" value="{{ old('founded_at', $organization->founded_at) }}" required />
            @error('founded_at')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Instagram:
            <input type="text" name="instagram" class="border-2 border-solid" value="{{ old('instagram', $organization->instagram) }}" required />
            @error('instagram')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Phone:
            <input type="text" name="phone" class="border-2 border-solid" value="{{ old('phone', $organization->phone) }}" required />
            @error('phone')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Email:
            <input type="email" name="email" class="border-2 border-solid" value="{{ old('email', $organization->user->email) }}" required />
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Password:
            <input type="password" name="password" class="border-2 border-solid w-100" placeholder="keep empty if dont want to change" />
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Description:
            <input type="text" name="description" class="border-2 border-solid" value="{{ old('description', $organization->description) }}" required />
            @error('description')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Profile Picture:
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" />
            <img id="preview" src="{{ Storage::disk('s3')->url($organization->user->profile_picture_url) }}" style="max-height: 200px;" />
            @error('profile_picture')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="border-2 border-solid bg-[#b0b0b0]">Update</button>
    </form> --}}

    <div class="max-w-7xl mx-auto px-6 py-10">
        <h1 class="text-3xl font-semibold mb-8 text-gray-800">Perbarui Profil Organisasi</h1>

        <form action="{{ route('admin.organizations.update', ['id' => $organization->id]) }}" method="post"
            enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('put')

            <!-- Nama & Kategori -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Organisasi <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('name', $organization->user->name) }}" required />
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Organisasi <span
                            class="text-red-500">*</span></label>
                    <select name="organization_category_id" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        <option hidden></option>
                        @foreach ($organization_categories as $organization_category)
                            <option value="{{ $organization_category->id }}" @selected(old('organization_category_id', $organization->organization_category_id) == $organization_category->id)>
                                {{ $organization_category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('organization_category_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Provinsi & Kota -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Provinsi <span
                            class="text-red-500">*</span></label>
                    <select name="province_id" id="province" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        @foreach ($provinces as $province)
                            <option value="{{ $province->id }}" @selected(old('province_id', $organization->city->province_id) == $province->id)>
                                {{ $province->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('province_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kota <span
                            class="text-red-500">*</span></label>
                    <select name="city_id" id="city" class="w-full border rounded-md px-4 py-2 text-sm" required>
                        @foreach ($organization->city->province->cities as $city)
                            <option value="{{ $city->id }}" @selected(old('city_id', $organization->city_id) == $city->id)>
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('city_id')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Founded At -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Didaftarkan <span
                        class="text-red-500">*</span></label>
                <input type="date" name="founded_at" class="w-full border rounded-md px-4 py-2 text-sm"
                    value="{{ old('founded_at', $organization->founded_at) }}" required />
                @error('founded_at')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Instagram, Phone, Email -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Instagram <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="instagram" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('instagram', $organization->instagram) }}" required />
                    @error('instagram')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="phone" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('phone', $organization->phone) }}" required />
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" class="w-full border rounded-md px-4 py-2 text-sm"
                        value="{{ old('email', $organization->user->email) }}" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password (kosongkan jika tidak ingin
                    mengubah)</label>
                <input type="password" name="password" class="w-full border rounded-md px-4 py-2 text-sm"
                    placeholder="••••••" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Keterangan <span
                        class="text-red-500">*</span></label>
                <textarea name="description" rows="4" class="w-full border rounded-md px-4 py-2 text-sm" required>{{ old('description', $organization->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Profile Picture -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Unggah Foto Profil</label>
                <div onclick="document.getElementById('profile_picture').click()"
                    class="relative w-48 h-48 rounded-md overflow-hidden cursor-pointer group">
                    <img id="preview" src="{{ Storage::disk('s3')->url($organization->user->profile_picture_url) }}"
                        class="w-full h-full object-cover rounded-md" alt="Profile Picture" />
                    <div
                        class="absolute inset-0 bg-black/40 flex items-center justify-center 
                            text-white text-sm font-medium opacity-0 group-hover:opacity-100 transition">
                        Ubah Foto
                    </div>
                </div>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="hidden" />
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-3 pt-4">
                <a href="{{ route('admin.organizations.index') }}"
                    class="px-6 py-2 border border-gray-400 text-gray-700 rounded-md hover:bg-gray-100">Kembali</a>
                <button type="submit"
                    class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Ubah</button>
            </div>
        </form>
    </div>




    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
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
