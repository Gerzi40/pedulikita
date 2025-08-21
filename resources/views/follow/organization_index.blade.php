@extends('layouts.organization')

@section('title', 'Relawan Pengikut')

@section('content')

    @foreach ($volunteers as $volunteer)
        <li>{{ $volunteer }}</li>
    @endforeach

@endsection
