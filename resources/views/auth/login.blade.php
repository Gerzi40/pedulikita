@extends('layouts.app')

@section('title', 'Masuk')

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
        <div class="md:w-1/2 p-6 lg:p-10 bg-white md:h-full flex flex-col">
            <div class="mb-6">
                <a href="{{ route('guest.index') }}"
                        class="inline-flex items-center gap-2 px-4 py-2
           border border-[var(--color1)] text-[var(--color1)]
           rounded-md hover:bg-[var(--color1)] hover:text-white transition">
    
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
    
                        <span class="text-sm font-medium">
                            Kembali
                        </span>
                    </a>
            </div>

            <div class="flex flex-col justify-center h-[calc(100%-60px)]">
                <h2 class="text-2xl lg:text-3xl font-bold mb-6 text-gray-800 text-center">Masuk ke akun Anda</h2>
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
                            <input type="checkbox" name="remember" class="form-checkbox text-[var(--color1)] h-4 w-4">
                            <span class="ml-2">Ingat saya</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-[var(--color1)] hover:underline">Lupa kata sandi?</a>
                    </div>
    
                    <!-- Tombol Login -->
                    <button type="submit"
                        class="w-full bg-[var(--color1)] text-white py-2.5 rounded-md font-semibold text-base hover:bg-[var(--hovercolor1)] transition duration-300 cursor-pointer">
                        Masuk
                    </button>
                </form>
            </div>

            <div class="font-medium text-sm text-green-600 text-center">{{ session('status') }}</div>


            <!-- Link ke Register -->
            <p class="text-center text-sm text-gray-600 mt-4">
                Belum punya akun? 
                <a href="{{ route('register') }}" class="text-[var(--color1)] hover:underline font-medium">Daftar</a>
            </p>
        </div>
    </div>
</div>
@endsection
