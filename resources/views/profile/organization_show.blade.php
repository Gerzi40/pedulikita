@extends('layouts.organization')

@section('title', 'Profil')

@section('content')

    <p>{{ $user }}</p>

    Events:
    @foreach ($events as $event)
        <li>{{ $event }}</li>
    @endforeach

    Volunteers:
    @foreach ($volunteers as $volunteer)
        <li>{{ $volunteer }}</li>
    @endforeach

@endsection
