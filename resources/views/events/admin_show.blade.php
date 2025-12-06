@extends('layouts.admin')

@section('title', 'Detail Acara')

@section('content')

    <section class="max-w-6xl mx-auto mt-10 px-4">
        {{-- BACK BUTTON --}}
        <a href="{{ route('admin.events.index') }}"
        class="inline-flex items-center gap-2 px-4 py-2 mb-6
                bg-white text-[var(--color1)] border border-[var(--color1)]
                rounded-md shadow hover:bg-[var(--color1)] hover:text-white
                transition duration-300 w-fit">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-4 h-4"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"/>
            </svg>

            <span class="text-sm font-medium">
                Kembali
            </span>
        </a>
        <div class="grid md:grid-cols-2 gap-10 items-center" x-data="{ showPointModal: false}">
            {{-- Gambar --}}
            <div>
                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="gambar event"
                    class="rounded-xl shadow-md w-full object-cover">
            </div>

            {{-- Informasi --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Informasi</h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->event_category->name }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/people.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->volunteers->count() }} Relawan berpartisipasi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/slot.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->available_slot - $event->volunteers->count() }} Slot tersedia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/point.png') }}" class="w-5 h-5" alt="">
                            <span>{{ !empty($event->point) ? $event->point . ' pts' : '-' }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/date.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d, F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/Clock.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                @if ($event->state === 'pending')
                    <div x-data="{ showPointModal: false }">

                        {{-- BUTTON OPEN MODAL --}}
                        <button type="button" @click="showPointModal = true"
                            class="px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                                border border-transparent hover:bg-white hover:text-[var(--color1)]
                                hover:border-[var(--color1)] transition duration-300 cursor-pointer">
                            Input Poin
                        </button>


                        {{-- MODAL --}}
                        <div x-show="showPointModal" x-transition.opacity
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display:none;">

                            <div @click.away="showPointModal = false"
                                class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">

                                <h3 class="text-lg font-bold mb-4 text-gray-800">
                                    Berikan Poin Event
                                </h3>

                                {{-- FORM APPROVE --}}
                                <form action="{{ route('admin.events.approve', ['id' => $event->id]) }}" method="POST"
                                    class="flex flex-col gap-4">

                                    @csrf
                                    @method('PUT')

                                    <div>
                                        <label class="text-sm font-medium text-gray-700 mb-1 block">
                                            Poin
                                        </label>
                                        <input type="number" name="point" placeholder="Masukkan poin" min="3"
                                            required
                                            class="w-full border rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[var(--color1)] cursor-pointer" />
                                    </div>

                                    <div class="flex justify-end gap-3">
                                        <button type="button" @click="showPointModal = false"
                                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300 transition cursor-pointer">
                                            Batal
                                        </button>

                                        <button type="submit"
                                            class="px-4 py-2 bg-[var(--color1)] text-white rounded-md shadow 
                        border border-transparent hover:bg-white hover:text-[var(--color1)]
                        hover:border-[var(--color1)] transition duration-300 cursor-pointer">
                                            Kirim
                                        </button>
                                    </div>

                                </form>

                            </div>

                        </div>

                    </div>
                @endif


                {{-- @if ($event->state == 'pending')
                    <form action="{{ route('admin.events.destroy', ['id' => $event->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit"
                                    class="px-6 py-2 bg-red-700 text-white font-semibold rounded-md shadow 
                        border border-transparent hover:bg-white hover:text-red-600 hover:border-red-600 
                        transition duration-300">
                                    Hapus
                                </button>
                    </form>
                @endif --}}
            </div>
        </div>
    </section>

    <section class="max-w-6xl mx-auto mt-12 px-4 space-y-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
        <div class="flex justify-between items-center gap-3">
            <a href="{{ route('admin.organizations.show', ['id' => $event->organization_id]) }}" class="flex gap-4">
                <img src="{{ Storage::disk('s3')->url($event->organization->user->profile_picture_url) }}"
                    class="w-12 h-12 rounded-full object-cover" alt="">
                <div class="flex flex-col">
                    <span class="text-sm text-gray-600">Dibuat oleh</span>
                    <span class="text-lg font-semibold">{{ $event->organization->user->name }}</span>
                </div>
            </a>
        </div>
    </section>

    {{-- Deskripsi --}}
    <section class="max-w-6xl mx-auto mt-12 px-4">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Keterangan Acara</h2>
        <p class="text-gray-600 leading-relaxed">
            {{ $event->description }}
        </p>
    </section>

    {{-- Lokasi --}}
    <section class="max-w-6xl mx-auto mt-12 px-4 mb-10">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Lokasi Acara</h2>
        <div>
            {{-- <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain" alt="Lokasi"> --}}
            <p class="mb-2">{{ $event->location }}</p>
            {{-- Menyesuaikan ukuran icon --}}
            <iframe width="100%" height="400" frameborder="0" style="border:0"
                src="https://maps.google.com/maps?q={{ $event->latitude }},{{ $event->longitude }}&hl=id&z=15&output=embed"
                allowfullscreen>
            </iframe>
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
