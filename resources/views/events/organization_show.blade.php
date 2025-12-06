@extends('layouts.organization')

@section('title', 'Detail Acara')

@section('content')

    <section class="max-w-6xl mx-auto mt-10 px-4">

        {{-- BACK BUTTON --}}
        <a href="{{ route('organization.events.index') }}"
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

        <div class="grid md:grid-cols-2 gap-10 items-center" x-data="{ showConfirmModal: false }">

            {{-- Gambar --}}
            <div>
                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Gambar Event"
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
                            <span>
                                {{ filled($event->point) ? $event->point . ' pts' : 'Poin belum ditetapkan oleh admin' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/date.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d F Y') }}</span>
                        </div>

                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/clock.png') }}" class="w-5 h-5" alt="">
                            <span>
                                {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB
                            </span>
                        </div>

                    </div>
                </div>


                {{-- ACTION BUTTONS --}}
                <div class="flex items-center gap-4 mt-4">

                    {{-- Tombol Hapus --}}
                    @if ($event->state == 'pending')
                        <form x-ref="deleteForm" action="{{ route('organization.events.destroy', ['id' => $event->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')

                            <button type="button" @click="showConfirmModal = true"
                                class="inline-flex px-6 py-2 bg-[#960018] text-white font-semibold rounded-md shadow 
                            border border-transparent hover:bg-white hover:text-[#960018]
                            hover:border-[#960018] transition duration-300 cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    @endif


                    {{-- Tombol Edit --}}
                    @if ($event->state == 'pending')
                        <a href="{{ route('organization.events.edit', ['id' => $event->id]) }}"
                            class="inline-flex px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                        border border-transparent hover:bg-white hover:text-[var(--color1)]
                        hover:border-[var(--color1)] transition duration-300">
                            Ubah
                        </a>
                    @endif


                    {{-- Tombol Lihat Relawan --}}
                    @if ($event->state === 'approved' || $event->state === 'finished')
                        <a href="{{ route('organization.participation.index', ['event_id' => $event->id]) }}"
                            class="inline-flex px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                        border border-[var(--color1)] hover:bg-white hover:text-[var(--color1)]
                        transition duration-300">
                            Lihat Relawan
                        </a>
                    @endif

                </div>


                {{-- MODAL CONFIRM DELETE --}}
                <div x-show="showConfirmModal" x-transition.opacity
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" style="display: none;">

                    <div @click.away="showConfirmModal = false"
                        class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md mx-4">

                        <h3 class="text-xl font-bold mb-3 text-gray-800">
                            Konfirmasi Penghapusan
                        </h3>

                        <p class="text-gray-600 mb-6">
                            Apakah Anda yakin ingin menghapus event ini?
                            Tindakan ini tidak dapat dibatalkan.
                        </p>

                        <div class="flex justify-end gap-4">

                            <button type="button" @click="showConfirmModal = false"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300">
                                Batal
                            </button>

                            <button type="button" @click="$refs.deleteForm.submit()"
                                class="px-4 py-2 bg-[#960018] text-white rounded-lg hover:bg-[#7E191B] transition duration-300">
                                Ya, Hapus
                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <section class="max-w-6xl mx-auto mt-12 px-4">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
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
