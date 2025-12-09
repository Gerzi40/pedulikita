@extends('layouts.volunteer')

@section('title', 'Detail Acara')

@section('content')

    {{-- Event Info --}}
    <section class="max-w-6xl mx-auto mt-10 px-4" x-data="{ showConfirmModal: false }">

        {{-- BACK BUTTON --}}
        <a href="{{ route('volunteer.events.index') }}"
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
        <div class="grid md:grid-cols-2 gap-10 items-center">
            {{-- Gambar --}}
            <div>
                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="gambar event"
                    class="rounded-xl shadow-md w-full object-cover">
            </div>

            {{-- Informasi --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi</h3>
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
                            <span>{{ $event->point }} pts</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-700 mb-4">Tanggal dan Waktu</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/date.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/Clock.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                <div>
                    @if ($event->volunteers->contains('id', Auth::user()->id))
                        <p class="mt-4 text-green-600 font-semibold">Anda sudah berpartisipasi</p>
                    @else
                        <form action="{{ route('volunteer.participation.store', ['event_id' => $event->id]) }}"
                            method="POST" id="participationForm">
                            @csrf
                            <button type="button" @click="showConfirmModal = true"
                                class="mt-4 w-fit px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow hover:bg-white hover:text-[var(--color1)] border hover:border-[var(--color1)] transition duration-300 cursor-pointer">
                                Partisipasi
                            </button>
                        </form>
                    @endif
                </div>

                {{-- Modal Konfirmasi Partisipasi --}}
                <div x-show="showConfirmModal" x-cloak x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40">

                    <div @click.away="showConfirmModal = false" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-90" x-transition:enter-end="opacity-100 scale-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 scale-100"
                        x-transition:leave-end="opacity-0 scale-90"
                        class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">

                        <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Partisipasi</h3>
                        <p class="text-gray-600 mb-6">Apakah Anda yakin ingin ikut serta dalam acara ini?</p>

                        <div class="flex justify-end gap-4">
                            {{-- Tombol Batal --}}
                            <button type="button" @click="showConfirmModal = false"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300 cursor-pointer">
                                Batal
                            </button>
                            {{-- Tombol Konfirmasi --}}
                            <button type="button" @click="document.getElementById('participationForm').submit()"
                                class="px-4 py-2 bg-[var(--color1)] text-white rounded-lg hover:bg-[var(--hovercolor1)] transition duration-300 cursor-pointer">
                                Ya, Ikut
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Judul dan Organisasi --}}
    <section class="max-w-6xl mx-auto mt-12 px-4 space-y-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
        <div class="flex justify-between items-center gap-3">
            <a href="{{ route('volunteer.organizations.show', ['id' => $event->organization_id]) }}" class="flex gap-4">
                <img src="{{ Storage::disk('s3')->url($event->organization->user->profile_picture_url) }}" class="w-12 h-12 rounded-full object-cover" alt="">
                <div class="flex flex-col">
                    <span class="text-sm text-gray-600">Dibuat oleh</span>
                    <span class="text-lg font-semibold">{{ $event->organization->user->name }}</span>
                </div>
            </a>

            @if ($event->organization->volunteers->contains('user_id', Auth::user()->id))
                <form action="{{ route('volunteer.follow.destroy', ['organization_id' => $event->organization_id]) }}" method="post" class="flex-shrink-0">
                    @csrf
                    @method('delete')
                    <button type="submit" class="bg-[#960018] hover:bg-[#7E191B] text-white font-semibold cursor-pointer py-2 px-6 rounded-lg shadow-md transition duration-300">
                        Berhenti
                    </button>
                </form>
            @else
                <form action="{{ route('volunteer.follow.store', ['organization_id' => $event->organization_id]) }}" method="post" class="flex-shrink-0">
                    @csrf
                    <button type="submit" class="bg-[var(--color1)] border hover:bg-[var(--hovercolor1)] cursor-pointer border-[var(--color1)] text-white font-semibold py-2 px-6 rounded-lg shadow-md hover:scale-[1.05] transition duration-300">
                        Ikuti
                    </button>
                </form>
            @endif
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


    {{-- <img src="{{ Storage::disk('s3')->url($event->image_url) }}" style="max-height: 200px;"/> --}}

    {{-- {{ $event }} --}}

    {{-- <form action="{{ route('volunteer.participation.store', ['event_id' => $event->id]) }}" method="post">
        @csrf
        <button type="submit">Participate</button>
    </form> --}}

@endsection

@if (session('error'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 7000)"

        x-transition:enter-start="-translate-y-3 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-3 opacity-0"
        
        class="fixed top-20 right-6 z-50"
    >
        <div 
            class="flex items-center gap-3 bg-white border border-red-500
                   text-red-600 px-5 py-3 rounded-md shadow-lg"
        >
            {{-- CHECK ICON --}}
            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"/>
            </svg>


            <span class="font-medium text-sm">
                {{ session('error') }}
            </span>
        </div>
    </div>
@endif
