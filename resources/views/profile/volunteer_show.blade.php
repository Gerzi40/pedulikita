@extends('layouts.volunteer')

@section('title', 'Profil')

@section('content')

    <div class="container mx-auto">
        <div class="flex justify-end my-5 pe-7">
            <a href="{{ route('volunteer.profile.edit') }}"
                class="group inline-flex items-center gap-2 px-4 py-2 
                  border border-[var(--color1)] text-[var(--color1)]
                  rounded-full text-sm font-medium
                  transition duration-300 ease-in-out
                  hover:bg-[var(--color1)] hover:text-white
                  hover:shadow-md hover:-translate-y-[1px]">

                <img src="{{ asset('assets/icons/people.png') }}" class="w-4 h-4 transition group-hover:invert" alt="Edit">

                <span>Ubah Profil</span>
            </a>
        </div>
    </div>


    <section>
        <div class="flex flex-col items-center justify-center">
            <img src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" style="max-height: 200px;" />
            <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
            <h2 class="text-base text-gray-400">{{ $user->email }}</h2>
            <h3 class="text-base text-gray-400">{{ $user->volunteer->date_of_birth }}</h3>
            @if ($user->volunteer->gender == 'male')
                <h3 class="text-base text-gray-400">Laki - laki</h3>
            @else
                <h3 class="text-base text-gray-400">Perempuan</h3>
            @endif
        </div>
    </section>

    <section>
        <div class="container mx-auto px-6 py-6 mt-5">
            <div class="flex justify-center items-center gap-24 flex-wrap">
                {{-- Left: Profile Card --}}
                <div class="w-[500px] h-[270px] bg-cover bg-center rounded-xl text-white p-5 flex flex-col justify-between"
                    style="background-image: url('{{ asset('assets/general_image/profile_card.png') }}')">
                    <div class="flex justify-between items-start">
                        <h1 class="text-lg font-semibold">Kartu Relawan</h1>
                        <img src="{{ asset('assets/logo/pedulikita.png') }}" alt="Logo" class="w-32">
                    </div>
                    <div class="ml-5">
                        <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                        <h2 class="text-sm">Bergabung Sejak</h2>
                        <h3 class="text-lg font-semibold">{{ $user->created_at->format('M - Y') }}</h3>
                    </div>
                </div>

                {{-- Right: Statistic Cards --}}
                <div class="flex flex-wrap gap-5">
                    <!-- Card 1 -->
                    <div
                        class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48 border-2 border-[var(--color1)]">
                        <div class="w-14 h-14 flex items-center justify-center  rounded-lg mb-4">
                            <!-- Icon Wallet -->
                            <img src="{{ asset('assets/icons/medals.png') }}" alt="Organisasi"
                                class="w-8 h-8 flex-shrink-0">
                        </div>
                        <h3 class="text-lg font-semibold">Poin</h3>
                        <p class="text-gray-400 text-sm mb-3 text-center min-h-[40px]">Akumulasi Poin</p>
                        <p class="text-2xl font-bold">{{ number_format($user->points) }} <span
                                class="text-gray-500 text-base">pts</span></p>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48 border-2 border-[var(--color1)]">
                        <div class="w-14 h-14 flex items-center justify-center  rounded-lg mb-4">
                            <!-- Icon Event -->
                            <img src="{{ asset('assets/icons/event.png') }}" alt="Event" class="w-8 h-8 flex-shrink-0">
                        </div>
                        <h3 class="text-lg font-semibold">Acara</h3>
                        <p class="text-gray-400 text-sm mb-3 text-center min-h-[40px]">Jumlah Acara Diikuti</p>
                        <p class="text-2xl font-bold">{{ count($events) }}</p>
                    </div>

                    <!-- Card 3 -->
                    <a href="{{ route('volunteer.follow.index') }}"
                        class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48
                        transform transition duration-300 ease-in-out
                        hover:scale-105 hover:shadow-lg border-2 border-[var(--color1)]">

                        <div class="w-14 h-14 flex items-center justify-center rounded-lg mb-4">
                            <img src="{{ asset('assets/icons/organizations.png') }}" alt="Organisasi"
                                class="w-8 h-8 flex-shrink-0">
                        </div>

                        <h3 class="text-lg font-semibold">Organisasi</h3>
                        <p class="text-gray-400 text-sm mb-3 text-center min-h-[40px]">Jumlah Organisasi Diikuti</p>
                        <p class="text-2xl font-bold">{{ $user->volunteer->organizations->count() }}</p>
                    </a>

                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container mx-auto">
            <h1 class="text-3xl mx-4 font-semibold my-5 text-[var(--color1)]">
                Acara yang diikuti
            </h1>
        </div>

        <div class="container mx-auto px-4 pb-10">

            @forelse ($events as $event)
                @if ($loop->first)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @endif

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                        class="w-full h-40 object-cover" />

                    <div class="p-4">
                        <h3 class="font-semibold text-base text-[var(--color2)] mb-2">
                            {{ $event->name }}
                        </h3>

                        {{-- Kategori --}}
                        <div class="flex items-center text-xs mb-1">
                            <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="">
                            <p class="text-[var(--color2)]">
                                {{ $event->event_category->name }}
                            </p>
                        </div>

                        {{-- Lokasi --}}
                        <div class="flex items-center text-xs mb-1">
                            <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="Lokasi">
                            <p class="text-[var(--color2)]">
                                {{ $event->city->name }}, {{ $event->city->province->name }}
                            </p>
                        </div>

                        {{-- Tanggal --}}
                        <div class="flex items-center text-xs">
                            <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="Waktu">
                            <p class="text-[var(--color2)]">
                                {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                            </p>
                        </div>
                    </div>
                </div>

                @if ($loop->last)
        </div>
        @endif

    @empty
        {{-- EMPTY STATE --}}
        <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">

            <img src="{{ asset('assets/icons/calendar.png') }}" class="w-20 h-20 opacity-50 mb-4" alt="Kosong">

            <h3 class="text-lg font-semibold text-[var(--color2)] mb-1">
                Belum Ada Acara
            </h3>

            <p class="text-sm text-gray-400 text-center max-w-sm">
                Kamu belum mengikuti acara apapun. Yuk cari dan daftar acara yang menarik untuk kamu ikuti!
            </p>
        </div>
        @endforelse

        </div>
    </section>


    {{-- <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form> --}}

@endsection
