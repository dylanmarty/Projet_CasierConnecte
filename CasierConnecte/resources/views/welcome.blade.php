<!-- Inclusion du header et du footer-->
@extends('base')
@section('title', 'Visualisation des casiers')

@section('content')
    <div class="container">
        <h1 class="text-center text-light" style="margin-bottom:1%; margin-top:2%">Visualisation des casiers</h1>
        <table class="table table-bordered" style="margin-bottom:5%; border:1px black;">
            <tbody>
                <tr>
                    <!-- Affichage des casiers 1, 2 et 3 sur la première ligne -->
                    @foreach ($casiers as $casier)
                        @if ($casier->id >= 1 && $casier->id <= 3)
                            <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;">
                                <div class="mt-2" style="font-weight: bold">{{ $casier->name }}</div>
                                @foreach ($casier->materiels as $materiel)
                                    <div class="mt-2">
                                        <p style="margin-top:2%;">{{ $materiel->nom }}</p>
                                    </div>
                                    <img src="{{ asset($materiel->image) }}" style="width: 13%">
                                    <div class="mt-2" style="font-weight: bold; color: {{ $materiel->etat === 'Disponible' ? 'green' : 'red' }};">{{ $materiel->etat }}</div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                </tr>

                <tr>
                    @foreach ($casiers as $casier)
                        @if ($casier->id == 4)
                            <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;">
                                <!-- Contenu du casier -->
                                <div class="mt-2" style="font-weight: bold">{{ $casier->name }}</div>
                                @foreach ($casier->materiels as $materiel)
                                    <div class="mt-2">
                                        <p style="margin-top:2%;">{{ $materiel->nom }}</p>
                                    </div>
                                    <img src="{{ asset($materiel->image) }}" style="width: 13%">
                                    <div class="mt-2" style="font-weight: bold; color: {{ $materiel->etat === 'Disponible' ? 'green' : 'red' }};">{{ $materiel->etat }}</div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach

                    <!-- Affichage de la case vide sur la deuxième ligne -->
                    <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;"></td>

                    <!-- Affichage du matériel 5 sur la deuxième ligne -->
                    @foreach ($casiers as $casier)
                        @if ($casier->id == 5)
                            <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;">
                                <!-- Contenu du casier -->
                                <div class="mt-2" style="font-weight: bold">{{ $casier->name }}</div>
                                @foreach ($casier->materiels as $materiel)
                                    <div class="mt-2">
                                        <p style="margin-top:2%;">{{ $materiel->nom }}</p>
                                    </div>
                                    <img src="{{ asset($materiel->image) }}" style="width: 13%">
                                    <div class="mt-2" style="font-weight: bold; color: {{ $materiel->etat === 'Disponible' ? 'green' : 'red' }};">{{ $materiel->etat }}</div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                </tr>
                    <tr>
                    @foreach ($casiers as $casier)
                        @if ($casier->id >= 6 && $casier->id <= 8)
                            <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;">
                                <div class="mt-2" style="font-weight: bold">{{ $casier->name }}</div>
                                @foreach ($casier->materiels as $materiel)
                                    <div class="mt-2">
                                        <p style="margin-top:2%;">{{ $materiel->nom }}</p>
                                    </div>
                                    <img src="{{ asset($materiel->image) }}" style="width: 13%">
                                    <div class="mt-2" style="font-weight: bold; color: {{ $materiel->etat === 'Disponible' ? 'green' : 'red' }};">{{ $materiel->etat }}</div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                        </tr>
                        <tr>
                    @foreach ($casiers as $casier)
                        @if ($casier->id >= 9 && $casier->id <= 11)
                            <td class="p-1 text-center align-middle bg-light" style="width: 33.33%;">
                                <div class="mt-2" style="font-weight: bold">{{ $casier->name }}</div>
                                @foreach ($casier->materiels as $materiel)
                                    <div class="mt-2">
                                        <p style="margin-top:2%;">{{ $materiel->nom }}</p>
                                    </div>
                                    <img src="{{ asset($materiel->image) }}" style="width: 13%">
                                    <div class="mt-2" style="font-weight: bold; color: {{ $materiel->etat === 'Disponible' ? 'green' : 'red' }};">{{ $materiel->etat }}</div>
                                @endforeach
                            </td>
                        @endif
                    @endforeach
                        </tr>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
