@extends('layout')

@section('style')
    body {
    overflow: hidden;
    }
@endsection

@section('content')
    <games :initial_games="{{ json_encode($games) }}"></games>
@endsection