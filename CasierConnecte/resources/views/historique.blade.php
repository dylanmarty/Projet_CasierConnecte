@section('title', 'Historique') <!-- Définition du titre de la page -->

@extends('base') <!-- Utilisation du layout de base -->

@section('content') <!-- Contenu de la section 'content' -->

<head>
    <!-- Définition de l'en-tête de la page -->
    <title>Visualisation des casiers</title> <!-- Titre de la page -->

    <!-- Inclusion de l'icône de la page -->
    <link rel="icon" type="image/png" href="images/logo.png">

    <!-- Styles CSS pour le contenu -->
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
            margin-bottom: 5%;
            margin-top: 5%;
        }

        .dataTables_length {
            margin-top: 2%;
        }

    </style>
</head>

<body style="font-family: Lato, sans-serif; background: linear-gradient(to bottom left, #ff7f00, #e9a44a, #e7dc40"> <!-- Corps de la page -->

    @auth <!-- Vérification de l'authentification de l'utilisateur -->
    @if (auth()->user()->isSuperUtilisateurOrResponsable()) <!-- Vérification si l'utilisateur est un super-utilisateur -->
    <!-- Contenu si l'utilisateur est un super-utilisateur -->
    <h1 class="text-light" style="text-align: center; margin-top:4%;margin-bottom:2%;"> Visualisation de l'historique </h1>
    <h5 class="text-center text-light">Ici, nous pouvons voir la liste de tous les emprunts</h5>
    <h5 class="text-center text-light">Vous avez également la possibilité d'envoyer un SMS à un utilisateur en particulier pour toutes demandes</h5>
    <div class="container bg-light" style="margin-top:3%;margin-bottom:10%;;border:solid black 1px;">
        <table class="bg-light" id="adherentsTable">
            <thead>
                <tr>
                    <th class="bg-light">Nom</th>
                    <th class="bg-light">Prenom</th>
                    <th class="bg-light">Classe</th>
                    <th class="bg-light">Matériel</th>
                    <th class="bg-light">Date emprunt</th>
                    <th class="bg-light">Date retour</th>
                    <th class="bg-light">Date limite</th>
                    <th class="bg-light">SMS</th>
                </tr>
            </thead>
            <tbody>
                <!-- Affichage des emprunts -->
                @foreach ($emprunts as $emprunt)
                <tr>
                    <td>{{ $emprunt->adherent->nom }}</td>
                    <td>{{ $emprunt->adherent->prenom }}</td>
                    <td>{{ $emprunt->adherent->classe }}</td>
                    <td>{{ $emprunt->materiel->nom }}</td>
                    <td>{{ $emprunt->date_emprunt }}</td>
                    <td>{{ $emprunt->date_retour }}</td>
                    <td>{{ $emprunt->date_limite }}</td>
                    <td><img src="{{ asset('images/SMS.png') }}" class="sms-image" data-target="#exampleModal{{ $emprunt->id }}" style="cursor: pointer; width: 30px; height: 30px;"></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Script pour gérer l'ouverture du modal -->
        <script>
            $('.sms-image').on('click', function() {
                var modalId = $(this).data('target');
                $(modalId).modal('show');
            });
        </script>

        <!-- Script pour initialiser DataTable -->
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
    </div>
    @else
    <!-- Contenu si l'utilisateur n'est pas un super-utilisateur -->
    <h3 class="text-center text-light" style="margin-top:10%;">Privilèges insuffisants</h3>
    <h4 class="text-center text-light" style="margin-top:10%;margin-bottom:6%;">Vous n'êtes pas connecté, vous n'avez donc pas accès au reste du site, veuillez retourner vers la page d'accueil</h4>
    @endif
    @endauth

    <!-- Modaux pour envoyer des SMS -->
    @foreach ($emprunts as $emprunt)
    <div class="modal" id="exampleModal{{ $emprunt->id }}">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Envoyer un SMS</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('envoyer-message') }}" method="POST">
                    @csrf
                    <input type="hidden" name="empruntId" value="{{ $emprunt->id }}">
                    <div class="modal-body">
                        <p>Numéro de téléphone : {{ $emprunt->adherent->num_telephone }}</p>
                        <div class="form-group">
                            <label for="smsContent">Contenu du SMS :</label>
                            <textarea class="form-control" id="smsContent" name="message" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Envoyer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

</body>

@endsection <!-- Fin de la section 'content' -->
