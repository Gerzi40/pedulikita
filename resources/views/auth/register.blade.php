@extends('layouts.guest')

@section('title', 'Daftar')

@section('content')

    <form action="{{ route('register') }}" method="post">
        @csrf
        <input type="text" name="name"/>
        <input type="text" name="email"/>
        <x-input-password type="password" name="password" id="password"/>
        <x-input-password type="password" name="password_confirmation" id="password_confirmation"/>
        <input type="text" name="gender"/>
        <input type="date" name="date_of_birth"/>
        <input type="checkbox" name="terms"/>
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

@endsection
