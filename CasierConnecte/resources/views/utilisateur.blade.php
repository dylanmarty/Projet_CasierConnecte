<!-- Inclusion du header et du footer-->
@extends('base')
@section('title', 'Gestion des utilisateurs')

@section('content')


    <h1 class="text-light" style="text-align: center; margin-top:4%;margin-bottom:2%;">Visualisation des utilisateurs </h1>
    <h5 class="text-center text-light" style="margin-bottom:3%;">Ici vous pouvez voir la liste des utilisateurs</h5>
    <!--Savoir si l'utilisateur est connecté ou non en tant que superutilisateur pour savoir si il peut avoir accès au site -->
    @auth
        @if (auth()->user()->isSuperUtilisateur())
        <!--Pouvoir supprimer tous les utilisateurs -->
            <div class="mb-3 btn-group d-flex " role="group">
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalDeleteTousLesUtilisateurs">
                    Supprimer tous les utilisateurs</button>
            </div>

            <div class="bg-light" style="border:solid black 1px;">
                <table id="utilisateurTable" style="margin-bottom:3%;">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>email</th>
                            <th>password</th>
                            <th>droit</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--Pour chaque utilisateur, nous avons une ligne avec ses données qui se rajoute dans le tableau-->
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->password }}</td>
                                <td>{{ $user->droit }}</td>
                                <td>
                                    <!-- bouton modifier -->
                                    <i class="fa fa-edit" style="scale: 150%" data-bs-toggle="modal"
                                        data-bs-target="#modalModifierDroitUtilisateur{{ $user->id }}"></i>
                                    &emsp;
                                    <!-- bouton supprimer -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalSupprimerAdherent{{ $user->id }}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <script>
                // Faire la dataTable, et faire en sorte que la traduction s'applique
                $(document).ready(function() {
                    $('#utilisateurTable').DataTable({
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
        @else
        <!--Résultat si nous ne sommes pas connecté en tant que Super-Utilisateur-->
            <h3 class="text-center text-light" style="margin-top:10%;">Privilèges insuffisants</h3>
            <h4 class="text-center text-light" style="margin-top:10%;margin-bottom:6%;">Vous n'êtes pas connecté, vous n'avez
                donc pas accès au reste du site, veuillez retourner vers la page d'accueil</h4>
        @endif
    @endauth
@endsection

<!-- Modal de modification de droits d'un utilsateur -->
@foreach ($users as $user)
    <div class="modal" id="modalModifierDroitUtilisateur{{ $user->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">modifier les droits d'un utilisateur</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="updateUtilisateur/{{ $user->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Modal body -->
                    <div class="mb-3 input-group">
                        <span class="input-group-text" id="basic-addon1">
                            {{ $user->name }} aura le droit : </span>
                        <select id="modifDroit" name="modifDroit" class="form-select">
                            <option value="Adherent">Adherent</option>
                            <option value="Responsable">Responsable</option>
                            <option value="Super-Utilisateur">Super-Utilisateur</option>
                        </select>
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

    <!-- Modal de suppression d'un materiel -->
    <div class="modal fade" id="modalSupprimerAdherent{{ $user->id }}" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSupprimer">Supprimer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    Voulez-vous vraiment supprimer cet utilisateur ({{ $user->name }}) ?
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <!-- Lien pour supprimer l'adhérent -->
                    <a href="{{ url('/deleteUtilisateur/' . $user->id) }}" class="btn btn-primary">Confirmer</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                </div>
            </div>
        </div>
    </div>
@endforeach

<div class="modal fade" id="modalDeleteTousLesUtilisateurs" tabindex="-1" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Supprimer tous les utilisateurs ? </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="deleteAllUtilisateur" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Etes-vous certain de vouloir supprimer tous les
                            utilisateurs</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les utilisateurs ? Cette action est irréversible.')">
                        Supprimer tous les utilisateurs
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
