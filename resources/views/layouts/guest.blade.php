@extends('layouts.app')

@section('navbar')

    <nav class="shadow-lg sticky top-0 bg-white/70 backdrop-blur-md z-100">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('guest.index') }}">
                        <img src="{{ asset('assets/logo/pedulikita.png') }}" class="h-5 md:h-6 lg:h-7" alt="Peduli Kita Logo" />
                    </a>
                </div>

                <!-- Link -->
                <div class="hidden lg:flex lg:items-center lg:space-x-8">
                    <a href="{{ route('guest.events.index') }}"         class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Acara</a>
                    <a href="{{ route('guest.organizations.index') }}"  class="text-[var(--color1)] hover:text-gray-300 text-base font-medium">Organisasi</a>
                </div>

                <!-- Button -->
                <div class="hidden lg:flex lg:items-center lg:space-x-4">
                    <a href="{{ route('guest.organizations.create') }}" class="px-6 py-2 border text-[var(--color1)] border-[var(--color1)] rounded-md hover:bg-[var(--color1)] hover:text-white transition duration-300 font-medium">Daftar Organisasi</a>
                    <a href="{{ route('register') }}"                   class="px-6 py-2 border text-[var(--color1)] border-[var(--color1)] rounded-md hover:bg-[var(--color1)] hover:text-white transition duration-300 font-medium">Daftar</a>
                    <a href="{{ route('login') }}"                      class="px-6 py-2 border text-[var(--color1)] border-[var(--color1)] rounded-md hover:bg-[var(--color1)] hover:text-white transition duration-300 font-medium">Masuk</a>
                </div>

                <!-- Menu -->
                <div class="flex items-center lg:hidden">
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
                <a href="{{ route('guest.events.index') }}"         class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Acara</a>
                <a href="{{ route('guest.organizations.index') }}"  class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Organisasi</a>
                <a href="{{ route('guest.organizations.create') }}" class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Daftar Organisasi</a>
                <a href="{{ route('register') }}"                   class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Daftar</a>
                <a href="{{ route('login') }}"                      class="text-[var(--color1)] block px-3 py-2 rounded-md text-base font-medium">Masuk</a>
            </div>
        </div>
    </nav>

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
