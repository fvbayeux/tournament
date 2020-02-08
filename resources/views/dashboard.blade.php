@extends('layout')

@section('style')
    html, body {
    height: 100vh;
    }
@endsection

@section('content')
    <div class="h-screen flex bg-grey-lightest">
        <div class="w-2/3 h-full p-2">
            <dashboard-games></dashboard-games>
        </div>
        <div class="w-1/3 h-full">
            <div class="h-1/4 w-full p-2">
                <dashboard-counter></dashboard-counter>
            </div>
            <div class="h-1/2 w-full p-2">
                <players></players>
            </div>
            <div class="h-1/4 w-full p-2">
                <div class="h-full w-full px-4 py-2 shadow-lg bg-white">
                    <h3 class="text-center mb-4">Zone de tous les dangers</h3>

                    <div class="">
                        <h4 class="mb-2">Importer des joueurs</h4>

                        <form action="{{ route('players.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div>
                                <input type="file" accept="text/plain" name="file" required>
                                <button type="submit" class="rounded border p-2">Importer</button>
                            </div>
                            @if($errors->has('file')) {{ $errors->first('file') }} @endif
                        </form>

                        <h4 class="mt-4 mb-2">Tout supprimer</h4>
                        <form action="{{ route('flush-all') }}" method="POST">
                            @csrf
                            <div>
                                <input type="text" name="pass"
                                       class="border rounded w-3/4 p-2"
                                       placeholder="Entrez 'je prends le risque' pour pouvoir supprimer" required>
                                <button type="submit" class="rounded border p-2">Je suis sûr</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
