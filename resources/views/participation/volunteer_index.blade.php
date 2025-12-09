@extends('layouts.volunteer')

@section('title', 'Aktivitas')

@section('content')

    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-[var(--color1)] mt-5 ml-4">Acara yang diikuti</h2>
    </div>

    <section class="py-10">
        <div class="container mx-auto px-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse ($events as $event)
                    {{-- CARD EVENT --}}
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                            class="w-full h-40 object-cover" />

                        <div class="p-4">
                            <h3 class="font-semibold text-base text-[var(--color2)] mb-2">
                                {{ $event->name }}
                            </h3>

                            {{-- Kategori --}}
                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3 object-contain">
                                <p class="text-[var(--color2)]">
                                    {{ $event->event_category->name }}
                                </p>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain">
                                <p class="text-[var(--color2)]">
                                    {{ $event->city->name }},
                                    {{ $event->city->province->name }}
                                </p>
                            </div>

                            {{-- Tanggal --}}
                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain">
                                <p class="text-[var(--color2)]">
                                    {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                                </p>
                            </div>

                            {{-- Tombol Lihat --}}
                            <div class="flex justify-end">
                                <a href="{{ route('volunteer.events.show', ['id' => $event->id]) }}"
                                    class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                            </div>
                        </div>
                    </div>

                @empty

                    {{-- EMPTY STATE --}}
                    <div class="col-span-full">
                        <div class="min-h-screen flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">

                            <img src="{{ asset('assets/icons/calendar.png') }}" class="w-20 h-20 opacity-50 mb-4"
                                alt="Belum Ada Acara">

                            <h3 class="text-lg font-semibold text-[var(--color2)] mb-1">
                                Belum Ada Acara Yang Diikuti
                            </h3>

                            <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                                Saat ini belum ada acara yang diikuti. <br>
                                Yuk daftar acara sekarang!
                            </p>

                            {{-- Optional: tombol CTA --}}
                            <a href="{{ route('volunteer.events.index') }}"
                                class="px-5 py-2 bg-[var(--color1)] text-white text-sm rounded-md
                                  hover:bg-[var(--hovercolor1)] transition">
                                Telusuri Acara
                            </a>

                        </div>
                    </div>
                @endforelse

            </div>
        </div>
    </section>


@endsection

@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3500)"

        x-transition:enter-start="-translate-y-3 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-3 opacity-0"
        
        class="fixed top-20 right-6 z-50"
    >
        <div 
            class="flex items-center gap-3 bg-white border border-green-500 
                   text-green-600 px-5 py-3 rounded-md shadow-lg"
        >
            {{-- CHECK ICON --}}
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="font-medium text-sm">
                {{ session('success') }}
            </span>
        </div>
    </div>
@endif
