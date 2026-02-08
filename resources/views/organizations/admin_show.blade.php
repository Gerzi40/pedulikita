@extends('layouts.admin')

@section('title', 'Detail Organisasi')

@section('content')

    <div class="container mx-auto px-4 py-8">
        {{-- BACK BUTTON --}}
        <a href="{{ route('admin.organizations.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2 mb-6
                bg-white text-[var(--color1)] border border-[var(--color1)]
                rounded-md shadow hover:bg-[var(--color1)] hover:text-white
                transition duration-300 w-fit">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>

            <span class="text-sm font-medium">
                Kembali
            </span>
        </a>

        {{-- Gunakan x-data untuk menginisialisasi state kedua modal --}}
        <div x-data="{ showConfirmModal: false, showRejectModal: false, approveConfirmModal: false }">

            <div class="flex items-center space-x-6 mb-8 flex-col md:flex-row">
                {{-- Bagian Logo dan Nama Organisasi --}}
                <div class="flex-shrink-0">
                    <img src="{{ Storage::disk('s3')->url($organization->user->profile_picture_url) }}"
                        alt="Logo Organisasi" class="w-48 h-48 object-cover rounded-full border-2 border-gray-200">
                </div>
                <div class="flex flex-col items-center md:items-start">
                    <h1 class="text-3xl font-bold text-gray-800">{{ $organization->user->name }}</h1>
                    <div class="flex gap-2 mt-5">
                        @if ($organization->state === 'pending')
                            <form x-ref="approveForm"
                                action="{{ route('admin.organizations.approve', ['id' => $organization->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <button type="button" @click="approveConfirmModal = true"
                                    class="px-6 py-2 bg-[var(--color1)] text-white font-semibold rounded-md shadow border border-transparent hover:bg-white hover:text-[var(--color1)] hover:border-[var(--color1)] transition duration-300 cursor-pointer">
                                    Setuju
                                </button>
                            </form>

                            {{-- Form untuk reject (disembunyikan, hanya untuk submit) --}}
                            <form x-ref="rejectForm"
                                action="{{ route('admin.organizations.reject', ['id' => $organization->id]) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="reason" x-ref="rejectReason">
                            </form>

                            {{-- Tombol Tolak yang memicu modal --}}
                            <button type="button" @click="showRejectModal = true"
                                class="px-6 py-2 bg-[#960018] text-white font-semibold rounded-md shadow border border-transparent hover:bg-white hover:text-[#960018] hover:border-[#960018] transition duration-300 cursor-pointer">
                                Tolak
                            </button>
                        @endif

                        {{-- Form untuk delete --}}
                        {{-- @if ($organization->state != 'pending')
                            <form x-ref="deleteForm"
                                action="{{ route('admin.organizations.destroy', ['id' => $organization->id]) }}" method="post">
                                @csrf
                                @method('delete')

                                <button type="button" @click="showConfirmModal = true"
                                    class="bg-[#960018] text-white font-semibold py-2 px-6 rounded-md shadow border border-transparent hover:bg-white hover:text-[#960018] hover:border-[#960018] transition duration-300 cursor-pointer">
                                    Hapus
                                </button>
                            </form>
                        @endif --}}
                    </div>
                </div>
            </div>

            {{-- Modal Konfirmasi Delete --}}
            {{-- <div x-show="showConfirmModal" style="display: none;" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

                <div @click.away="showConfirmModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Penghapusan</h3>
                    <p class="text-gray-600 mb-6">Apakah Anda yakin ingin menghapus organisasi ini? Tindakan ini tidak dapat
                        dibatalkan.</p>
                    <div class="flex justify-end gap-4">
                        <button type="button" @click="showConfirmModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300 cursor-pointer">
                            Batal
                        </button>
                        <button type="button" @click="$refs.deleteForm.submit()"
                            class="px-4 py-2 bg-[#960018] text-white rounded-lg hover:bg-[#7E191B] transition duration-300 cursor-pointer">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div> --}}

            {{-- Modal Konfirmasi Reject --}}
            <div x-show="showRejectModal" style="display: none;" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

                <div @click.away="showRejectModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Penolakan</h3>
                    <p class="text-gray-600 mb-4">Berikan alasan penolakan organisasi ini:</p>

                    {{-- Input untuk alasan penolakan --}}
                    <textarea x-model="rejectReason" rows="4"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#960018] focus:border-transparent mb-4"
                        placeholder="Masukkan alasan penolakan..."></textarea>

                    <div class="flex justify-end gap-4">
                        <button type="button" @click="showRejectModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300 cursor-pointer">
                            Batal
                        </button>
                        <button type="button" @click="$refs.rejectReason.value = rejectReason; $refs.rejectForm.submit()"
                            class="px-4 py-2 bg-[#960018] text-white rounded-lg hover:bg-[#7E191B] transition duration-300 cursor-pointer">
                            Ya, Tolak
                        </button>
                    </div>
                </div>
            </div>

            {{-- Modal Konfirmasi Approve --}}
            <div x-show="approveConfirmModal" style="display: none;" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

                <div @click.away="approveConfirmModal = false"
                    class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md mx-4">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Konfirmasi Persetujuan</h3>

                    <p class="text-gray-600 mb-6">
                        Apakah Anda yakin ingin memberi persetujuan pada organisasi ini?
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="flex justify-end gap-4">

                        <button type="button" @click="approveConfirmModal = false"
                            class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition duration-300 cursor-pointer">
                            Batal
                        </button>

                        <button type="button" @click="$refs.approveForm.submit()"
                            class="px-4 py-2 bg-[var(--color1)] text-white rounded-lg hover:bg-[var(--hovercolor1)] transition duration-300 cursor-pointer">
                            Ya, Setuju
                        </button>

                    </div>
                </div>
            </div>

        </div> {{-- Penutup div x-data --}}

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
                        {{ $organization->events->where('date', '<', now())->count() }} Acara terlaksana</p>
                    <p class="flex items-center"><i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                        {{ count($organization->events) ?? 2 }} Acara tersedia</p>
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

        {{-- Daftar Acara --}}
        <div class="mt-10">
            <section class="py-10">
                <div class="container mx-auto px-4">
                    <h2 class="text-xl font-bold text-[var(--color1)] mb-6">Acara dari {{ $organization->user->name }}
                    </h2>
                    @forelse ($organization->events->where('state', '!=', 'draft') as $event)
                        @if ($loop->first)
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @endif

                        {{-- CARD --}}
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <div class="relative w-full h-40">
                                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="Acara"
                                    class="w-full h-full object-cover" />

                                {{-- Badge Status --}}
                                @if ($event->state == 'approved')
                                    <div
                                        class="absolute top-2 right-2 bg-green-600 text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        Disetujui
                                    </div>
                                @elseif ($event->state == 'pending')
                                    <div
                                        class="absolute top-2 right-2 bg-[var(--color1)] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        Diproses
                                    </div>
                                @elseif ($event->state == 'finished')
                                    <div
                                        class="absolute top-2 right-2 bg-[var(--color1)] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        Selesai
                                    </div>
                                @elseif ($event->state == 'reviewed')
                                    <div
                                        class="absolute top-2 right-2 bg-[var(--color1)] text-white text-xs font-semibold px-3 py-1 rounded-full">
                                        Diulas
                                    </div>
                                @endif
                            </div>

                            <div class="p-4">
                                <h3 class="font-semibold text-base text-[var(--color2)] mb-2">
                                    {{ $event->name }}
                                </h3>

                                {{-- Kategori --}}
                                <div class="flex items-center text-xs mb-1">
                                    <img src="{{ asset('assets/icons/category.png') }}" class="mr-2 h-3 w-3">
                                    <p>{{ $event->event_category->name }}</p>
                                </div>

                                {{-- Lokasi --}}
                                <div class="flex items-center text-xs mb-1">
                                    <img src="{{ asset('assets/icons/Vector.png') }}" class="mr-2 h-3 w-3">
                                    <p>{{ $event->city->name }}, {{ $event->city->province->name }}</p>
                                </div>

                                {{-- Tanggal --}}
                                <div class="flex items-center text-xs mb-4">
                                    <img src="{{ asset('assets/icons/Clock.png') }}" class="mr-2 h-3 w-3">
                                    <p>
                                        {{ \Carbon\Carbon::parse($event->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}
                                        • {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} WIB
                                    </p>
                                </div>

                                <div class="flex justify-end">
                                    <a href="{{ route('admin.events.show', $event->id) }}"
                                        class="px-4 py-2 bg-[var(--color1)] text-white text-sm rounded-md hover:bg-[var(--hovercolor1)]">
                                        Lihat
                                    </a>
                                </div>
                            </div>
                        </div>

                        @if ($loop->last)
                </div>
                @endif

            @empty
                {{-- EMPTY STATE --}}
                <div class="flex flex-col items-center justify-center py-16 bg-white rounded-xl shadow-sm">
                    <img src="{{ asset('assets/icons/calendar.png') }}" class="w-20 h-20 opacity-50 mb-4"
                        alt="Kosong">

                    <h3 class="text-lg font-semibold text-[var(--color2)] mb-1">
                        Belum Ada Acara
                    </h3>

                    <p class="text-sm text-gray-400 text-center max-w-sm">
                        Organisasi ini belum membuat acara apapun.
                    </p>
                </div>
                @endforelse
        </div>
        </section>
    </div>
    </div>

@endsection

@if (session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
        x-transition:enter-start="-translate-y-3 opacity-0" x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave-start="translate-y-0 opacity-100" x-transition:leave-end="-translate-y-3 opacity-0"
        class="fixed top-20 right-6 z-50">
        <div
            class="flex items-center gap-3 bg-white border border-green-500 
                   text-green-600 px-5 py-3 rounded-md shadow-lg">
            {{-- CHECK ICON --}}
            <svg class="text-green-500" style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>

            <span class="font-medium text-sm">
                {{ session('success') }}
            </span>
        </div>
    </div>
@endif
