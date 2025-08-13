@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="flex flex-col md:flex-row-reverse w-full max-w-6xl shadow-lg rounded-lg bg-white md:h-[80vh]">

        <!-- Bagian Gambar -->
        <div class="md:w-1/2 md:h-full">
            <img src="{{ asset('assets/general_image/login.jpg') }}" 
                 alt="Login Image" 
                 class="w-full h-full object-cover" />
        </div>

        <!-- Bagian Form -->
        <div class="md:w-1/2 p-6 lg:p-10 bg-white flex flex-col md:justify-center-safe overflow-auto md:h-full">
            <h2 class="text-2xl lg:text-3xl font-bold mb-6 text-center text-gray-800">Masuk ke akun Anda</h2>
            <div class="font-medium text-sm text-green-600 text-center">{{ session('status') }}</div>

            <form action="{{ route('login') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukkan email"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 text-gray-800"
                        value="{{ old('email') }}" required />
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Kata Sandi</label>
                    <x-input-password type="password" name="password" id="password" placeholder="Masukkan kata sandi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-600 text-gray-800"
                        required />
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center text-gray-700">
                        <input type="checkbox" name="remember" class="form-checkbox text-blue-600 h-4 w-4">
                        <span class="ml-2">Ingat saya</span>
                    </label>
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">Lupa kata sandi?</a>
                </div>

                <!-- Tombol Login -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-2.5 rounded-md font-semibold text-base hover:bg-blue-700 transition duration-300 cursor-pointer">
                    Masuk
                </button>
            </form>

            <!-- Link ke Register -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Daftar</a>
            </p>
        </div>
    </div>
</div>
@endsection
