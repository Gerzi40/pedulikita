@extends('layouts.organization')

@section('title', 'Profil')

@section('content')

    {{-- <a href="{{ route('organization.profile.edit') }}">Edit Profile</a>
    <a href="{{ route('organization.follow.index') }}">Follower</a>

    profile

    <img src="{{ Storage::disk('s3')->url($user->profile_picture_url) }}" style="max-height: 200px;"/> --}}

    <div class="container mx-auto">
        <div class="flex justify-end my-5 pe-7">
            <a href="{{ route('organization.profile.edit') }}"
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
            <a href="{{ route('organization.follow.index') }}"
                class="text-base text-gray-400 hover:underline">{{ $user->organization->volunteers->count() }} pengikut</a>
            <h3 class="text-base text-gray-400">{{ $user->organization->instagram }}</h3>
            <h3 class="text-base text-gray-400">{{ $user->organization->phone }}</h3>
        </div>
    </section>

    <section>
        <div class="container mx-auto">
            <h1 class="text-3xl mx-4 font-semibold my-5">Acara dari {{ $user->name }}</h1>
        </div>
        <div class="container mx-auto px-4 pb-10">
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

                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3">
                                <p class="text-[var(--color2)]">{{ $event->event_category->name }}</p>
                            </div>

                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3">
                                <p class="text-[var(--color2)]">
                                    {{ $event->city->name }},
                                    {{ $event->city->province->name }}
                                </p>
                            </div>

                            <div class="flex items-center text-xs mb-1">
                                <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3">
                                <p class="text-[var(--color2)]">
                                    {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                    • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                                </p>
                            </div>
                        </div>
                    </div>

                @empty
                    {{-- EMPTY EVENT --}}
                    <div class="col-span-full">
                        <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">

                            <img src="{{ asset('assets/icons/calendar.png') }}" class="w-20 h-20 opacity-50 mb-4"
                                alt="Belum Ada Event">

                            <h3 class="text-lg font-semibold text-[var(--color2)] mb-1">
                                Belum Ada Acara
                            </h3>

                            <p class="text-sm text-gray-400 text-center max-w-sm mb-6">
                                Kamu belum membuat acara apapun. Yuk buat event pertamamu sekarang!
                            </p>

                            <a href="{{ route('organization.events.create') }}"
                                class="px-5 py-2 bg-[var(--color1)] text-white text-sm rounded-md
                          hover:bg-[var(--hovercolor1)] transition">
                                + Buat Acara
                            </a>

                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Pengikut</h1>

        @forelse ($volunteers as $vol)
            {{-- GRID NORMAL --}}
            @if ($loop->first)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @endif

            {{-- CARD FOLLOWER --}}
            <div class="relative flex flex-col items-center">
                <!-- Profile Image -->
                <div class="w-24 h-24 rounded-full overflow-hidden shadow-md z-10 bg-white">
                    <img src="{{ Storage::disk('s3')->url($vol->user->profile_picture_url) }}" alt="Profile Picture"
                        class="w-full h-full object-cover">
                </div>

                <!-- Card -->
                <div class="bg-white shadow-xl rounded-2xl mt-[-40px] pt-12 pb-6 px-4 text-center w-60">
                    <h2 class="font-bold text-lg">
                        {{ strtoupper($vol->user->name) }}
                    </h2>
                    <p class="text-gray-500 text-sm">
                        since {{ $vol->created_at->format('m/y') }}
                    </p>
                </div>
            </div>

            @if ($loop->last)
                </div>
            @endif

        @empty

            {{-- EMPTY VOLUNTEERS --}}
            <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">

                <img src="{{ asset('assets/icons/people.png') }}" class="w-20 h-20 opacity-50 mb-4"
                    alt="Belum Ada Pengikut">

                <h3 class="text-lg font-semibold text-[var(--color2)] mb-1">
                    Belum Ada Pengikut
                </h3>

                <p class="text-sm text-gray-400 text-center max-w-sm">
                    Saat ini belum ada volunteer yang mengikuti organisasi kamu.
                    Tetap semangat berbagi kebaikan ya!
                </p>

            </div>
        @endforelse
    </section>



@endsection
