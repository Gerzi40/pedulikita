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
    
    <section class="container mx-auto px-4 pb-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-semibold my-6">Partisipasi Oleh</h1>
            @if ($event->state != 'finished')
                <div class="flex gap-3">
                    <button class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer" id="downloadExcel">Unduh Excel</button>
                    <form action="{{ route('organization.participation.submit', ['event_id' => $event->id]) }}" method="post">
                        @csrf
                        <button type="submit" class="bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Konfirmasi Penilaian</button>
                    </form>
                    <a href="{{ route('organization.participation.edit', ['event_id' => $event->id]) }}" class="inline-block bg-[#1769aa] hover:bg-[#12598d] text-white px-6 py-2 rounded-md font-medium transition cursor-pointer">Nilai</a>
                </div>
            @endif
        </div>
        <table class="table-fixed border-collapse border border-gray-300 w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th class="w-3/5 border border-gray-300 px-4 py-2 text-left">Nama Relawan</th>
                    <th class="w-1/5 border border-gray-300 px-4 py-2 text-left">Kehadiran</th>
                    <th class="w-1/5 border border-gray-300 px-4 py-2 text-left">Nilai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($event->volunteers as $volunteer)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $volunteer->user->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($volunteer->pivot->is_present === true)
                                Hadir
                            @elseif ($volunteer->pivot->is_present === false)
                                Tidak Hadir
                            @endif
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            @if ($volunteer->pivot->rating !== null)
                                <div class="flex gap-1 justify-center max-w-40">
                                    <svg data-rating="1" class="{{ $volunteer->pivot->rating >= 1 ? 'fill-yellow-400 stroke-yellow-500' : 'fill-gray-300 stroke-gray-400' }}" viewBox="0 0 24 24" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    <svg data-rating="2" class="{{ $volunteer->pivot->rating >= 2 ? 'fill-yellow-400 stroke-yellow-500' : 'fill-gray-300 stroke-gray-400' }}" viewBox="0 0 24 24" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    <svg data-rating="3" class="{{ $volunteer->pivot->rating >= 3 ? 'fill-yellow-400 stroke-yellow-500' : 'fill-gray-300 stroke-gray-400' }}" viewBox="0 0 24 24" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    <svg data-rating="4" class="{{ $volunteer->pivot->rating >= 4 ? 'fill-yellow-400 stroke-yellow-500' : 'fill-gray-300 stroke-gray-400' }}" viewBox="0 0 24 24" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                    <svg data-rating="5" class="{{ $volunteer->pivot->rating >= 5 ? 'fill-yellow-400 stroke-yellow-500' : 'fill-gray-300 stroke-gray-400' }}" viewBox="0 0 24 24" stroke-width="1">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" />
                                    </svg>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
            const fontStyle = { bold: true, color: { argb: 'FFFFFFFF' } };
            const alignmentStyle = { horizontal: 'center' };
            const backgroundStyle = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'FF4472C4' } };

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
            const blob = new Blob([buffer], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
            const url = window.URL.createObjectURL(blob);

            const a = document.createElement('a');
            a.href = url;
            a.download = 'template.xlsx';
            a.click();
            window.URL.revokeObjectURL(url);
        });
    </script>

@endsection