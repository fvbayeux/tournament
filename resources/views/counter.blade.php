@extends('layout')

<?php
/** @var \App\Setting $currentGame */
?>

@section('style')
    html, body {
    height: 100vh;
    }
@endsection

@section('content')
    <counter initial_value="{{ $currentGame->value }}"></counter>
@endsection