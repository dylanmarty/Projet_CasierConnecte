@extends('base')

@include('modalAdherent')

@section('title', 'Gestion des adherents')

@section('content')

    <!-- Fenêtre affichage de la liste des adherents -->
    <h1 class="text-light" style="text-align: center; margin-top:4%;margin-bottom:2%;">Visualisation des adherents </h1>
    <h5 class="text-center text-light">Ici vous pouvez voir tous les adhérents à la MDL</h5>
    <h5 class="text-center text-light" style="margin-bottom:3%;">Vous pouvez également rajouter ou supprimer des adhérents. Il
        est également possible d'importer une liste d'adhérent</h5>

    <!-- Affichage des boutons pour ajouter, importer et supprimer des adhérents -->
    @auth <!-- Vérification de l'authentification de l'utilisateur -->
        @if (auth()->user()->isSuperUtilisateurOrResponsable())
            <div class="btn-group d-flex mb-3" role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalAJoutAdherent">
                    Ajouter un adhérent</button>
                &emsp;
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalImporterAdherent">
                    Importer des adhérents</button>
                &emsp;
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeleteTousLesAdherent">
                    Supprimer tous les adhérents</button>
            </div>


            <!-- Tableau d'affichage des adhérents -->
            <div class="bg-light" style="border:solid black 1px">
                <table id="adherentsTable">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Classe</th>
                            <th>Date de naissance</th>
                            <th>Numéro de téléphone</th>
                            <th>Numéro de badge</th>
                            <th>Numéro RFID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($adherents as $adherent)
                            <tr>
                                <td>{{ $adherent->nom }}</td>
                                <td>{{ $adherent->prenom }}</td>
                                <td>{{ $adherent->classe }}</td>
                                <td>{{ $adherent->date_naissance }}</td>
                                <td>{{ $adherent->num_telephone }}</td>
                                <td>{{ $adherent->num_badge }}</td>
                                <td>{{ $adherent->tag_RFID }}</td>
                                <td>
                                    <!-- Boutons pour modifier et supprimer un adhérent -->
                                    <i class="fa fa-edit" style="scale: 150%" data-bs-toggle="modal"
                                        data-bs-target="#modalModifierAdherent{{ $adherent->id }}"></i>
                                    &emsp;
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalSupprimerAdherent{{ $adherent->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
        @endif
        <!-- Script pour l'initialisation de la DataTable -->
        <script>
            $(document).ready(function() {
                $('#adherentsTable').DataTable({
                    "language": {
                        "search": "Rechercher :",
                        "lengthMenu": "Afficher _MENU_ entrées",
                        "info": "Affichage de _START_ à _END_ sur _TOTAL_ entrées",
                        "paginate": {
                            "previous": "Précédent",
                            "next": "Suivant"
                        }
                    },
                    "drawCallback": function(settings) {
                        var pageInfo = this.api().page.info();
                    }
                });
            });
        </script>

        <!-- Gestion de l'affichage des modals en fonction des erreurs ou des actions -->


        @if ($errors->has('csvFile'))
            <script>
                $(document).ready(function() {
                    $('#erreurModalImportation').modal('show');
                });
            </script>
        @endif

    @endsection

    <!-- Modals pour la suppression et la modification des adhérents -->
    @foreach ($adherents as $adherent)
        <div class="modal fade" id="modalSupprimerAdherent{{ $adherent->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalSupprimer">Supprimer</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                    </div>
                    <div class="modal-body">
                        Voulez-vous vraiment supprimer cet adhérent ({{ $adherent->nom }} {{ $adherent->prenom }}) ?
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <!-- Lien pour supprimer l'adhérent -->
                        <a href="{{ url('/deleteAdherent/' . $adherent->id) }}" class="btn btn-primary">Confirmer</a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @foreach ($adherents as $adherent)
        <div class="modal" id="modalModifierAdherent{{ $adherent->id }}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                        <h4 class="modal-title">modifier un adherent</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="updateAdherent/{{ $adherent->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <!-- Modal body -->
                        <div class="modal-body">
                            @csrf
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Nom</span>
                                <input id="modifNom" name="modifNom" type="nom" class="form-control"
                                    value="{{ $adherent->nom }}" pattern="^[^\d]+$" required />
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Prenom</span>
                                <input id="modifPrenom" name="modifPrenom" type="nom" class="form-control"
                                    value="{{ $adherent->prenom }}" pattern="^[^\d]+$" required />
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Classe</span>
                                <input id="modifClasse" name="modifClasse" type="nom" class="form-control"
                                    value="{{ $adherent->classe }}" required />
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">date de naissance</span>
                                <input id="modifNaissance" name="modifNaissance" type="nom" class="form-control"
                                    value="{{ $adherent->date_naissance }}" pattern="^\d{2}\/\d{2}\/\d{4}$" required />
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">Numero de telephone</span>
                                <input id="modifNumTelephone" name="modifNumTelephone" type="nom" class="form-control"
                                    value="{{ $adherent->num_telephone }}" pattern="^\d{10}$" required />
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text" id="basic-addon1">numero de badge</span>
                                <input id="modifNumBadge" name="modifNumBadge" type="nom" class="form-control"
                                    value="{{ $adherent->num_badge }}" pattern="^\d+$" required />
                            </div>

                        </div>
                        <!-- Modal footer -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                            <button type="submit" class="btn btn-primary" id="btnAjouterAdherent">Modifier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
