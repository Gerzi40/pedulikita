@extends('layouts.organization')

@section('title', 'Relawan Acara')

@section('content')

    <section class="max-w-6xl mx-auto mt-10 px-4">
        <div class="grid md:grid-cols-2 gap-10 items-center">
            {{-- Gambar --}}
            <div>
                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="gambar event"
                    class="rounded-xl shadow-md w-full object-cover">
            </div>

            {{-- Informasi --}}
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">Informasi</h3>
                    <div class="space-y-3 text-sm text-gray-600">
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/people.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->volunteers->count() }} Relawan berpartisipasi</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/slot.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->available_slot - $event->volunteers->count() }} Slot tersedia</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/point.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->point }} pts</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/date.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->date)->translatedFormat('d, F Y') }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/icons/Clock.png') }}" class="w-5 h-5" alt="">
                            <span>{{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }} –
                                {{ \Carbon\Carbon::parse($event->end_time)->format('H:i') }} WIB</span>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center gap-4">
                        <img src="{{ Storage::disk('s3')->url($event->organization->user->profile_picture_url) }}"
                            class="w-12 h-12 rounded-full object-cover" alt="">
                        <div class="flex flex-col">
                            <span class="text-sm text-gray-600">Dibuat oleh</span>
                            <span class="text-lg font-semibold">{{ $event->organization->user->name }}</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 py-6">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-5">{{ $event->name }}</h1>
        <h1 class="text-2xl font-semibold mb-6 ml-3">Partisipasi Oleh</h1>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-8">
            @foreach ($event->volunteers as $vol)
                <div class="relative flex flex-col items-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden shadow-md z-10 bg-white">
                        <img src="{{ Storage::disk('s3')->url($vol->user->profile_picture_url) }}" alt="Profile Picture"
                            class="w-full h-full object-cover">
                    </div>

                    <div class="bg-white shadow-xl rounded-2xl mt-[-40px] pt-12 pb-6 px-4 text-center w-60">
                        <h2 class="font-bold text-lg">{{ strtoupper($vol->user->name) }}</h2>
                        <p class="text-gray-500 text-sm">since {{ $vol->created_at->format('m/y') }}</p>
                        <div class="flex justify-center items-center">
                            @if (isset($vol->pivot->rating))
                                {{-- {{ $vol->pivot->rating }} --}}
                                <div class="flex gap-1 items-center mt-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= ($vol->pivot->rating ?? 0))
                                            <!-- Bintang terisi -->
                                            <svg class="w-7 h-7 fill-yellow-400 stroke-yellow-500" viewBox="0 0 24 24"
                                                stroke-width="1">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        @else
                                            <!-- Bintang kosong -->
                                            <svg class="w-7 h-7 fill-gray-300 stroke-gray-400" viewBox="0 0 24 24"
                                                stroke-width="1">
                                                <path
                                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            @else
                                <button type="button"
                                    class="open-modal-btn text-[var(--color1)] border-1 mt-2 border-[var(--color1)] font-semibold rounded-md
                                    py-1.5 px-4 text-sm hover:bg-[var(--hovercolor1)] hover:text-white transition duration-200"
                                    data-user="{{ $vol->user->name }}" data-id="{{ $vol->id }}"
                                    data-is_present="{{ $vol->pivot->is_present }}"
                                    data-rating="{{ $vol->pivot->rating }}">
                                    Nilai
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Modal -->
    <div id="ratingModal" class="fixed inset-0 backdrop-blur-xs bg-white/30 flex items-center justify-center hidden z-50">
        <div class="bg-white p-6 rounded-lg w-[90%] max-w-md">
            <h2 class="text-xl font-bold mb-4">Nilai Relawan: <span id="modalUserName"></span></h2>
            <form id="modalForm" method="POST">
                @csrf
                @method('PUT')

                <input type="hidden" name="volunteer_id" id="modalVolunteerId" />

                <label class="block mb-2">Is Present:</label>

                <!-- Hidden input -->
                <input type="hidden" name="is_present" id="modalIsPresent" />

                <!-- Pilihan tombol -->
                <div class="flex gap-4 mb-4">
                    <button type="button"
                        class="presence-btn px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-green-100"
                        data-value="1">
                        Yes
                    </button>
                    <button type="button"
                        class="presence-btn px-4 py-2 rounded border border-gray-300 text-gray-700 hover:bg-red-100"
                        data-value="0">
                        No
                    </button>
                </div>

                <label class="block mb-2" id="rating">Rating:</label>

                <!-- Star Rating Component -->
                <div class="mb-4" id="rateSection">
                    <div class="flex gap-1 justify-center mb-2" id="modalStarRating">
                        <svg class="star w-8 h-8 cursor-pointer transition-all duration-200 hover:scale-110 fill-gray-300 stroke-gray-400"
                            data-rating="1" viewBox="0 0 24 24" stroke-width="1">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <svg class="star w-8 h-8 cursor-pointer transition-all duration-200 hover:scale-110 fill-gray-300 stroke-gray-400"
                            data-rating="2" viewBox="0 0 24 24" stroke-width="1">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <svg class="star w-8 h-8 cursor-pointer transition-all duration-200 hover:scale-110 fill-gray-300 stroke-gray-400"
                            data-rating="3" viewBox="0 0 24 24" stroke-width="1">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <svg class="star w-8 h-8 cursor-pointer transition-all duration-200 hover:scale-110 fill-gray-300 stroke-gray-400"
                            data-rating="4" viewBox="0 0 24 24" stroke-width="1">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                        <svg class="star w-8 h-8 cursor-pointer transition-all duration-200 hover:scale-110 fill-gray-300 stroke-gray-400"
                            data-rating="5" viewBox="0 0 24 24" stroke-width="1">
                            <path
                                d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                        </svg>
                    </div>
                    <div class="text-center text-sm text-gray-600">
                        <span id="modalRatingText">Pilih rating (1-5)</span>
                    </div>
                </div>

                <!-- Hidden input untuk rating -->
                <input type="hidden" name="rating" id="modalRating" value="0" />

                <div class="flex justify-end gap-2">
                    <button type="button" id="closeModal"
                        class="px-4 py-2 bg-white border text-[var(--color1)] border-[var(--color1)] rounded hover:bg-[var(--hovercolor1)] hover:text-white transition duration-200">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-[var(--color1)] border border-[var(--color1)] text-white rounded hover:bg-white hover:text-[var(--hovercolor1)] transition duration-200">Submit</button>
                </div>
            </form>
        </div>
    </div>

    {{-- @foreach ($event->volunteers as $volunteer)
        <li>
            <p>Name: {{ $volunteer->user->name }}</p>
            <p>Is Present: {{ $volunteer->pivot->is_present }}</p>
            <p>Rating: {{ $volunteer->pivot->rating }}</p>
            <form
                action="{{ route('organization.participation.update', ['event_id' => $event->id, 'volunteer_id' => $volunteer->id]) }}"
                method="post">
                @csrf
                @method('put')
                <input type="text" name="is_present" placeholder="Is Present: 1/0" />
                <input type="text" name="rating" placeholder="Rating: 0-5" />
                <button type="submit">Submit</button>
            </form>
        </li>
    @endforeach --}}

    @if (session('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-300"
            x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
            class="fixed bottom-4 right-4 z-50">
            <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg w-80">
                <div class="flex justify-between items-center">
                    <h3 class="font-bold text-lg">Error</h3>
                    <button @click="show = false" class="text-white font-bold cursor-pointer">×</button>
                </div>
                <p class="mt-1 text-sm">
                    {{ session('error') }}
                </p>
            </div>
        </div>
    @endif

    <script>
        // Function untuk setup star rating
        function setupStarRating() {
            const stars = document.querySelectorAll('#modalStarRating .star');
            const ratingInput = document.getElementById('modalRating');
            const ratingText = document.getElementById('modalRatingText');

            let currentRating = 0;

            // Fungsi untuk update tampilan stars
            function updateStars(rating, isHover = false) {
                stars.forEach((star) => {
                    const starRating = parseInt(star.dataset.rating);

                    // Reset classes
                    star.classList.remove('fill-yellow-400', 'stroke-yellow-500', 'fill-yellow-300');
                    star.classList.add('fill-gray-300', 'stroke-gray-400');

                    if (starRating <= rating) {
                        star.classList.remove('fill-gray-300', 'stroke-gray-400');
                        if (isHover) {
                            star.classList.add('fill-yellow-300', 'stroke-yellow-500');
                        } else {
                            star.classList.add('fill-yellow-400', 'stroke-yellow-500');
                        }
                    }
                });
            }

            // Event listeners untuk setiap star
            stars.forEach((star) => {
                const rating = parseInt(star.dataset.rating);

                // Hover effect
                star.addEventListener('mouseenter', () => {
                    updateStars(rating, true);
                    ratingText.textContent = `Rating: ${rating} dari 5`;
                });

                // Click handler
                star.addEventListener('click', () => {
                    currentRating = rating;
                    ratingInput.value = rating;
                    updateStars(rating, false);
                    ratingText.textContent = `Rating dipilih: ${rating} dari 5`;
                });
            });

            // Mouse leave - kembali ke rating yang dipilih
            document.getElementById('modalStarRating').addEventListener('mouseleave', () => {
                updateStars(currentRating, false);
                if (currentRating > 0) {
                    ratingText.textContent = `Rating dipilih: ${currentRating} dari 5`;
                } else {
                    ratingText.textContent = 'Pilih rating (1-5)';
                }
            });

            // Function untuk set rating dari luar (untuk pre-fill data)
            return function setRating(rating) {
                currentRating = rating;
                ratingInput.value = rating;
                updateStars(rating, false);
                if (rating > 0) {
                    ratingText.textContent = `Rating dipilih: ${rating} dari 5`;
                } else {
                    ratingText.textContent = 'Pilih rating (1-5)';
                }
            };
        }

        // Setup star rating
        const setModalRating = setupStarRating();

        // Presence buttons functionality (kode yang sudah ada)
        const presenceButtons = document.querySelectorAll('.presence-btn');
        const inputPresence = document.getElementById('modalIsPresent');

        presenceButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const value = btn.getAttribute('data-value');
                inputPresence.value = value;

                presenceButtons.forEach(b => b.classList.remove('bg-green-500', 'text-white',
                    'bg-red-500'));
                if (value === "1") {
                    btn.classList.add('bg-green-500', 'text-white');
                    document.getElementById('rating').style.display = 'block';
                    document.getElementById('rateSection').style.display = 'block';
                } else {
                    btn.classList.add('bg-red-500', 'text-white');
                    document.getElementById('rating').style.display = 'none';
                    document.getElementById('rateSection').style.display = 'none';
                }
            });
        });

        // Modal functionality (kode yang sudah ada dengan modifikasi)
        document.querySelectorAll('.open-modal-btn').forEach(button => {
            button.addEventListener('click', () => {
                const modal = document.getElementById('ratingModal');
                const userId = button.dataset.id;
                const userName = button.dataset.user;
                const isPresent = button.dataset.is_present || '';
                const rating = parseInt(button.dataset.rating) || 0;

                // Isi data ke dalam modal
                document.getElementById('modalUserName').textContent = userName;
                document.getElementById('modalVolunteerId').value = userId;
                document.getElementById('modalIsPresent').value = isPresent;

                // Set star rating sesuai data yang ada
                setModalRating(rating);

                // Set presence button state
                presenceButtons.forEach(b => b.classList.remove('bg-green-500', 'text-white',
                    'bg-red-500'));
                if (isPresent === "1") {
                    document.querySelector('.presence-btn[data-value="1"]').classList.add('bg-green-500',
                        'text-white');
                } else if (isPresent === "0") {
                    document.querySelector('.presence-btn[data-value="0"]').classList.add('bg-red-500',
                        'text-white');
                }

                const form = document.getElementById('modalForm');
                form.action =
                    `{{ route('organization.participation.update', ['event_id' => $event->id, 'volunteer_id' => '__id__']) }}`
                    .replace('__id__', userId);

                modal.classList.remove('hidden');
            });
        });

        document.getElementById('closeModal').addEventListener('click', () => {
            document.getElementById('ratingModal').classList.add('hidden');
        });

        // Close modal when clicking backdrop
        document.getElementById('ratingModal').addEventListener('click', (e) => {
            if (e.target === document.getElementById('ratingModal')) {
                document.getElementById('ratingModal').classList.add('hidden');
            }
        });
    </script>







@endsection
