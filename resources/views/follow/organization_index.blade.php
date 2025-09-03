@extends('layouts.organization')

@section('title', 'Relawan Pengikut')

@section('content')

    <section class="container mx-auto px-4 py-5">
        <h1 class="text-3xl font-bold text-[var(--color1)] mb-5">Relawan Pengikut</h1>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-8">
            @foreach ($volunteers as $volunteer)
                <div class="flex flex-col items-center pt-6 bg-white rounded-lg shadow-lg">
                    <div class="w-24 h-24 rounded-full">
                        <img src="{{ Storage::disk('s3')->url($volunteer->user->profile_picture_url) }}" alt="Profile Picture"
                            class="w-full h-full rounded-full object-cover">
                    </div>

                    <div class="p-3 text-center">
                        <h2 class="font-bold text-lg">{{ strtoupper($volunteer->user->name) }}</h2>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

@endsection