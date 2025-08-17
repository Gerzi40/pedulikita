@extends('layouts.admin')

@section('title', 'Admin Organizations Show')

@section('content')

    {{-- <a href="{{ route('admin.organizations.edit', ['id' => $organization->id]) }}">Edit</a>

    <form action="{{ route('admin.organizations.destroy', ['id' => $organization->id]) }}" method="post">
        @csrf
        @method('delete')
        <button type="submit">Delete</button>
    </form> --}}

    <div class="container mx-auto px-4 py-8">
        <div class="flex items-center space-x-6 mb-8">
            {{-- Bagian Logo dan Nama Organisasi --}}
            <div class="flex-shrink-0">
                {{-- Pastikan $organization->user->profile_picture_url mengarah ke gambar yang benar --}}
                <img src="{{ Storage::disk('s3')->url($organization->user->profile_picture_url) }}" alt="Logo Organisasi"
                    class="w-48 h-48 object-cover rounded-full border-2 border-gray-200">
            </div>
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $organization->user->name }}</h1>
                <div class="flex gap-5 mt-5">
                    <a href="{{ route('admin.organizations.edit', ['id' => $organization->id]) }}"
                        class="bg-[var(--color1)] hover:bg-[var(--hovercolor1)] cursor-pointer text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300">Edit</a>

                    <form action="{{ route('admin.organizations.destroy', ['id' => $organization->id]) }}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold py-2 px-6 rounded-lg shadow-md transition duration-300">Delete</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Keterangan Organisasi --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Keterangan Organisasi</h2>
            <p class="text-gray-700 leading-relaxed">
                {{ $organization->description ?? 'Lorem ipsum dolor sit amet consectetur. Eget vulputate sociis sit urna sit aliquet. Vivamus facilisis diam libero dolor volutpat diam eu. Quis a id posuere etiam at enim vivamus. Urna nisi malesuada libero enim ornare in viverra. Nibh commodo quis tellus aliquet nibh tristique lobortis id. Consequat ultricies vulputate turpis neque viverra tempor nunc. Et amet massa tellus consequat mauris imperdiet tellus. Praesent risus magna nisl turpis egestas ultrices viverra pellentesque blandit. Rutrum consequat eu penatibus ipsum at.' }}
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Informasi --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Informasi</h2>
                <div class="space-y-2 text-gray-700">
                    <p class="flex items-center"><i class="fas fa-users mr-2 text-gray-500"></i>
                        {{ count($organization->volunteers) }} Pengikut</p>
                    <p class="flex items-center"><i class="fas fa-hand-holding-heart mr-2 text-gray-500"></i>
                        {{ $organization->events->where('date', '<', now())->count() }} Event terlaksana</p>
                    <p class="flex items-center"><i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        {{ count($organization->events) ?? 2 }} Event tersedia</p>
                </div>
            </div>

            {{-- Detail --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Detail</h2>
                <div class="space-y-2 text-gray-700">
                    <p class="flex items-center"><i class="fas fa-building mr-2 text-gray-500"></i> Organisasi
                        {{ $organization->organization_category->name }}</p>
                    <p class="flex items-center"><i class="fas fa-calendar-plus mr-2 text-gray-500"></i> didirikan sejak
                        {{ $organization->founded_at ? \Carbon\Carbon::parse($organization->founded_at)->format('m/y') : '02/21' }}
                    </p>
                    <p class="flex items-center"><i class="fas fa-map-marker-alt mr-2 text-gray-500"></i>
                        {{ $organization->location ?? 'Jakarta, Indonesia' }}</p>
                </div>
            </div>

            {{-- Hubungi --}}
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-3">Hubungi</h2>
                <div class="space-y-2 text-gray-700">
                    <p class="flex items-center"><i class="fas fa-at mr-2 text-gray-500"></i>
                        {{ $organization->instagram }}</p>
                    <p class="flex items-center"><i class="fas fa-phone mr-2 text-gray-500"></i>
                        {{ $organization->phone }}</p>
                    <p class="flex items-center"><i class="fas fa-envelope mr-2 text-gray-500"></i>
                        {{ $organization->user->email }}</p>
                </div>
            </div>
        </div>

        <div class="mt-10">
            <section class="py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-xl font-bold text-[var(--color1)] mb-6">Acara dari {{ $organization->user->name }}</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"> {{-- Menyesuaikan grid untuk responsif --}}
                        @foreach ($organization->events as $event)
                            <div class="bg-white shadow-md rounded-lg overflow-hidden"> {{-- Menambahkan rounded-lg dan shadow-md --}}
                                <div class="relative w-full h-40">
                                    <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                                        class="w-full h-full object-cover" />

                                    {{-- Badge Status --}}
                                    @if ($event->state == 'approved')
                                        <div
                                            class="absolute top-2 right-2 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            {{ $event->state }}
                                        </div>
                                    @elseif ($event->state == 'rejected')
                                        <div
                                            class="absolute top-2 right-2 bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            {{ $event->state }}
                                        </div>
                                    @else
                                        <div
                                            class="absolute top-2 right-2 bg-[var(--color1)] text-white text-xs font-semibold px-3 py-1 rounded-full shadow-md">
                                            {{ $event->state }}
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-base text-[var(--color2)] mb-2">{{ $event->name }}</h3>
                                    {{-- Mengubah ukuran font dan menambahkan mb-2 --}}

                                    {{-- Lokasi --}}
                                    <div class="flex items-center text-gray-500 text-xs mb-1"> {{-- Menambahkan items-center dan mb-1 --}}
                                        <img src="{{ asset('assets/icons/Vector.png') }}"
                                            class="mr-2 h-3 w-3 object-contain" alt="Lokasi"> {{-- Menyesuaikan ukuran icon --}}
                                        <p class="text-[var(--color2)]">{{ $event->city->name }},
                                            {{ $event->city->province->name }}</p>
                                    </div>

                                    {{-- Tanggal & Waktu --}}
                                    <div class="flex items-center text-gray-500 text-xs mb-1">
                                        <img src="{{ asset('assets/icons/Clock.png') }}"
                                            class="mr-2 h-3 w-3 object-contain" alt="Waktu">
                                        <p class="text-[var(--color2)]">
                                            {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                            • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
                                    </div>

                                    {{-- Slot Tersedia --}}
                                    <div class="flex items-center text-gray-500 text-xs mb-4">
                                        <img src="{{ asset('assets/icons/Crowd.png') }}"
                                            class="mr-2 h-3 w-3 object-contain" alt="Slot">
                                        <p class="text-[var(--color2)]">Tersedia
                                            {{ $event->available_slot - $event->volunteers->count() }} slot</p>
                                        {{-- Menambahkan teks "Tersedia ... slot" --}}
                                    </div>

                                    {{-- Tombol Lihat --}}
                                    <div class="flex justify-end"> {{-- Menggunakan justify-end untuk memposisikan tombol di kanan --}}
                                        <a href="{{ route('admin.events.show', ['id' => $event->id]) }}"
                                            class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                                        {{-- Mengubah button menjadi link a dan menambahkan styling Tailwind --}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection
