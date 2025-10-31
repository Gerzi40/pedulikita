@extends('layouts.volunteer')

@section('title', 'Aktivitas')

@section('content')

    <div class="container mx-auto">
        <h2 class="text-3xl font-bold text-[var(--color1)] mt-5 ml-4">Acara yang diikuti</h2>
    </div>

    <section class="py-10">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                            class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <h3 class="font-semibold text-base text-[var(--color2)] mb-2">{{ $event->name }}</h3>

                            {{-- Kategori --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3 object-contain" alt="">
                                <p class="text-[var(--color2)]">{{ $event->event_category->name }}</p>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Lokasi">
                                <p class="text-[var(--color2)]">{{ $event->city->name }}, {{ $event->city->province->name }}</p>
                            </div>

                            {{-- Tanggal & Waktu --}}
                            <div class="flex items-center text-gray-500 text-xs mb-1">
                                <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Waktu">
                                <p class="text-[var(--color2)]">
                                    {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

@endsection
