@extends('layouts.organization')

@section('title', 'Buat Berita')

@section('content')
<div class="max-w-full mx-auto p-8 bg-white rounded-2xl shadow-md mt-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 pb-2">📝 Review Event</h1>

    {{-- Informasi Event --}}
    <section class="grid md:grid-cols-3 gap-6 mb-10">
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Acara</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $event->name }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Jumlah Volunteer</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $total_volunteer }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Lokasi Acara</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $event->location }}, {{ $event->city->name }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Tanggal</label>
            <input type="date" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $event->date }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Acara Mulai</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $event->start_time }}" disabled>
        </div>

        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Acara Berakhir</label>
            <input type="text" class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-100 focus:outline-none" 
                value="{{ $event->end_time }}" disabled>
        </div>
    </section>

    {{-- Form Berita --}}
    <section>
        <form action="{{ route('organization.news.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Judul Berita</label>
                <input type="text" name="judul" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                    value="{{ old('judul', $news->news_title ?? '') }}">
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Berita</label>
                <textarea name="deskripsi" class="w-full border rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400" 
                    rows="5">{{ old('deskripsi', $news->desc ?? '') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Gambar Berita</label>
                <input type="file" name="gambar[]" id="gambar" multiple 
                    class="w-full border rounded-lg px-4 py-2 text-sm bg-gray-50 cursor-pointer focus:ring-2 focus:ring-blue-400">
                <p class="text-xs text-gray-500 mt-1">Unggah gambar minimal 1170x504 piksel. Format: JPG, GIF, PNG.</p>
            </div>

            <div id="preview" class="flex flex-wrap gap-3 mt-4">
                @isset($news)
                    @php
                        $paths = $news->image_url !== '' ? explode(';', $news->image_url) : [];
                    @endphp

                    @foreach ($paths as $p)
                        <img src="{{ Storage::disk('s3')->url($p) }}" 
                             class="w-64 h-40 object-cover rounded-lg border shadow-sm" 
                             alt="existing image">
                    @endforeach
                @endisset
            </div>

            <div class="flex justify-end mt-6 space-x-3">
                <a href="{{ url()->previous() }}" 
                   class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium">
                    Kembali
                </a>
                <button type="submit" 
                    class="px-5 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold shadow-md transition">
                    Kirim
                </button>
            </div>
        </form>
    </section>
</div>

<script>
    const inputGambar = document.getElementById('gambar');
    const previewContainer = document.getElementById('preview');

    inputGambar.addEventListener('change', function() {
        previewContainer.innerHTML = "";
        const files = Array.from(this.files);

        files.forEach(file => {
            if (!file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('w-64', 'h-40', 'object-cover', 'rounded-lg', 'border', 'shadow-sm');
                previewContainer.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });
</script>
@endsection
