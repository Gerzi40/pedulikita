@extends('layouts.app')

@section('navbar')

    {{-- <nav class="d-flex gap-4">
        <a href="{{ route('organization.events.index') }}">Events</a>
        <a href="{{ route('organization.leaderboard.index') }}">Leaderboard</a>
        <a href="{{ route('organization.profile.index') }}">Profile</a>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit">Logout</button>
        </form>

        <div>
            Notification
            @foreach (Auth::user()->notifications as $notification)
                <li>{{ $notification->data['title'] }}</li>
            @endforeach
        </div>
    </nav> --}}

    <header class=" text-white shadow-md sticky top-0 bg-white/70 backdrop-blur-md z-100">
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
                <a href="{{ route('organization.events.index') }}"
                    class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Acara</a> {{-- Mengubah text-sm menjadi text-base, warna teks putih, dan font-medium --}}
                <a href="{{ route('organization.leaderboard.index') }}"
                    class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Leaderboard</a>
            </nav>

            <div x-data="{ open: false }" class="relative hidden md:flex items-center space-x-3">
                <div @click="open = !open" class="flex items-center cursor-pointer">
                    <h1 class="text-black text-lg font-semibold mx-3">Hello, {{ Auth::user()->name }}</h1>
                    <img src="{{ Storage::disk('s3')->url(Auth::user()->profile_picture_url) }}" alt="Profile Picture"
                        class="h-10 w-10 rounded-full object-cover border-2 border-[var(--color1)]">
                </div>

                <!-- Dropdown -->
                <div x-show="open" @click.outside="open = false" x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    class="absolute top-14 right-0 w-56 bg-white rounded-xl shadow-lg z-50">
                    <div class="px-4 py-3 border-b">
                        <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                    <ul class="py-2">
                        <li>
                            <a href="{{ route('organization.profile.show') }}"
                                class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
                                ⚙️ My Profile
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
                                    🚪 Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>


        </div>
    </header>
    <script src="//unpkg.com/alpinejs" defer></script>

@endsection