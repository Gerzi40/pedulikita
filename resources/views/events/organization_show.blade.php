@extends('layouts.organization')

@section('title', 'Detail Acara')

@section('content')

    <section class="max-w-6xl mx-auto mt-10 px-4">
        <div class="grid md:grid-cols-2 gap-10 items-center">
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
                            <span>{{ $event->point }} pts</span>
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

                <div class="flex items-center gap-4 mt-4">
                    <!-- Tombol Hapus -->
                    @if($event->state == 'pending')
                        <form action="{{ route('organization.events.destroy', ['id' => $event->id]) }}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit"
                                class="inline-flex px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                                border border-transparent
                                hover:bg-white hover:text-[var(--color1)] hover:border-[var(--color1)] 
                                transition duration-300 cursor-pointer">
                                Hapus
                            </button>
                        </form>
                    @endif

                    <!-- Tombol Edit -->
                    @if ($event->state == 'pending')
                        <a href="{{ route('organization.events.edit', ['id' => $event->id]) }}"
                            class="inline-flex px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                            border border-transparent
                            hover:bg-white hover:text-[var(--color1)] hover:border-[var(--color1)] 
                            transition duration-300">
                            Ubah
                        </a>
                    @endif

                    @if ($event->state == 'approved' || $event->state == 'finished')
                        <a href="{{ route('organization.participation.index', ['event_id' => $event->id]) }}"
                            class="group inline-flex px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow 
                                border border-[var(--color1)]
                                transition duration-300 hover:bg-white hover:text-[var(--color1)] hover:shadow-md hover:border-[var(--color1)]">
                            <div class="flex justify-center items-center gap-2">
                                <h1>Lihat Relawan</h1>
                            </div>
                        </a>
                    @endif
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
