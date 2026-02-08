@extends('layouts.organization')

@section('title', 'Relawan Acara')

@section('content')

    <section class="max-w-6xl mx-auto mt-10 px-4">

        {{-- BACK BUTTON --}}
        <a href="{{ route('organization.events.show', ['id' => $event->id]) }}"
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

        <div class="grid md:grid-cols-2 gap-10 items-center">
            {{-- Gambar --}}
            <div>
                <img src="{{ Storage::disk('s3')->url($event->image_url) }}" alt="gambar event"
                    class="rounded-xl shadow-md w-full object-cover">
            </div>

            {{-- Informasi --}}
            <div class="space-y-4">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $event->name }}</h1>
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
            </div>
        </div>
    </section>

    <section class="container mx-auto px-4 pb-4">
        <div class="flex flex-wrap justify-between items-center">
            <h1 class="text-2xl font-bold my-6 text-[var(--color1)]">Partisipasi Oleh</h1>
            @php
                use Carbon\Carbon;

                $eventDateTime = Carbon::parse($event->date . ' ' . $event->end_time);
            @endphp
            <div class="flex flex-wrap gap-3">
                @if (!in_array($event->state, ['finished', 'reviewed']))
                    <button
                        class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer"
                        id="downloadExcel">
                        Unduh Excel
                    </button>
                @endif
                @if (
                    !in_array($event->state, ['finished', 'reviewed']) &&
                    Carbon::now()->greaterThan($eventDateTime)
                )
                    <a href="{{ route('organization.participation.edit', ['event_id' => $event->id]) }}"
                        class="inline-block bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Nilai</a>
                    <form action="{{ route('organization.participation.submit', ['event_id' => $event->id]) }}"
                        method="post">
                        @csrf
                        <button type="submit"
                            class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Konfirmasi
                            Penilaian</button>
                    </form>
                @endif
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full border-separate" style="border-spacing: 0 0.75rem;">
                <thead class="rounded-lg text-gray-500 bg-gray-50">
                    <tr>
                        <th class="min-w-100 w-3/5 p-4 text-left text-sm font-semibold">Nama Relawan</th>
                        <th class="min-w-50 w-1/5 p-4 text-left text-sm font-semibold">Kehadiran</th>
                        <th class="min-w-50 w-1/5 p-4 text-left text-sm font-semibold">Nilai</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($event->volunteers as $volunteer)
                        <tr class="rounded-lg shadow-sm">
                            <td class="p-4 rounded-l-lg {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <div class="flex items-center space-x-4">
                                    <img class="h-10 w-10 rounded-full object-cover"
                                        src="{{ Storage::disk('s3')->url($volunteer->user->profile_picture_url) }}"
                                        alt="{{ $volunteer->user->name }}">
                                    <span class="font-medium text-gray-800">{{ $volunteer->user->name }}</span>
                                </div>
                            </td>
                            <td class="p-4 {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                @if ($volunteer->pivot->is_present === true)
                                    <span
                                        class="inline-flex items-center gap-2 bg-green-100 text-green-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Hadir
                                    </span>
                                @elseif ($volunteer->pivot->is_present === false)
                                    <span
                                        class="inline-flex items-center gap-2 bg-red-100 text-red-800 text-xs font-semibold px-3 py-1 rounded-full">
                                        Absen
                                    </span>
                                @endif
                            </td>
                            <td class="p-4 rounded-r-lg {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                @if ($volunteer->pivot->rating !== null)
                                    <div class="flex gap-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="star w-6 h-6  {{ $volunteer->pivot->rating >= $i ? 'text-yellow-400' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @empty
                        {{-- EMPTY STATE --}}
                        <tr>
                            <td colspan="3" class="p-8 text-center">
                                <div class="flex flex-col items-center gap-3 text-gray-400">
                                    <svg class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M8 7h8M8 11h8M8 15h6M4 5h16a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V7a2 2 0 012-2z" />
                                    </svg>
                                    <p class="text-sm font-medium">
                                        Belum ada relawan yang terdaftar
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
        document.getElementById('downloadExcel').addEventListener('click', async () => {
            const volunteers = {{ Js::from($event->volunteers) }};

            const workbook = new ExcelJS.Workbook();
            const worksheet = workbook.addWorksheet('Sheet1');

            // insert
            worksheet.addRow(['Id', 'Nama', 'Kehadiran', 'Nilai']);

            for (let i = 0; i < volunteers.length; i++) {
                worksheet.addRow([volunteers[i].id, volunteers[i].user.name]);

                worksheet.getCell(`C${i+2}`).dataValidation = {
                    type: 'list',
                    formulae: ['"Hadir,Tidak Hadir"'],
                    allowBlank: true,
                    showErrorMessage: true,
                    errorTitle: 'Pilihan Tidak Sesuai',
                    error: 'Silakan pilih dari dropdown.'
                };

                worksheet.getCell(`D${i+2}`).dataValidation = {
                    type: 'whole',
                    operator: 'between',
                    formulae: [0, 5],
                    allowBlank: true,
                    showErrorMessage: true,
                    errorTitle: 'Nilai Tidak Sesuai',
                    error: 'Nilai harus antara 0 sampai 5'
                };
            }

            // styling
            const fontStyle = {
                bold: true,
                color: {
                    argb: 'FFFFFFFF'
                }
            };
            const alignmentStyle = {
                horizontal: 'center'
            };
            const backgroundStyle = {
                type: 'pattern',
                pattern: 'solid',
                fgColor: {
                    argb: 'FF4472C4'
                }
            };

            worksheet.getColumn(1).hidden = true;

            worksheet.getColumn(2).width = 30;
            worksheet.getColumn(3).width = 10;
            worksheet.getColumn(4).width = 10;

            worksheet.getCell('B1').font = fontStyle;
            worksheet.getCell('B1').alignment = alignmentStyle;
            worksheet.getCell('B1').fill = backgroundStyle;

            worksheet.getCell('C1').font = fontStyle;
            worksheet.getCell('C1').alignment = alignmentStyle;
            worksheet.getCell('C1').fill = backgroundStyle;

            worksheet.getCell('D1').font = fontStyle;
            worksheet.getCell('D1').alignment = alignmentStyle;
            worksheet.getCell('D1').fill = backgroundStyle;

            // downloading
            const buffer = await workbook.xlsx.writeBuffer();
            const blob = new Blob([buffer], {
                type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            });
            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = 'template.xlsx';
            a.click();
            window.URL.revokeObjectURL(url);
        });
    </script>

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
