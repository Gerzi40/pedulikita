@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
        
        <!-- Logo / Judul -->
        <h1 class="text-2xl font-bold text-[#2263AC] mb-2 tracking-wide">PEDULI<span class="text-[#2263AC]">KITA</span></h1>
        
        <!-- Deskripsi -->
        <p class="text-gray-600 text-sm mb-6">
            Enter your email for the verification process,<br>
            we will reset password link to your email.
        </p>

        <div class="font-medium text-sm text-green-600">{{ session('status') }}</div>

        <!-- Form -->
        <form action="{{ route('password.email') }}" method="POST" class="text-left">
            @csrf

            <!-- Input Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" placeholder="Masukkan email"
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#2263AC] focus:border-transparent"
                    required />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tombol Kirim -->
            <button type="submit"
                class="w-full bg-[#2263AC] text-white py-2 rounded-md font-semibold hover:bg-[#1d5495] transition duration-200">
                KIRIM
            </button>
        </form>
    </div>
</div>
@endsection

