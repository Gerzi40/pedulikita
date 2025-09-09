@extends('layouts.volunteer')

@section('title', 'Detail Acara')

@section('content')

    {{ $event }}

    @if ($event->volunteers->contains('id', Auth::user()->id))
        <p>Anda sudah berpartisipasi</p>
    @else
        <form action="{{ route('volunteer.participation.store', ['event_id' => $event->id]) }}" method="post">
            @csrf
            <button type="submit">Partisipasi</button>
        </form>
    @endif

@endsection
