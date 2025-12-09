@extends('layouts.volunteer')

@section('title', 'Berita Acara')

@section('content')
    <div class="container mx-auto px-6 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            @php
                // Ambil 4 berita utama (2 besar + 2 kecil di bawah)
                $featuredNews = $news->take(4);
                // Sisanya untuk sidebar
                $sidebarNews = $news->skip(4);
            @endphp

            {{-- Kolom utama --}}
            <div class="lg:col-span-2">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Acara Terkini</h2>

                {{-- 4 Berita Utama dengan Ukuran Sama --}}
                <div class="grid sm:grid-cols-2 gap-6">
                    @foreach ($featuredNews as $item)
                        <a href="{{ route('volunteer.news.show', $item->id) }}" 
                           class="block bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition group">
                            @php
                                $firstImage = '';
                                if (!empty($item->image_url)) {
                                    $paths = explode(';', $item->image_url);
                                    $firstImage = trim($paths[0]);
                                }
                            @endphp

                            <div class="relative h-64">
                                @if ($firstImage)
                                    <img src="{{ Storage::disk('s3')->url($firstImage) }}" 
                                         alt="{{ $item->news_title }}"
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-500">
                                        No Image
                                    </div>
                                @endif
                                
                                {{-- Overlay gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                                
                                {{-- Title overlay --}}
                                <div class="absolute bottom-0 left-0 right-0 p-5 text-white">
                                    <h3 class="font-bold text-lg line-clamp-2 group-hover:text-blue-400 transition">
                                        {{ $item->news_title }}
                                    </h3>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-900">Acara lainnya</h3>
                    {{-- <a href="#" class="text-sm text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-md transition">
                        View all
                    </a> --}}
                </div>
                
                <div class="space-y-4">
                    @foreach ($sidebarNews as $item)
                        <a href="{{ route('volunteer.news.show', $item->id) }}"
                            class="flex gap-4 bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition group">
                            @php
                                $firstImage = '';
                                if (!empty($item->image_url)) {
                                    $paths = explode(';', $item->image_url);
                                    $firstImage = trim($paths[0]);
                                }
                            @endphp

                            @if ($firstImage)
                                <img src="{{ Storage::disk('s3')->url($firstImage) }}"
                                    class="w-20 h-20 object-cover rounded-lg flex-shrink-0">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center text-xs text-gray-500 flex-shrink-0">
                                    No Img
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-semibold text-gray-800 line-clamp-2 group-hover:text-[var(--color1)] transition mb-2">
                                    {{ $item->news_title }}
                                </h4>
                                <p class="text-xs text-gray-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
@endsection