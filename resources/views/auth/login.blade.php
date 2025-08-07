@extends('layouts.guest')

@section('title', 'Masuk')

@section('content')

    <div>{{ session('status') }}</div>

    <form action="{{ route('login') }}" method="post">
        @csrf
        <input type="text" name="email"/>
        <x-input-password type="password" name="password" id="password"/>
        <input type="checkbox" name="remember"/>
        <button type="submit">Daftar</button>
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

    <a href="{{ route('password.request') }}">Lupa kata sandi?</a>

@endsection
