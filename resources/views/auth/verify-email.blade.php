@extends('layouts.app')

@section('title', 'Verifikasi Email')

@section('content')

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-[#2263AC] mb-2 tracking-wide text-center">PEDULIKITA</h1>

            <div class="text-gray-600 text-sm mb-6 text-justify">
                Terima kasih telah mendaftar! Sebelum memulai, bisakah Anda memverifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirimkan? Jika Anda tidak menerima email tersebut, kami dengan senang hati akan mengirimkan yang baru.
            </div>
        
            @if (session('status'))
                <div class="font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif
        
            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="bg-[#2263AC] text-white py-2 px-3 rounded-md font-semibold hover:bg-[#1d5495] transition duration-200 cursor-pointer">
                        Kirim Ulang Email Verifikasi
                    </button>
                </form>
        
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

@endsection
