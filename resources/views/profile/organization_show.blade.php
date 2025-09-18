@extends('layouts.organization')

@section('title', 'Profil')

@section('content')

    {{-- <a href="{{ route('organization.profile.edit') }}">Edit Profile</a>
    <a href="{{ route('organization.follow.index') }}">Follower</a>

    profile

    <img src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" style="max-height: 200px;"/> --}}
    
    <div class="container mx-auto">
        <div class="flex justify-end my-5 pe-7">
            <a href="{{ route('organization.profile.edit') }}" class="text-gray-500 cursor-pointer">Ubah data profil?</a>
        </div>
    </div>

    <section>
        <div class="flex flex-col items-center justify-center">
            <img src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" style="max-height: 200px;" />
            <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
            <h2 class="text-base text-gray-400">{{ $user->email }}</h2>
            <a href="{{ route('organization.follow.index') }}" class="text-base text-gray-400 hover:underline">{{ $user->organization->volunteers->count() }} pengikut</a>
            <h3 class="text-base text-gray-400">{{ $user->organization->instagram }}</h3>
            <h3 class="text-base text-gray-400">{{ $user->organization->phone }}</h3>
        </div>
    </section>

    <section>
        <div class="container mx-auto">
            <h1 class="text-3xl mx-4 font-semibold my-5">Acara dari {{ $user->name }}</h1>
        </div>
        <div class="container mx-auto px-4 pb-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Menyesuaikan grid untuk responsif --}}
                @foreach ($events as $event)
                    <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Menambahkan rounded-lg dan shadow-md --}}
                        <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                            class="w-full h-40 object-cover" />
                        <div class="p-4">
                            <h3 class="font-semibold text-base text-[var(--color2)] mb-2">{{ $event->name }}</h3>
                            {{-- Mengubah ukuran font dan menambahkan mb-2 --}}

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

    <section class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Pengikut</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach ($volunteers as $vol)
                <div class="relative flex flex-col items-center">
                    <!-- Profile Image -->
                    <div class="w-24 h-24 rounded-full overflow-hidden shadow-md z-10 bg-white">
                        <img src="{{ Storage::disk('s3')->url($vol->user->profile_picture_url) }}" alt="Profile Picture"
                            class="w-full h-full object-cover">
                    </div>

                    <!-- Card -->
                    <div class="bg-white shadow-xl rounded-2xl mt-[-40px] pt-12 pb-6 px-4 text-center w-60">
                        <h2 class="font-bold text-lg">{{ strtoupper($vol->user->name) }}</h2>
                        <p class="text-gray-500 text-sm">since {{ $vol->created_at->format('m/y') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>



@endsection
