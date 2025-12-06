@extends('layouts.app')

@section('navbar')

    <nav class="shadow-lg sticky top-0 bg-white/70 backdrop-blur-md z-100">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('volunteer.events.index') }}">
                        <img src="{{ asset('assets/logo/pedulikita.png') }}" class="h-5 md:h-6 lg:h-7" alt="Peduli Kita Logo" />
                    </a>
                </div>

                <!-- Link -->
                <div class="hidden lg:flex lg:items-center lg:space-x-8">
                    <a href="{{ route('volunteer.events.index') }}"         class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Acara</a>
                    <a href="{{ route('volunteer.organizations.index') }}"  class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Organisasi</a>
                    <a href="{{ route('volunteer.participation.index') }}"  class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Aktivitas</a>
                    <a href="{{ route('volunteer.news.index') }}"           class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Berita</a>
                    <a href="{{ route('volunteer.leaderboard.index') }}"    class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Leaderboard</a>
                </div>

                <div class="hidden lg:flex lg:items-center lg:space-x-3">
                    <!-- Notification -->
                    <div x-data="{ openNotif: false }" class="relative">
                        <div @click="openNotif = !openNotif" class="cursor-pointer relative">
                            <img src="{{ asset('assets/icons/Notif.png') }}" class="w-5 h-5" alt="Notif">
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>

                        <div x-show="openNotif" @click.outside="openNotif = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-2 w-80 max-h-40 overflow-y-auto bg-white rounded-xl shadow-lg z-50">
                            <div class="px-4 py-3 border-b sticky top-0 bg-white">
                                <p class="font-semibold text-gray-800">Notifikasi</p>
                            </div>
                            <ul class="divide-y">
                                @forelse (Auth::user()->notifications as $notification)
                                    <a href="{{ route($notification->data['route'], ['id' => $notification->data['id']]) }}">
                                        <li class="px-4 py-3 hover:bg-gray-100">
                                            <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] }}</p>
                                            <p class="text-xs font-normal text-gray-800">{{ $notification->data['content'] }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </li>
                                    </a>
                                @empty
                                    <li class="px-4 py-6 text-center text-gray-500">Belum Ada Notifikasi</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Profile -->
                    <div x-data="{ open: false }" class="relative hidden md:flex items-center space-x-3">
                        <div @click="open = !open" class="flex items-center cursor-pointer">
                            <h1 class="text-black text-lg font-semibold mx-3">Halo, {{ Auth::user()->name }}</h1>
                            <img src="{{ Storage::disk('s3')->url(Auth::user()->profile_picture_url) }}" alt="Profile Picture"
                                class="h-10 w-10 rounded-full object-cover border-2 border-[var(--color1)]">
                        </div>

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
                                    <a href="{{ route('volunteer.profile.show') }}"
                                        class="flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm cursor-pointer">
                                        ⚙️ Profil Saya
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="w-full text-left flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm cursor-pointer">
                                            🚪 Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 lg:hidden">
                    <!-- Notification -->
                    <div x-data="{ openNotif: false }" class="relative">
                        <div @click="openNotif = !openNotif" class="cursor-pointer relative">
                            <img src="{{ asset('assets/icons/Notif.png') }}" class="w-5 h-5" alt="Notif">
                            @if (Auth::user()->unreadNotifications->count() > 0)
                                <span
                                    class="absolute -top-1 -right-1 bg-red-500 text-white text-xs w-4 h-4 flex items-center justify-center rounded-full">
                                    {{ Auth::user()->unreadNotifications->count() }}
                                </span>
                            @endif
                        </div>

                        <div x-show="openNotif" @click.outside="openNotif = false"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-2 w-80 max-h-40 overflow-y-auto bg-white rounded-xl shadow-lg z-50">
                            <div class="px-4 py-3 border-b sticky top-0 bg-white">
                                <p class="font-semibold text-gray-800">Notifikasi</p>
                            </div>
                            <ul class="divide-y">
                                @forelse (Auth::user()->notifications as $notification)
                                    <a href="{{ route($notification->data['route'], ['id' => $notification->data['id']]) }}">
                                        <li class="px-4 py-3 hover:bg-gray-100">
                                            <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] }}</p>
                                            <p class="text-xs font-normal text-gray-800">{{ $notification->data['content'] }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}
                                            </p>
                                        </li>
                                    </a>
                                @empty
                                    <li class="px-4 py-6 text-center text-gray-500">Belum Ada Notifikasi</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    <!-- Menu -->
                    <button id="mobile-menu-button" type="button" class="inline-flex items-center justify-center p-2 rounded-md text-[var(--color1)] hover:text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Dropdown -->
        <div class="lg:hidden hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="{{ route('volunteer.events.index') }}"         class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Acara</a>
                <a href="{{ route('volunteer.organizations.index') }}"  class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Organisasi</a>
                <a href="{{ route('volunteer.participation.index') }}"  class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Aktivitas</a>
                <a href="{{ route('volunteer.news.index') }}"           class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Berita</a>
                <a href="{{ route('volunteer.leaderboard.index') }}"    class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Leaderboard</a>
                <a href="{{ route('volunteer.profile.show') }}"         class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Profil Saya</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </nav>

    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        document.getElementById('mobile-menu-button').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            const button = this;

            menu.classList.toggle('hidden');

            const openIcon = button.querySelector('svg:nth-child(1)');
            const closeIcon = button.querySelector('svg:nth-child(2)');
            openIcon.classList.toggle('hidden');
            closeIcon.classList.toggle('hidden');
        });
    </script>

@endsection
