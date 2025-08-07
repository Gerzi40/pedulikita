@extends('layouts.guest')

@section('title', 'Lupa Kata Sandi')

@section('content')

    <div>{{ session('status') }}</div>

    <form action="{{ route('password.email') }}" method="post">
        @csrf
        <input type="text" name="email"/>
        <button type="submit">Kirim</button>
    </form>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

@endsection
