@extends('layouts.app')

@section('navbar')
    <header class="text-white shadow-md sticky top-0 bg-white/70 backdrop-blur-md z-100">
        <div class="container mx-auto px-4 h-20 flex items-center justify-between">
            {{-- Logo --}}
            <a href="{{ route('guest.index') }}" class="flex-shrink-0"> {{-- Menambahkan flex-shrink-0 agar logo tidak mengecil --}}
                {{-- Mengubah warna logo menjadi putih atau disesuaikan dengan logo di gambar --}}
                {{-- Jika logo aslinya berwarna biru, Anda mungkin perlu versi putihnya atau menggunakan CSS filter --}}
                <img src="{{ asset('assets/logo/pedulikita.png') }}" class="h-8" alt="Peduli Kita Logo" />
                {{-- Mengubah tinggi logo menjadi h-8 --}}
            </a>

            {{-- Navigasi Utama --}}
            <nav class="hidden md:flex items-center space-x-8"> {{-- Menggunakan md:flex untuk menampilkan di desktop, items-center untuk rata tengah vertikal, dan space-x-8 untuk jarak antar link --}}
                <a href="{{ route('guest.events.index') }}"
                    class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Acara</a> {{-- Mengubah text-sm menjadi text-base, warna teks putih, dan font-medium --}}
                <a href="{{ route('guest.organizations.index') }}"
                    class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Organisasi</a>
                {{-- Sama seperti di atas --}}
                <a href="#" class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Aktivitas</a>
                {{-- Menambahkan link "Aktifitas" --}}
            </nav>

            {{-- Tombol Daftar & Masuk --}}
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('register') }}"
                    class="px-6 py-2 border text-[var(--color1)] border-[var(--color1)]  rounded-md hover:bg-[var(--color1)] hover:text-white transition duration-300 font-medium">Daftar</a>
                <a href="{{ route('login') }}"
                    class="px-6 py-2 bg-[var(--color1)] text-white rounded-md border border-[var(--color1)] hover:bg-white hover:text-[var(--color1)]  transition duration-300 font-medium">Masuk</a>
            </div>

            {{-- Tombol Hamburger untuk Mobile (jika diperlukan, tidak terlihat di gambar ini) --}}
            {{-- <div class="md:hidden">
            <button class="text-white focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div> --}}
        </div>
    </header>
@endsection
