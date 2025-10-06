{{-- resources/views/components/leaderboard.blade.php --}}
<div class="max-w-4xl mx-auto p-6 bg-white">
    {{-- Header --}}
    <h1 class="text-2xl font-bold text-center text-gray-800 mb-8">LEADERBOARD</h1>

    {{-- Top 3 Podium --}}
    <div class="flex justify-center items-end mb-8 space-x-4 gap-10">
        {{-- Second Place --}}
        @if (isset($volunteers[1]))
            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[1]->user->profile_picture_url) }}"
                        alt="{{ $volunteers[1]->user->name }}" class="w-16 h-16 rounded-full border-4 border-gray-300">
                    <div class="absolute -top-2 -right-2">
                        <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 16L3 5h5.5l1.5 5 1.5-5H17l-2 11H5z" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-sm text-gray-800">{{ $volunteers[1]->user->name }}</h3>
                <p class="text-xs text-gray-500">{{ number_format($volunteers[1]->point_total ?? 0, 0) }} poin</p>
            </div>
        @endif

        {{-- First Place --}}
        @if (isset($volunteers[0]))
            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[0]->user->profile_picture_url) }}"
                        alt="{{ $volunteers[0]->user->name }}"
                        class="w-20 h-20 rounded-full border-4 border-yellow-400">
                    <div class="absolute -top-3 left-1/2 transform -translate-x-1/2">
                        <svg class="w-10 h-10 text-yellow-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 16L3 5h5.5l1.5 5 1.5-5H17l-2 11H5z" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-base text-gray-800">{{ $volunteers[0]->user->name }}</h3>
                <p class="text-sm text-gray-500">{{ number_format($volunteers[0]->point_total ?? 0, 0) }} poin</p>
            </div>
        @endif

        {{-- Third Place --}}
        @if (isset($volunteers[2]))
            <div class="flex flex-col items-center">
                <div class="relative mb-2">
                    <img src="{{ Storage::disk('s3')->url($volunteers[2]->user->profile_picture_url) }}"
                        alt="{{ $volunteers[2]->user->name }}" class="w-16 h-16 rounded-full border-4 border-gray-300">
                    <div class="absolute -top-2 -right-2">
                        <svg class="w-8 h-8 text-amber-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M5 16L3 5h5.5l1.5 5 1.5-5H17l-2 11H5z" />
                        </svg>
                    </div>
                </div>
                <h3 class="font-semibold text-sm text-gray-800">{{ $volunteers[2]->user->name }}</h3>
                <p class="text-xs text-gray-500">{{ number_format($volunteers[2]->point_total ?? 0, 0) }} poin</p>
            </div>
        @endif
    </div>

    {{-- Full Leaderboard List --}}
    <div class="bg-gray-50 rounded-lg p-4">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Peringkat selanjutnya</h2>
            <a href="#" class="text-sm text-[var(--color1)] hover:text-[var(--hovercolor1)] flex items-center">
                Lihat Semua
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>

        <div class="space-y-3">
            @foreach ($volunteers as $index => $volunteer)
                <div
                    class="flex items-center justify-between p-3 bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center space-x-3">
                        {{-- Rank Badge --}}
                        <div class="flex-shrink-0">
                            @if ($index < 3)
                                <div
                                    class="w-8 h-8 rounded-full flex items-center justify-center text-white text-sm font-bold
                                @if ($index == 0) bg-yellow-400
                                @elseif($index == 1) bg-gray-400  
                                @else bg-amber-600 @endif">
                                    {{ $index + 1 }}
                                </div>
                            @else
                                <div
                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-sm font-semibold">
                                    {{ $index + 1 }}
                                </div>
                            @endif
                        </div>

                        {{-- User Info --}}
                        <div class="flex items-center space-x-3">
                            <img src="{{ Storage::disk('s3')->url($volunteer->user->profile_picture_url) }}"
                                alt="{{ $volunteer->user->name }}" class="w-12 h-12 rounded-full">
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $volunteer->user->name }}</h3>
                                <p class="text-sm text-gray-500">Relawan</p>
                            </div>
                        </div>
                    </div>

                    {{-- point_total --}}
                    <div class="text-right">
                        <p class="text-xl font-bold text-gray-800">{{ number_format($volunteer->point_total ?? 0, 0) }}</p>
                        <p class="text-sm text-gray-500">poin</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
 