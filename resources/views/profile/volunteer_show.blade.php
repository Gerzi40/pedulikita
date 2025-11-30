@extends('layouts.volunteer')

@section('title', 'Profil')

@section('content')

    <div class="container mx-auto">
        <div class="flex justify-end my-5 pe-7">
            <a href="{{ route('volunteer.profile.edit') }}" class="text-gray-500 cursor-pointer hover:underline transition-all duration-200">Ubah Profil</a>
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
                        <h2 class="text-sm">Joined</h2>
                        <h3 class="text-lg font-semibold">{{ $user->created_at->format('m/y') }}</h3>
                    </div>
                </div>

                {{-- Right: Statistic Cards --}}
                <div class="flex flex-wrap gap-5">
                    <!-- Card 1 -->
                    <div class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48">
                        <div class="w-14 h-14 flex items-center justify-center bg-[var(--color1)] rounded-lg mb-4">
                            <!-- Icon Wallet -->
                            <img src="{{ asset('assets/icons/medals.png') }}" alt="Organisasi" class="w-8 h-8 flex-shrink-0">
                        </div>
                        <h3 class="text-lg font-semibold">Poin</h3>
                        <p class="text-gray-400 text-sm mb-3 text-center min-h-[40px]">Akumulasi Poin</p>
                        <p class="text-2xl font-bold">{{ number_format($user->points) }} <span
                                class="text-gray-500 text-base">pts</span></p>
                    </div>

                    <!-- Card 2 -->
                    <div class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48">
                        <div class="w-14 h-14 flex items-center justify-center bg-[var(--color1)] rounded-lg mb-4">
                            <!-- Icon Event -->
                            <img src="{{ asset('assets/icons/event.png') }}" alt="Event" class="w-8 h-8 flex-shrink-0">
                        </div>
                        <h3 class="text-lg font-semibold">Acara</h3>
                        <p class="text-gray-400 text-sm mb-3 text-center min-h-[40px]">Jumlah Acara Diikuti</p>
                        <p class="text-2xl font-bold">{{ count($events) }}</p>
                    </div>

                    <!-- Card 3 -->
                    <a href="{{ route('volunteer.follow.index') }}" class="flex flex-col items-center p-6 bg-white rounded-2xl shadow-md w-48">
                        <div class="w-14 h-14 flex items-center justify-center bg-[var(--color1)] rounded-lg mb-4">
                            <!-- Icon Event -->
                            <img src="{{ asset('assets/icons/organizations.png') }}" alt="Organisasi" class="w-8 h-8 flex-shrink-0">
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
            <h1 class="text-3xl mx-4 font-semibold my-5">Acara yang diikuti</h1>
        </div>
        <div class="container mx-auto px-4 pb-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Menyesuaikan grid untuk responsif --}}
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Menambahkan rounded-lg dan shadow-md --}}
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
                            <div class="flex items-center text-gray-500 text-xs mb-1"> {{-- Menambahkan items-center dan mb-1 --}}
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                    alt="Lokasi"> {{-- Menyesuaikan ukuran icon --}}
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

    {{-- <form action="{{ route('logout') }}" method="post">
        @csrf
        <button type="submit">Logout</button>
    </form> --}}

@endsection
