<!-- Auteur : Benjamin Crespeau -->


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{ asset('resources/css/header.css') }}">
    <meta charset="UTF-8">

    <!-- Inclure font-awesome -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <!-- Inclure jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Inclure Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.2.3/js/bootstrap.min.js"></script>

    <!-- Inclure DataTables.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

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

        .logout-btn {
            color: inherit;
            /* Utiliser la couleur de texte par défaut */
            text-decoration: none;
            /* Supprimer la soulignement */
            background-color: transparent;
            /* Fond transparent */
            border: none;
            /* Supprimer la bordure */
            padding: 0;
            /* Supprimer le remplissage */
            cursor: pointer;
            /* Afficher un curseur de type pointeur */
            outline: none;
            /* Supprimer la bordure de focus */
        }

        .logout-btn:hover {
            text-decoration: none;
            /* Ajouter un soulignement au survol */
        }

        /* Stylisation du menu déroulant pour le nombre d'entrées à afficher */
        .dataTables_length {
            margin-top: 2%;
            /* Espacement en bas du menu */
        }
        header, footer{
            background: linear-gradient(to bottom, #444444, #333333); /* Dégradé gris pour le header */
            padding: 15px 0; /* Espacement intérieur du header */
        }



    </style>

</head>

<body style="font-family: Lato, sans-serif;; background: linear-gradient(to bottom left, #ff7f00, #e9a44a, #e7dc40">

    <!-- Header -->
    <header class="p-3 text-white ">
        <div class="container">
            <div class="flex-wrap d-flex align-items-center justify-content-center justify-content-lg-start">
                <a href="#" class="mb-2 text-white d-flex align-items-center mb-lg-0 text-decoration-none">
                    <img src="images/logo.png" alt="Logo" width="90" height="40" class="me-2">
                </a>

                <ul class="mb-2 nav col-12 col-lg-auto me-lg-auto justify-content-center mb-md-0">
                    <li><a href="/" class="px-2 text-white nav-link lien">Accueil</a></li>
                    @auth
                        @if (auth()->user()->isSuperUtilisateurOrResponsable())
                            <li><a href="/adherent" class="px-2 text-white nav-link lien">Gestion des adhérents</a></li>
                            <li><a href="/historique" class="px-2 text-white nav-link lien">Historique</a></li>
                            @if (auth()->user()->isSuperUtilisateur())
                                <li><a href="/utilisateur" class="px-2 text-white nav-link lien">Gestion des
                                        utilisateurs</a></li>
                            @endif
                            <li><a href="/materiel" class="px-2 text-white nav-link lien">Gestion des materiels</a></li>
                        @endif
                    @endauth
                </ul>

                <div class="text-end">
                    <div class="text-end">
                        @auth
                            <!-- L'utilisateur est connecté, afficher le message de bienvenue -->
                            <p class="connexion">Bonjour {{ auth()->user()->name }}</p>
                            <form action="{{ route('logout') }}" method="post" class="connexion">
                                @csrf
                                <button type="submit" class=" no-style-link btn btn-link logout-btn">Se
                                    déconnecter</button>
                            </form>
                        @else
                            <!-- L'utilisateur n'est pas connecté, afficher les liens de connexion et d'enregistrement -->
                            <a href="{{ route('login') }}" class="connexion">Se connecter</a>
                            <a href="{{ route('register') }}" class="connexion">Créer son compte</a>
                        @endauth
                    </div>
                </div>
            </div>
    </header>


    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="p-3 text-white col-md-12" style="margin-top:3%;">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <a href="https://www.mdl-tw.fr/" target="_blank">
                        <img class="image" src="{{ asset('/images/logo.png') }}" style="width:33%">
                    </a>
                </div>
                <div class="col-sm-3">
                    <ul>
                        <li style="font-size: 80%;"><a href="/"
                                style="color: inherit; text-decoration: none;">Accueil</a></li>
                        @auth
                            @if (auth()->user()->isSuperUtilisateurOrResponsable())
                                <li style="font-size: 80%;"><a href="/adherent"
                                        style="color: inherit; text-decoration: none;">Gestion des adhérents</a></li>
                                <li style="font-size: 80%;"><a href="/historique"
                                        style="color: inherit; text-decoration: none;">Historique</a></li>
                                <li style="font-size: 80%;"><a href="/utilisateur"
                                        style="color: inherit; text-decoration: none;">Gestion des utilisateurs</a></li>
                                <li style="font-size: 80%;"><a href="/materiel"
                                        style="color: inherit; text-decoration: none;">Gestion des matériels</a></li>
                            @endif
                        @endauth
                    </ul>
                </div>
                <div class="col-sm-3">
                    <ul>
                        <a href="https://www.instagram.com/touchard_washington_mdl/" target="_blank">
                            <img class="image" src="{{ asset('/images/instagram.png') }}" style="width:12%">
                        </a>
                    </ul>
                </div>
                <div class="col-sm-3">
                    <ul>
                        <li style="font-size: 80%;"><a href="/confidentialite" style="color: inherit; text-decoration: none;">Politique de confidentialité</a></li>
                        <li style="font-size: 80%;"><a href="/conditions" style="color: inherit; text-decoration: none;">Conditions Générales d'Utilisation</a></li>
                        <li style="font-size: 80%;"><a href="/contact" style="color: inherit; text-decoration: none;">Nous contacter</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>

</body>

</html>
