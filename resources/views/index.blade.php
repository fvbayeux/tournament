@extends('layout')

@section('style')
    html, body {
    height: 100vh;
    }
@endsection

@section('content')
    <div class="h-screen flex flex-col justify-center items-center text-xl">
        <a href="{{ route('dashboard') }}" class="my-5">Dashboard</a>
        <a href="{{ route('counter') }}" class="my-5">Compteur</a>
        <a href="{{ route('games') }}" class="my-5">Matchs</a>
    </div>
@endsection
