@extends('layouts.app')

@section('title', 'Waiting')

@section('content')

    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md w-full max-w-md">
            <h1 class="text-2xl font-bold text-[#2263AC] mb-2 tracking-wide text-center">PEDULIKITA</h1>

            <div class="text-gray-600 text-sm mb-6 text-justify">
                Wainting for Approval
            </div>

            <div class="mt-4 flex items-center justify-between">
                <div></div>
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
