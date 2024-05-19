<!-- Auteur : Marty Dylan -->

@extends('base')
@include('modalMateriel')
@section('title', 'Gestion des matériels')

@section('content')

    <h1 class="text-light" style="text-align: center; margin-top:4%;margin-bottom:2%;">Visualisation des famille de materiels </h1>
    <h5 class="text-center text-light">Ici vous pouvez voir toutes les famille de matériel disponible.</h5>
    <h5 class="text-center text-light" style="margin-bottom:3%">Vous pouvez également supprimer ou ajouter une ou plusieurs famille de matériel</h5>
    @auth <!-- Vérification de l'authentification de l'utilisateur -->
    @if (auth()->user()->isSuperUtilisateurOrResponsable())
    <div class="btn-group d-flex mb-3 " role="group">
        <button type="button" data-bs-toggle="modal" data-bs-target="#modalAJoutFamille">
            Ajouter une famille de materiel</button>
        &emsp;
        <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeleteToutesLesFamilles">
            Supprimer toutes les données des familles de materiel</button>
        &emsp;
    </div>
    <div>
        <a href="materiel">Cliquez ici pour retourner a la page de gestion des materiels </a>
    </div>
    <div class="bg-light" style="border : solid black 1px; margin-bottom:5%;">
    <table id="familleMaterielTable" >
        <thead>
            <tr>
                <th>Nom</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($Famille_materiel as $famille_materiel)
                <tr>
                    <td>{{ $famille_materiel->nom }}</td>
                    <td>
                        <!-- bouton modifier -->
                        <i class="fa fa-edit" style="scale: 150%" data-bs-toggle="modal"
                            data-bs-target="#modalModifierFamille{{ $famille_materiel->id }}"></i>
                        &emsp;
                        <!-- bouton supprimer -->
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                            data-bs-target="#modalSupprimerFamille{{ $famille_materiel->id }}">
                            <i class="fa fa-trash"></i>
                        </button>
                    </td>
            @endforeach
        </tbody>
    </table>
    @endif
    @endif
    </div>
    <script>
        $(document).ready(function() {

            $('#familleMaterielTable').DataTable({});
        });
    </script>

    @if ($errors->any())
    @if ($errors->has('modifNomFamille'))
        <script>
            $(document).ready(function() {
                $('#erreurModalFamille').modal('show');
            });
        </script>
    @else
        <script>
            $(document).ready(function() {
                $('#modalAJoutFamille').modal('show'); // Afficher le modal d'ajout d'adhérent
            });
        </script>
    @endif
@endif

@endsection

<!-- Modal de modification d'une famille de materiel -->
@foreach ($Famille_materiel as $famille_materiel)
    <div class="modal" id="modalModifierFamille{{ $famille_materiel->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">modifier famille de materiel</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="updateFamille/{{ $famille_materiel->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Modal body -->
                    <div class="modal-body">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Nom</span>
                            <input id="modifNomFamille" name="modifNomFamille" type="nom" class="form-control"
                                value="{{ $famille_materiel->nom }}" />
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="btnAjouterMateriel">Modifier</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal de suppression d'un materiel -->
    <div class="modal fade" id="modalSupprimerFamille{{ $famille_materiel->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupprimer">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer cet famille de materiel ({{ $famille_materiel->nom }}) ?
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- Lien pour supprimer l'adhérent -->
                    <a href="{{ url('/deleteFamille/' . $famille_materiel->id) }}" class="btn btn-primary">Confirmer</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
