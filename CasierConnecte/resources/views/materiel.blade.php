@extends('base')
@include('modalMateriel')
@section('title', 'Gestion des matériels')


@section('content')

    <head>


        <title>Visualisation des casiers</title>

        <link rel="icon" type="image/png" href="images/logo.png">
        <style>
            .table td:hover {
                box-shadow: 0 0 10px 2px black;
                transform: scale(1.02);
                transition: transform 0.3s ease;
            }

            .image:hover {
                transform: scale(1.08);
                transition: transform 0.3s ease;
            }

            .connexion {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                text-decoration: none;
                color: #ffffff;
            }

            .connexion:hover {
                background-color: rgba(255, 255, 255, 0.5);
                color: #ffffff;
                transform: scale(1.08);
                transition: transform 0.3s ease;
            }

            .dataTables_wrapper .dataTables_filter input {
                background-color: white;
                /* Fond blanc */
                margin-bottom: 5%;
                margin-top: 5%;
            }
            /* Stylisation du menu déroulant pour le nombre d'entrées à afficher */
            .dataTables_length {
                margin-top: 2%; /* Espacement en bas du menu */
            }

        </style>
    </head>

    <body style="font-family: Lato, sans-serif;; background: linear-gradient(to bottom left, #ff7f00, #e9a44a, #e7dc40">

        <h1 class="text-light" style="text-align: center; margin-top:4%;margin-bottom:2%;">Visualisation des materiels </h1>
        <h5 class="text-light text-center" style="margin-bottom:3%;">Ici vous pouvez voir la liste des matériels existants.</h5>
        <div class="container mt-5">

            <select id="Famille_materiel">
                <option value="-1">-- Choisissez une famille de matériel --</option>
                @foreach ($Famille_materiel as $famille)
                    <option value="{{ $famille->id }}">{{ $famille->nom }}</option>
                @endforeach
            </select>
            &emsp;
            <a href="familleMateriel">Cliquez ici pour aller sur la page de gestion des familles de materiel</a>
        </div>
        &emsp;
        <div class="btn-group d-flex mb-3 " role="group">
            <button type="button" data-bs-toggle="modal" data-bs-target="#modalAJoutMateriel">
                Ajouter un materiel</button>
            &emsp;
            <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeleteToutLesMateriels">
                Supprimer tout les données des materiel</button>
        </div>
        <div class="bg-light" style="border: solid black 1px; margin-bottom:5%;">
        <table id="materielTable" >
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Image</th>
                    <th>État</th>
                    <th>Durée d'emprunt (h)</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        </div>
        <script>
            $(document).ready(function() {

                $('#materielTable').DataTable({
                    searching: false

                });

                $('#Famille_materiel').change(function() {
                    var familleId = $(this).val();
                    $.ajax({
                        url: '/filtrer-materiels',
                        type: 'GET',
                        data: {
                            familleId: familleId
                        },
                        success: function(data) {
                            updateTable(data);
                        }
                    });
                });

                function updateTable(data) {
                    var tableBody = $('#materielTable tbody');
                    tableBody.empty();
                    $.each(data, function(index, materiel) {
                        var row = '<tr>' +
                            '<td>' + materiel.nom + '</td>' +
                            '<td><img src="' + materiel.image +
                            '" alt="Image du matériel" style="max-width: 100px;"></td>' +
                            '<td>' + materiel.etat + '</td>' +
                            '<td>' + materiel.duree_emprunt + '</td>' +
                            '<td>' +
                            '<i class="fa fa-edit" style="scale: 150%" data-bs-toggle="modal" data-bs-target="#modalModifierMateriel' +
                            materiel.id + '"></i>' +
                            '&emsp;' +
                            '<button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalSupprimerAdherent' +
                            materiel.id + '"><i class="fa fa-trash"></i></button>' +
                            '</td>' +
                            '</tr>';
                        tableBody.append(row);
                    });
                }
                Z
            });
        </script>

        @if ($errors->any())
            @if (
                $errors->has('modifNomMateriel') ||
                    $errors->has('modifDureeMateriel') ||
                    $errors->has('modifFamilleMateriel'))
                <script>
                    $(document).ready(function() {
                        $('#erreurModalMateriel').modal('show');
                    });
                </script>
            @else
                <script>
                    $(document).ready(function() {
                        $('#modalAJoutMateriel').modal('show'); // Afficher le modal d'ajout d'adhérent
                    });
                </script>
            @endif
        @endif

    @endsection

    <!-- Modal de modification d'un materiel -->
    @foreach ($Materiel as $Materiel)
        <div class="modal" id="modalModifierMateriel{{ $Materiel->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">modifier un materiel</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="updateMateriel/{{ $Materiel->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Modal body -->
                        <div class="modal-body">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Nom</span>
                                <input id="modifNomMateriel" name="modifNomMateriel" type="nom" class="form-control"
                                    value="{{ $Materiel->nom }}" />
                            </div>
                            &emsp;
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">duree_emprunt</span>
                                <input id="modifDureeMateriel" name="modifDureeMateriel" type="nom" class="form-control"
                                    value="{{ $Materiel->duree_emprunt }}" />
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Ce matériel fait partie de la famille
                                    :</span>
                                <select id="modifFamilleMateriel" name="modifFamilleMateriel" class="form-select">
                                    <option value="{{ $famille->id }}">{{ $famille->nom }}</option>
                                    @foreach ($Famille_materiel as $famille)
                                        <option value="{{ $famille->id }}">{{ $famille->nom }}</option>
                                    @endforeach
                                </select>

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
        <div class="modal fade" id="modalSupprimerAdherent{{ $Materiel->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSupprimer">Supprimer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer ce materiel ({{ $Materiel->nom }}) ?
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <!-- Lien pour supprimer l'adhérent -->
                        <a href="{{ url('/deleteMateriel/' . $Materiel->id) }}" class="btn btn-primary">Confirmer</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
        <!-- Footer -->
    </body>
