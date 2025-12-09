@extends('layouts.organization')

@section('title', 'Berita')

@section('content')
    <div class="max-w-full mx-5 mt-8">
        <!-- Header Section -->
        <div class="rounded-2xl shadow-lg p-8 mb-6" style="background: linear-gradient(to right, #2170B8, #1A5B9C);">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-white mb-2">📰 Buat Berita Acara</h1>
                    <p class="text-blue-100">Pilih acara yang telah selesai untuk membuat berita</p>
                </div>
                <div class="bg-white/20 backdrop-blur-sm rounded-xl px-6 py-4 flex flex-col items-center">
                    <div class="text-white/80 text-sm">Total Acara</div>
                    <div class="text-3xl font-bold text-white">{{ count($events) }}</div>
                </div>
            </div>
        </div>

        <!-- Table Card -->
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-50 to-gray-100 border-b-2 border-gray-200">
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Acara
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Deskripsi
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Lokasi
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Poin
                            </th>
                            <th class="py-4 px-6 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="py-4 px-6 text-center text-xs font-semibold text-gray-700 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($events as $event)
                            <tr class="transition-colors duration-150" style="--hover-bg: rgba(33, 112, 184, 0.05);" onmouseover="this.style.backgroundColor='var(--hover-bg)'" onmouseout="this.style.backgroundColor=''">
                                {{-- NAME --}}
                                <td class="py-4 px-6">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center" style="background: linear-gradient(to bottom right, #2170B8, #1A5B9C);">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-semibold text-gray-900 truncate w-44" title="{{ $event->name }}">
                                                {{ $event->name }}
                                            </div>
                                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                {{ \Carbon\Carbon::parse($event->date)->format('d M Y') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                {{-- DESCRIPTION --}}
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-600 w-56 leading-relaxed">
                                        {{ Str::limit($event->description ?? 'Tidak ada deskripsi', 60) }}
                                    </div>
                                </td>

                                {{-- LOKASI --}}
                                <td class="py-4 px-6">
                                    <div class="flex items-start space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div>
                                            <div class="text-sm text-gray-900 font-medium">{{ $event->location }}</div>
                                            <div class="text-xs text-gray-500">{{ $event->city->name ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- POIN --}}
                                <td class="py-4 px-6">
                                    <div class="inline-flex items-center space-x-1 bg-gradient-to-r from-red-50 to-orange-50 px-3 py-2 rounded-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                        </svg>
                                        <span class="font-bold text-red-600">{{ $event->point ?? 0 }}</span>
                                        <span class="text-xs text-gray-500 font-medium">pts</span>
                                    </div>
                                </td>

                                {{-- STATUS --}}
                                <td class="py-4 px-6">
                                    @php
                                        $status = $event->state === 'reviewed' ? 'reviewed' : 'finished';
                                        
                                        $statusConfig = match ($status) {
                                            'reviewed' => [
                                                'bg' => 'rgba(33, 112, 184, 0.1)',
                                                'text' => '#2170B8',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                                'label' => 'Direview'
                                            ],
                                            'finished' => [
                                                'bg' => 'rgba(34, 197, 94, 0.1)',
                                                'text' => '#16a34a',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />',
                                                'label' => 'Selesai'
                                            ],
                                            default => [
                                                'bg' => 'rgba(107, 114, 128, 0.1)',
                                                'text' => '#6b7280',
                                                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />',
                                                'label' => ucfirst($status)
                                            ],
                                        };
                                    @endphp

                                    <span class="inline-flex items-center space-x-1.5 px-3 py-1.5 rounded-full text-xs font-semibold" style="background-color: {{ $statusConfig['bg'] }}; color: {{ $statusConfig['text'] }};">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            {!! $statusConfig['icon'] !!}
                                        </svg>
                                        <span>{{ $statusConfig['label'] }}</span>
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td class="py-4 px-6 text-center">
                                    <a href="{{ route('organization.news.create', ['event_id' => $event->id]) }}"
                                        class="inline-flex items-center justify-center space-x-2 text-white px-4 py-2 rounded-lg transition-all duration-200 shadow-md hover:shadow-lg transform group"
                                        style="background-color: #2170B8;"
                                        onmouseover="this.style.backgroundColor='#1A5B9C'; this.style.transform='translateY(-2px)';"
                                        onmouseout="this.style.backgroundColor='#2170B8'; this.style.transform='translateY(0)';"
                                        title="Buat Berita">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                        {{-- <span class="text-sm font-medium"></span> --}}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-16 text-center">
                                    <div class="flex flex-col items-center justify-center space-y-4">
                                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-gray-700 mb-1">Belum Ada Acara</h3>
                                            <p class="text-sm text-gray-500">Acara yang telah selesai akan muncul di sini</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Info Footer -->
        <div class="mt-6 rounded-xl p-4" style="background-color: rgba(33, 112, 184, 0.05); border: 1px solid rgba(33, 112, 184, 0.2);">
            <div class="flex items-start space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0 mt-0.5" style="color: #2170B8;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <h4 class="font-semibold text-sm mb-1" style="color: #1A5B9C;">Informasi</h4>
                    <p class="text-sm" style="color: #2170B8;">Hanya acara dengan status <span class="font-semibold">Selesai</span> atau <span class="font-semibold">Direview</span> yang dapat dibuatkan berita.</p>
                </div>
            </div>
        </div>
    </div>
@endsection


@if (session('success'))
    <div 
        x-data="{ show: true }"
        x-show="show"
        x-init="setTimeout(() => show = false, 3500)"

        x-transition:enter-start="-translate-y-3 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="-translate-y-3 opacity-0"
        
        class="fixed top-20 right-6 z-50"
    >
        <div 
            class="flex items-center gap-3 bg-white border border-green-500 
                   text-green-600 px-5 py-3 rounded-md shadow-lg"
        >
            {{-- CHECK ICON --}}
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
                 viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M5 13l4 4L19 7"/>
            </svg>

            <span class="font-medium text-sm">
                {{ session('success') }}
            </span>
        </div>
    </div>
@endif