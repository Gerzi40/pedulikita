@extends('layouts.app')

@section('title', 'Waiting')

@section('content')

    Rejected

    <a href="{{ route('organization.edit') }}">Edit</a>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
            class="w-full text-left flex items-center px-4 py-2 hover:bg-gray-100 text-gray-700 text-sm">
            🚪 Keluar
        </button>
    </form>

@endsection
