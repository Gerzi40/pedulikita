@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md text-center">
        
        <!-- Logo -->
        <h1 class="text-2xl font-bold text-[#2263AC] mb-2 tracking-wide">PEDULI<span class="text-[#2263AC]">KITA</span></h1>
        
        <!-- Deskripsi -->
        <p class="text-gray-600 text-sm mb-6">
            Confirm your email, make your new password.<br>
            Remember to store your password wisely.
        </p>

        <!-- Pesan token error -->
        @if(session('status'))
            <div class="bg-green-100 text-green-700 px-4 py-2 text-sm rounded mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->has('token'))
            <div class="bg-red-100 text-red-700 px-4 py-2 text-sm rounded mb-4">
                {{ $errors->first('token') }}
            </div>
        @endif

        <!-- Form Reset -->
        <form action="{{ route('password.store') }}" method="POST" class="text-left">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#2263AC] focus:border-transparent" />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- New Password -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <x-input-password type="password" name="password" id="password" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#2263AC] focus:border-transparent" />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm New Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm new Password</label>
                <x-input-password type="password" name="password_confirmation" id="password_confirmation" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-[#2263AC] focus:border-transparent" />
                @error('password_confirmation')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit -->
            <button type="submit"
                class="w-full bg-[#2263AC] text-white py-2 rounded-md font-semibold hover:bg-[#1d5495] transition duration-200">
                KIRIM
            </button>
        </form>
    </div>
</div>
@endsection

