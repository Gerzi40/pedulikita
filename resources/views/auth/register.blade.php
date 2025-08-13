@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex flex-col md:flex-row w-full max-w-6xl shadow-lg rounded-lg bg-white md:h-[80vh]">
        
        <!-- Bagian Gambar -->
        <div class="md:w-1/2 md:h-full">
            <img src="{{ asset('assets/general_image/register.jpg') }}" alt="Register Image"
                class="w-full h-full object-cover" />
        </div>

        <!-- Bagian Form -->
        <div class="md:w-1/2 p-6 lg:p-10 bg-white flex flex-col md:justify-center-safe overflow-auto md:h-full">
            <h2 class="text-2xl lg:text-3xl font-bold mb-6 text-center text-gray-800">Ayo bergabung!</h2>

            <form action="{{ route('register') }}" method="post" class="space-y-4">
                @csrf

                <!-- Input Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" id="name" placeholder="Masukkan nama Anda"
                        class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800"
                        value="{{ old('name') }}" required />
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan alamat email Anda"
                        class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800"
                        value="{{ old('email') }}" required />
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Kata Sandi -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <x-input-password type="password" name="password" id="password" placeholder="Masukkan kata sandi Anda"
                        class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800"
                        required />
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                    <x-input-password type="password" name="password_confirmation" id="password_confirmation" placeholder="Ulangi kata sandi Anda"
                        class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800"
                        required />
                </div>

                <!-- Gender -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jenis Kelamin</label>
                    <div class="flex items-center space-x-4">
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="radio" name="gender" value="male" class="form-radio text-[var(--color1)] h-4 w-4" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                            <span class="ml-1.5">Laki-laki</span>
                        </label>
                        <label class="inline-flex items-center text-sm text-gray-700">
                            <input type="radio" name="gender" value="female" class="form-radio text-[var(--color1)] h-4 w-4" {{ old('gender') == 'female' ? 'checked' : '' }} required>
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
                        class="w-full px-3 py-1.5 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[var(--color1)] focus:border-transparent text-gray-800"
                        value="{{ old('date_of_birth') }}" required />
                    @error('date_of_birth')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Checkbox -->
                <div class="flex items-center pt-1">
                    <input type="checkbox" name="terms" id="terms" class="form-checkbox text-[var(--color1)] h-3.5 w-3.5" required>
                    <label for="terms" class="ml-1.5 text-sm text-gray-700">
                        Saya menyetujui <a href="#" class="text-[var(--color1)] hover:underline">syarat & ketentuan</a>
                    </label>
                </div>
                @error('terms')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror

                <!-- Tombol Daftar -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2.5 rounded-md font-semibold text-base hover:bg-blue-700 transition duration-300 cursor-pointer">
                    Daftar
                </button>
            </form>

            <!-- Link Masuk -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-[var(--color1)] hover:underline font-medium">Masuk</a>
            </p>
        </div>
    </div>
</div>
@endsection
