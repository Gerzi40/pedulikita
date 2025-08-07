@extends('layouts.guest')

@section('title', 'Atur Ulang Kata Sandi')

@section('content')

    <form action="{{ route('password.store') }}" method="post">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}"/>
        <input type="text" name="email" value="{{ $email }}"/>
        <x-input-password type="password" name="password" id="password"/>
        <x-input-password type="password" name="password_confirmation" id="password_confirmation"/>
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
