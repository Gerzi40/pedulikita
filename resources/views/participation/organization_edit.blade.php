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
                            <img src="{{ asset('assets/icons/category.png') }}" class="w-5 h-5" alt="">
                            <span>{{ $event->event_category->name }}</span>
                        </div>
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

    <section class="container mx-auto px-4">
        <div id="error-messages"
            class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mt-4 hidden" role="alert">
            <ul class="list-disc list-inside"></ul>
        </div>
    </section>

    <section class="container mx-auto px-4 pb-8 font-sans">
        <form action="{{ route('organization.participation.update', ['event_id' => $event->id]) }}" method="post"
            id="form">
            @csrf
            @method('put')

            {{-- Header dengan Tombol --}}
            <div class="flex flex-wrap justify-between items-center gap-4 my-6">
                <h1 class="text-2xl font-bold text-gray-800">Partisipasi Relawan</h1>
                <div class="flex items-center gap-2">
                    <input type="file" id="excelUpload" accept=".xlsx,.xls" class="hidden" />
                    <label for="excelUpload"
                        class="inline-block bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">
                        Impor Excel
                    </label>
                    <button type="submit"
                        class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">
                        Simpan
                    </button>
                </div>
            </div>

            {{-- Tabel Input --}}
            <table class="w-full border-separate" style="border-spacing: 0 0.75rem;"> {{-- Sedikit tambah spasi antar baris --}}
                {{-- Header Tabel --}}
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="w-[40%] px-6 py-3 text-left text-sm font-semibold text-gray-500 rounded-l-lg">
                            Nama Relawan
                        </th>
                        <th class="w-[45%] px-6 py-3 text-left text-sm font-semibold text-gray-500">
                            Kehadiran
                        </th>
                        <th
                            class="w-[15%] px-8 py-3 text-left text-sm font-semibold text-gray-500 rounded-r-lg">
                            Nilai
                        </th>
                    </tr>
                </thead>

                {{-- Body Tabel --}}
                <tbody class="bg-white">
                    @foreach ($event->volunteers as $volunteer)
                        <tr class="shadow-sm">
                            {{-- Nama Relawan --}}
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 rounded-l-lg {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <div class="flex items-center gap-5">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="{{ Storage::disk('s3')->url($volunteer->user->profile_picture_url) }}"
                                        alt="{{ $volunteer->user->name }}">
                                    <span class="font-medium text-gray-800">{{ $volunteer->user->name }}</span>
                                </div>
                            </td>

                            {{-- Input Kehadiran --}}
                            <td
                                class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <select name="data[{{ $volunteer->id }}][is_present]"
                                    class="block w-3/4 p-2 border border-gray-300 rounded-md bg-white focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
                                    <option value="" @selected($volunteer->pivot->is_present === null)>Pilih Status</option>
                                    <option value="TRUE" @selected($volunteer->pivot->is_present === true)>Hadir</option>
                                    <option value="FALSE" @selected($volunteer->pivot->is_present === false)>Tidak Hadir</option>
                                </select>
                            </td>

                            {{-- Input Nilai (Rating) --}}
                            <td
                                class="px-8 py-4 whitespace-nowrap text-sm text-gray-500 rounded-r-lg {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <input type="number" name="data[{{ $volunteer->id }}][rating]"
                                    value="{{ $volunteer->pivot->rating }}" class="hidden rating-input" />
                                <div class="stars flex gap-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg data-rating="{{ $i }}"
                                            class="star w-6 h-6 cursor-pointer transition-all duration-200 hover:scale-110 {{ $volunteer->pivot->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                            fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    @endfor
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </section>


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
        document.getElementById('form').addEventListener('submit', function(e) {
            let valid = true;
            let messages = [];

            document.querySelectorAll('table tbody tr').forEach((tr, index) => {
                const select = tr.querySelector('select');
                const input = tr.querySelector('input[type="number"]');

                const volunteerName = tr.querySelector('td').innerText.trim();

                if (!select.value && !input.value) return;

                if (select.value && !input.value) {
                    valid = false;
                    console.log(`Relawan ${volunteerName}: Kehadiran perlu diisi.`);
                    messages.push(`Relawan ${volunteerName}: Kehadiran perlu diisi.`);
                }

                if (!select.value && input.value) {
                    valid = false;
                    console.log(`Relawan ${volunteerName}: Nilai perlu diisi.`);
                    messages.push(`Relawan ${volunteerName}: Nilai perlu diisi.`);
                }

                const rating = parseInt(input.value);

                if (select.value == 'TRUE' && (rating < 1 || rating > 5)) {
                    valid = false;
                    console.log(`Relawan ${volunteerName}: Jika hadir, nilai harus antara 1 sampai 5.`);
                    messages.push(`Relawan ${volunteerName}: Jika hadir, nilai harus antara 1 sampai 5.`);
                }

                if (select.value == 'FALSE' && rating != 0) {
                    valid = false;
                    console.log(`Relawan ${volunteerName}: Jika tidak hadir, nilai harus 0.`);
                    messages.push(`Relawan ${volunteerName}: Jika tidak hadir, nilai harus 0.`);
                }
            });

            const errorBox = document.getElementById('error-messages');
            const errorList = errorBox.querySelector('ul');
            errorList.innerHTML = '';

            if (!valid) {
                e.preventDefault();
                messages.forEach(msg => {
                    const li = document.createElement('li');
                    li.textContent = msg;
                    errorList.appendChild(li);
                });
                errorBox.classList.remove('hidden');
            } else {
                errorBox.classList.add('hidden');
            }
        });
    </script>

    <script>
        document.querySelectorAll('tr').forEach(row => {
            const select = row.querySelector('select[name*="[is_present]"]');
            const input = row.querySelector('input[name*="[rating]"]');
            const starsContainer = row.querySelector('.stars');
            const stars = starsContainer?.querySelectorAll('.star');

            if (!select || !stars) return;

            const updateStars = (rating) => {
                stars.forEach(s => {
                    if (parseInt(s.dataset.rating) <= rating) {
                        s.classList.add('fill-yellow-400', 'stroke-yellow-500');
                        s.classList.remove('fill-gray-300', 'stroke-gray-400');
                    } else {
                        s.classList.add('fill-gray-300', 'stroke-gray-400');
                        s.classList.remove('fill-yellow-400', 'stroke-yellow-500');
                    }
                });
            };

            stars.forEach(star => {
                star.addEventListener('click', () => {
                    if (select.value === 'FALSE') return;
                    const rating = parseInt(star.dataset.rating);
                    input.value = rating;
                    updateStars(rating);
                });
            });

            select.addEventListener('change', () => {
                if (select.value == 'FALSE') {
                    input.value = '0';
                    updateStars(0);
                }
            })

            updateStars(parseInt(input.value) || 0);
        });
    </script>

    <script>
        document.getElementById('excelUpload').addEventListener('change', async (e) => {
            const input = e.target;
            const file = input.files[0];
            if (!file) return;

            const arrayBuffer = await file.arrayBuffer();

            const workbook = new ExcelJS.Workbook();
            await workbook.xlsx.load(arrayBuffer);

            const worksheet = workbook.getWorksheet(1);

            worksheet.eachRow((row, rowNumber) => {
                if (rowNumber === 1) return;

                const id = row.values[1];
                const isPresent = row.values[3];
                const rating = row.values[4];

                const select = document.querySelector(`select[name="data[${id}][is_present]"]`);
                const ratingInput = document.querySelector(`input[name="data[${id}][rating]"]`);
                const stars = document.querySelectorAll(
                    `tr input[name="data[${id}][rating]"] ~ .stars .star`);

                if (isPresent == 'Hadir') {
                    select.value = 'TRUE';
                } else if (isPresent == 'Tidak Hadir') {
                    select.value = 'FALSE';
                }

                if (rating) {
                    ratingInput.value = rating;
                }

                const r = parseInt(ratingInput.value) || 0;
                stars.forEach(s => {
                    if (parseInt(s.dataset.rating) <= r) {
                        s.classList.add('fill-yellow-400', 'stroke-yellow-500');
                        s.classList.remove('fill-gray-300', 'stroke-gray-400');
                    } else {
                        s.classList.add('fill-gray-300', 'stroke-gray-400');
                        s.classList.remove('fill-yellow-400', 'stroke-yellow-500');
                    }
                });
            });

            input.value = '';
        });
    </script>

@endsection
