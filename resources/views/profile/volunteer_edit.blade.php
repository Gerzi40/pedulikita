@extends('layouts.volunteer')

@section('title', 'Ubah Profil')

@section('content')

    {{-- <form action="{{ route('volunteer.profile.update') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')
        <div>
            Name:
            <input type="text" name="name" class="border-2 border-solid" value="{{ old('name', $user->name) }}" required />
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Email:
            <input type="email" name="email" class="border-2 border-solid" value="{{ old('email', $user->email) }}" required />
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
            Gender:
            <label>
                <input type="radio" name="gender" value="male" @checked(old('gender', $user->volunteer->gender) == 'male') />
                Male
            </label>
            <label>
                <input type="radio" name="gender" value="female" @checked(old('gender', $user->volunteer->gender) == 'female') />
                Female
            </label>
            @error('gender')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Date of Birth:
            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $user->volunteer->date_of_birth) }}" />
            @error('date_of_birth')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <div>
            Profile Picture:
            <input type="file" id="profile_picture" name="profile_picture" accept="image/*" />
            <img id="preview" src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" style="max-height: 200px;" />
            @error('profile_picture')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="border-2 border-solid bg-[#b0b0b0]">Update</button>
    </form>

    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            const preview = document.getElementById('preview');
            if (file) {
                preview.src = URL.createObjectURL(file);
            }
        });
    </script> --}}

    {{-- <div class="md:w-1/2 p-6 lg:p-10 bg-white flex flex-col md:justify-center-safe overflow-auto md:h-full">
        <h2 class="text-2xl lg:text-3xl font-bold mb-6 text-center text-gray-800">Update Profil</h2>

        <form action="{{ route('volunteer.profile.update') }}" method="post" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @method('put')

            <!-- Input Nama -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800" />
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800" />
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Input Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                <input type="password" name="password" id="password" placeholder="Kosongkan jika tidak ingin mengganti"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800" />
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gender -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                <div class="flex items-center space-x-4">
                    <label class="inline-flex items-center text-sm text-gray-700">
                        <input type="radio" name="gender" value="male" class="form-radio text-[var(--color1)] h-4 w-4"
                            @checked(old('gender', $user->volunteer->gender) == 'male') required>
                        <span class="ml-1.5">Laki-laki</span>
                    </label>
                    <label class="inline-flex items-center text-sm text-gray-700">
                        <input type="radio" name="gender" value="female" class="form-radio text-[var(--color1)] h-4 w-4"
                            @checked(old('gender', $user->volunteer->gender) == 'female') required>
                        <span class="ml-1.5">Perempuan</span>
                    </label>
                </div>
                @error('gender')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Lahir -->
            <div>
                <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                <input type="date" name="date_of_birth" id="date_of_birth"
                    value="{{ old('date_of_birth', $user->volunteer->date_of_birth) }}"
                    class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800" />
                @error('date_of_birth')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Foto Profil -->
            <div>
                <label for="profile_picture" class="block text-sm font-medium text-gray-700 mb-1">Foto Profil</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*"
                    class="block w-full text-sm text-gray-600 border border-gray-300 rounded-md cursor-pointer focus:outline-none focus:ring-2 focus:ring-[var(--color1)]" />
                <div class="mt-3">
                    <img id="preview" src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" alt="Preview"
                        class="max-h-48 rounded-md border border-gray-300 object-cover" />
                </div>
                @error('profile_picture')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Update -->
            <button type="submit"
                class="w-full bg-blue-600 text-white py-2.5 rounded-md font-semibold text-base hover:bg-blue-700 transition duration-300 cursor-pointer">
                Update
            </button>
        </form>

        <script>
            document.getElementById('profile_picture').addEventListener('change', function(e) {
                const [file] = e.target.files;
                const preview = document.getElementById('preview');
                if (file) {
                    preview.src = URL.createObjectURL(file);
                }
            });
        </script>
    </div> --}}

    <div class="flex items-center justify-center min-h-screen my-5">
        <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-6 lg:p-10">
            <h2 class="text-2xl lg:text-3xl font-bold mb-6 text-center text-gray-800">Perbarui Profil</h2>

            <form action="{{ route('volunteer.profile.update') }}" method="post" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('put')

                <!-- Upload Foto Profil (klik gambar) -->
                <div class="text-center rounded-full">
                    <label for="profile_picture" class="cursor-pointer inline-block relative group">
                        <img id="preview" src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}"
                            class="w-40 h-40 object-cover rounded-full border-2 border-gray-300 mx-auto hover:opacity-80 transition"
                            alt="Profile Picture" />
                        {{-- <div
                            class="absolute bottom-2 right-2 bg-blue-600 text-white p-2 rounded-full shadow hover:bg-blue-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </div> --}}
                        <div
                            class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center text-white text-sm font-medium opacity-0 group-hover:opacity-100 transition">
                            Ubah Foto
                        </div>
                    </label>
                    <input id="profile_picture" type="file" name="profile_picture" accept="image/*" class="hidden" />
                    @error('profile_picture')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] text-gray-800" />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        disabled
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm text-gray-800
         disabled:bg-gray-300 disabled:text-gray-500 disabled:cursor-not-allowed" />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password (pakai x-input-password untuk show/hide) -->
                {{-- <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <x-input-password name="password" id="password" placeholder="Kosongkan jika tidak ingin mengganti"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-800" />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div> --}}

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="radio" name="gender" value="male" class="form-radio text-blue-600 h-4 w-4 cursor-pointer"
                                @checked(old('gender', $user->volunteer->gender) == 'male')>
                            <span class="ml-1.5">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="radio" name="gender" value="female" class="form-radio text-blue-600 h-4 w-4 cursor-pointer"
                                @checked(old('gender', $user->volunteer->gender) == 'female')>
                            <span class="ml-1.5">Perempuan</span>
                        </label>
                    </div>
                    @error('gender')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth"
                        value="{{ old('date_of_birth', $user->volunteer->date_of_birth) }}"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] text-gray-800" />
                    @error('date_of_birth')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Update -->
                <button type="submit"
                    class="w-full bg-[var(--color1)] text-white py-2.5 rounded-md font-semibold text-base hover:bg-[var(--hovercolor1)] transition duration-300 cursor-pointer">
                    Perbarui
                </button>
            </form>
        </div>
    </div>

    <!-- Preview Gambar -->
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(e) {
            const [file] = e.target.files;
            if (file) {
                document.getElementById('preview').src = URL.createObjectURL(file);
            }
        });
    </script>



@endsection
