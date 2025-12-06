@extends('layouts.guest')

@section('title', 'Beranda')

@section('content')

    <!-- Hero -->
    <section class="relative h-120 flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('assets/hero/hero_1.png') }}" alt="Background image of people helping"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black opacity-50"></div>
        </div>

        <div class="relative z-10 text-white text-center p-4 max-w-2xl mx-auto">
            <p class="text-lg md:text-xl font-semibold mb-2">Halo Relawan, Selamat Datang di</p>
            <h1 class="text-5xl md:text-7xl font-extrabold mb-4 leading-tight">Peduli Kita</h1>
            <p class="text-base md:text-lg mb-8">Dengan uluran tangan Anda, dapat menggapai kebaikan ke seluruh dunia.</p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('register') }}" class="bg-[var(--color1)] hover:bg-[var(--hovercolor1)] text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out shadow-lg">
                    Gabung Sekarang!</a>
                {{-- <button
                    class="border-2 border-white hover:border-gray-300 text-white font-bold py-3 px-8 rounded-full transition duration-300 ease-in-out">Lihat
                    Lanjut</button> --}}
            </div>
        </div>
    </section>

    <h2 class="text-4xl font-bold text-center mb-10 mt-10">Organisasi Favorit</h2>
    <section class="container mx-auto px-4 md:px-6 lg:px-8 mb-10">
        <div class="flex flex-col lg:flex-row items-center lg:items-stretch gap-5">
            @foreach ($organizations as $organization)
                <div class="flex flex-col justify-between item bg-white shadow-md rounded-lg p-3 w-60 lg:w-[20%]">
                    <div>
                        <div class="flex justify-center">
                            <img src="{{ Storage::disk('s3')->url($organization->user->profile_picture_url) }}" class="w-30 h-30 object-contain"/>
                        </div>
                        <h3 class="text-xl font-semibold mb-1">{{ $organization->user->name }}</h3>
                    </div>
                    <div class="flex justify-between items-center">
                        <p>{{ count($organization->volunteers) }} pengikut</p>
                        <a href="{{ route('guest.organizations.show', ['id' => $organization->id]) }}" class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <h2 class="text-4xl font-bold text-center mb-10">Ayo Eksplor!</h2>
    <section class="container mx-auto px-4 md:px-6 lg:px-8 mb-10">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($events as $event)
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
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
                        <div class="flex items-center text-gray-500 text-xs mb-1">
                            <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="Lokasi">
                            <p class="text-[var(--color2)]">{{ $event->city->name }}, {{ $event->city->province->name }}</p>
                        </div>

                        {{-- Tanggal & Waktu --}}
                        <div class="flex items-center text-gray-500 text-xs mb-1">
                            <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="Waktu">
                            <p class="text-[var(--color2)]">{{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB</p>
                        </div>

                        {{-- Slot Tersedia --}}
                        <div class="flex items-center text-gray-500 text-xs mb-4">
                            <img src="{{ asset('assets/icons/Crowd.png') }}" class="mr-2 h-3 w-3 object-contain"
                                alt="Slot">
                            <p class="text-[var(--color2)]">Tersedia {{ $event->available_slot - $event->volunteer_count }} slot</p>
                            {{-- Menambahkan teks "Tersedia ... slot" --}}
                        </div>

                        {{-- Tombol Lihat --}}
                        <div class="flex justify-end">
                            <a href="{{ route('guest.events.show', ['id' => $event->id]) }}"
                                class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)] focus:outline-none focus:ring-2 focus:ring-[var(--hovercolor1)] focus:ring-opacity-50">Lihat</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <h2 class="text-4xl font-bold text-center mb-10">Tentang PeduliKita</h2>
    <section class="container mx-auto px-4 md:px-6 lg:px-8 mb-10 space-y-5">
        <div class="flex flex-col lg:flex-row items-center gap-3 md:gap-5">
            <img src="{{ asset('assets/general_image/landing_1.png') }}" class="rounded-xl"/>

            <div>
                <h3 class="text-2xl font-bold">Sejarah Peduli<span class="text-[var(--color1)]">Kita</span></h3>
                <p class="text-sm md:text-base mt-2 text-black">
                    Peduli Kita adalah platform event sosial berbasis gamifikasi yang didirikan pada tahun 2025 oleh tiga
                    mahasiswa Binus University: Timothy Purnawan, Juwan Jatmiko, dan Garry Nathanael. Terinspirasi oleh
                    semangat untuk menciptakan dunia yang lebih baik, mereka membangun Peduli Kita sebagai wadah kolaboratif
                    yang mengubah aksi sosial menjadi pengalaman yang menyenangkan dan interaktif.
                </p>
                <p class="text-sm md:text-base mt-2 text-gray-700">
                    Melalui pendekatan gamifikasi, pengguna tidak hanya dapat berpartisipasi dalam berbagai kegiatan sosial,
                    tetapi juga mendapatkan penghargaan, lencana, dan level pencapaian yang mendorong keterlibatan jangka
                    panjang. Peduli Kita percaya bahwa
                </p>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row-reverse items-center gap-5">
            <img src="{{ asset('assets/general_image/landing_2.png') }}" class="rounded-xl"/>
    
            <div>
                <h3 class="text-2xl font-bold"><span class="text-[var(--color1)]">Kenapa</span> PeduliKita?</h3>
                <p class="text-sm md:text-base mt-2  text-black">
                    Melalui website ini, pengguna bisa mendapatkan poin, naik level, dan meraih lencana setiap kali
                    mengikuti event sosial — layaknya bermain game, tapi dengan dampak nyata.
                </p>
                <p class="text-sm md:text-base mt-2 text-gray-700">
                    Didirikan oleh tiga mahasiswa Binus pada tahun 2025, Peduli Kita lahir dari keinginan untuk menciptakan
                    perubahan nyata melalui teknologi dan semangat kolaborasi.
                </p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[var(--color1)] text-white pt-12 pb-6 px-4">
    <div class="container mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
        {{-- Kolom Produk --}}
        <div>
            <h4 class="font-bold text-lg mb-4 relative pb-2">
                Produk
                <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-white"></span>
            </h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Acara</a></li>
                <li><a href="#" class="hover:underline">Organisasi</a></li>
                <li><a href="#" class="hover:underline">Leaderboard</a></li>
                <li><a href="#" class="hover:underline">Dashboard</a></li>
                <li><a href="#" class="hover:underline">Profil</a></li>
            </ul>
        </div>

        {{-- Kolom Informasi --}}
        <div>
            <h4 class="font-bold text-lg mb-4 relative pb-2">
                Informasi
                <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-white"></span>
            </h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Sejarah</a></li>
                <li><a href="#" class="hover:underline">Manfaat</a></li>
                <li><a href="#" class="hover:underline">Akun</a></li>
                <li><a href="#" class="hover:underline">Keamanan</a></li>
            </ul>
        </div>

        {{-- Kolom Perusahaan --}}
        <div>
            <h4 class="font-bold text-lg mb-4 relative pb-2">
                Perusahaan
                <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-white"></span>
            </h4>
            <ul class="space-y-2 text-sm">
                <li><a href="#" class="hover:underline">Tentang Kami</a></li>
                <li><a href="#" class="hover:underline">Karir</a></li>
                <li><a href="#" class="hover:underline">FAQs</a></li>
                <li><a href="#" class="hover:underline">Pengembang</a></li>
                <li><a href="#" class="hover:underline">Hubungi Kami</a></li>
            </ul>
        </div>

        {{-- Kolom Hubungi Kami (Form) --}}
        <div>
            <h4 class="font-bold text-lg mb-4 relative pb-2">
                Hubungi Kami
                <span class="absolute bottom-0 left-0 w-8 h-0.5 bg-white"></span>
            </h4>
            <form class="space-y-3">
                <input type="text" placeholder="Nama" class="w-full p-2 rounded bg-white text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <input type="email" placeholder="Email" class="w-full p-2 rounded bg-white text-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                <button type="submit" class="bg-white text-blue-700 px-4 py-2 rounded font-semibold text-sm hover:bg-gray-200 transition duration-300">Kirim</button>
            </form>
        </div>

        {{-- Kolom PEDULIKITA & Ikuti Kami --}}
        <div class="md:col-span-2 lg:col-span-1 md:text-right lg:text-left"> {{-- Menyesuaikan tata letak untuk tablet dan desktop --}}
            <a href="{{ route('guest.index') }}"><img src="{{ asset('assets/logo/peduli2.png') }}" class="" alt="Peduli Kita Logo" /></a>
            <h4 class="font-bold text-lg mb-4 relative pb-2">
                Ikuti Kami
                <span class="absolute bottom-0 right-0 w-8 h-0.5 bg-white md:left-auto md:right-0 lg:left-0"></span> {{-- Menyesuaikan posisi garis bawah --}}
            </h4>
            <div class="flex space-x-4 mt-4 md:justify-end lg:justify-start"> {{-- Menggunakan flex dan justify-end/start --}}
                <a href="#" aria-label="Facebook" class="text-white hover:text-gray-300 transition duration-300">
                    <i class="fab fa-facebook-f fa-lg"></i>
                </a>
                <a href="#" aria-label="Twitter" class="text-white hover:text-gray-300 transition duration-300">
                    <i class="fab fa-twitter fa-lg"></i>
                </a>
                <a href="#" aria-label="Telegram" class="text-white hover:text-gray-300 transition duration-300">
                    <i class="fab fa-telegram-plane fa-lg"></i>
                </a>
                <a href="#" aria-label="Instagram" class="text-white hover:text-gray-300 transition duration-300">
                    <i class="fab fa-instagram fa-lg"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Bagian Bawah Footer (Copyright dll.) --}}
    <div class="container mx-auto text-center text-xs mt-10 border-t border-blue-600 pt-6"> {{-- Menambahkan border-top --}}
        <ul class="flex flex-wrap justify-center space-x-4 sm:space-x-8"> {{-- Menggunakan flex-wrap untuk responsif --}}
            <li><a href="#" class="hover:underline">Privacy Policy</a></li>
            <li><a href="#" class="hover:underline">Terms of Use</a></li>
            <li><a href="#" class="hover:underline">Bug and Reports</a></li>
            <li><a href="#" class="hover:underline">Legal</a></li>
            <li><a href="#" class="hover:underline">Copyright</a></li>
        </ul>
    </div>
</footer>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40NZjgTlkISLRS5XUaPzC/TzU4b6t1z+oM6lK+f6Q+Q9vJ9zD9u+d80P1S3+tXGf5W7+b+c+A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}


@endsection
