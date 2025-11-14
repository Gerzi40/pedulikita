@extends('layouts.volunteer')

@section('title', 'Detail Acara')

@section('content')
    <div class="container mx-auto px-6 py-10 max-w-5xl">

        {{-- Image Carousel --}}
        @php
            $images = [];
            if (!empty($news->image_url)) {
                $paths = explode(';', $news->image_url);
                $images = array_map('trim', $paths);
            }
        @endphp

        @if (count($images) > 0)
            <div class="relative mb-8 rounded-lg overflow-hidden shadow-lg" id="carouselContainer">
                {{-- Carousel Images --}}
                <div class="relative h-96 bg-gray-900">
                    @foreach ($images as $index => $image)
                        <div class="carousel-item absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}"
                            data-index="{{ $index }}">
                            <img src="{{ Storage::disk('s3')->url($image) }}" alt="{{ $news->news_title }}"
                                class="w-full h-full object-cover">
                        </div>
                    @endforeach

                    {{-- Navigation Arrows (only if multiple images) --}}
                    @if (count($images) > 1)
                        <button onclick="prevSlide()"
                            class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button onclick="nextSlide()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-3 rounded-full transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>

                        {{-- Dots Indicator --}}
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                            @foreach ($images as $index => $image)
                                <button onclick="goToSlide({{ $index }})"
                                    class="carousel-dot w-2.5 h-2.5 rounded-full transition {{ $index === 0 ? 'bg-white' : 'bg-white/50' }}"
                                    data-index="{{ $index }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Content --}}
        <article class="bg-white rounded-lg shadow-md p-8">

            {{-- Meta Info --}}
            <div class="flex items-center gap-4 text-sm text-gray-500 mb-6 pb-6 border-b">
                <span>{{ $news->created_at->format('d M Y') }}</span>
                <span>•</span>
                <span>{{ $news->created_at->format('H:i') }} WIB</span>
                @php
                    $authorName = optional(optional(optional($news->event)->organization)->user)->name;
                @endphp
                @if ($authorName)
                    <span>•</span>
                    <span>Ditulis oleh: {{ $authorName }}</span>
                @endif
            </div>

            {{-- Title --}}
            <h1 class="text-4xl font-bold text-gray-900 mb-6 leading-tight">
                {{ $news->news_title }}
            </h1>

            {{-- Description / Content --}}
            <div class="prose prose-lg max-w-none">
                <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                    {{ $news->desc }}
                </p>

                {{-- @if ($news->content)
                    <div class="mt-6 text-gray-700 leading-relaxed">
                        {!! nl2br(e($news->content)) !!}
                    </div>
                @endif --}}
            </div>

            {{-- Tags (if exists) --}}
            {{-- @if ($news->tags)
                <div class="mt-8 pt-6 border-t">
                    <div class="flex flex-wrap gap-2">
                        @foreach (explode(',', $news->tags) as $tag)
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 text-sm rounded-full">
                                {{ trim($tag) }}
                            </span>
                        @endforeach
                    </div>
                </div>
            @endif --}}

            {{-- Back Button --}}
            <div class="mt-8 pt-6 border-t">
                <a href="{{ route('volunteer.news.index') }}"
                    class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Daftar Berita
                </a>
            </div>
        </article>

    </div>

    @if (count($images) > 1)
        <script>
            let currentSlide = 0;
            const totalSlides = {{ count($images) }};
            let autoPlayInterval;

            function showSlide(index) {
                // Hide all slides
                document.querySelectorAll('.carousel-item').forEach(item => {
                    item.classList.remove('opacity-100');
                    item.classList.add('opacity-0');
                });

                // Update dots
                document.querySelectorAll('.carousel-dot').forEach(dot => {
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-white/50');
                });

                // Show current slide
                const currentItem = document.querySelector(`.carousel-item[data-index="${index}"]`);
                const currentDot = document.querySelector(`.carousel-dot[data-index="${index}"]`);

                if (currentItem) {
                    currentItem.classList.remove('opacity-0');
                    currentItem.classList.add('opacity-100');
                }

                if (currentDot) {
                    currentDot.classList.remove('bg-white/50');
                    currentDot.classList.add('bg-white');
                }

                currentSlide = index;
            }

            function nextSlide() {
                const next = (currentSlide + 1) % totalSlides;
                showSlide(next);
                resetAutoPlay();
            }

            function prevSlide() {
                const prev = (currentSlide - 1 + totalSlides) % totalSlides;
                showSlide(prev);
                resetAutoPlay();
            }

            function goToSlide(index) {
                showSlide(index);
                resetAutoPlay();
            }

            function startAutoPlay() {
                autoPlayInterval = setInterval(() => {
                    nextSlide();
                }, 5000); // 5 detik
            }

            function resetAutoPlay() {
                clearInterval(autoPlayInterval);
                startAutoPlay();
            }

            // Start autoplay when page loads
            document.addEventListener('DOMContentLoaded', function() {
                startAutoPlay();
            });

            // Pause on hover
            const carouselContainer = document.getElementById('carouselContainer');
            if (carouselContainer) {
                carouselContainer.addEventListener('mouseenter', () => {
                    clearInterval(autoPlayInterval);
                });

                carouselContainer.addEventListener('mouseleave', () => {
                    startAutoPlay();
                });
            }
        </script>
    @endif
@endsection
