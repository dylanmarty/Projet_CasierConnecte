    <!-- Fenêtre modale pour l'ajout d'adhérent -->

    <!-- The Modal -->
    <div class="modal" id="modalAJoutAdherent">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Ajout d'un adherent</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <!-- Modal body -->
                <form action="addAdherent" method="POST">
                    <div class="modal-body">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Nom</span>
                            <input id="nom" name="nom" type="nom" class="form-control" placeholder="Nom"
                            pattern="^[^\d]+$" required/>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Prenom</span>
                            <input id="prenom" name="prenom" type="nom" class="form-control"
                                placeholder="Prenom" pattern="^[^\d]+$" required />
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Classe</span>
                            <input id="classe" name="classe" type="nom" class="form-control"
                                placeholder="Classe"  required/>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">date de naissance</span>
                            <input id="naissance" name="naissance" type="nom" class="form-control"
                                placeholder="date de naissance format xx/xx/xxxx"
                                pattern="^\d{2}\/\d{2}\/\d{4}$" required />
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">Numero de telephone</span>
                            <input id="numTelephone" name="numTelephone" type="nom" class="form-control"
                                placeholder="Numero de telephone (10 chiffres)"pattern="^\d{10}$" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">numero de badge</span>
                            <input id="numBadge" name="numBadge" type="nom" class="form-control"
                                placeholder="numero de badge " pattern="^\d+$" required >
                        </div>

                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary" id="btnAjouterAdherent">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de message d'erreur de la modification d'un adherent-->
    <div class="modal fade" id="erreurModal" tabindex="-1" aria-labelledby="erreurModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="erreurModalLabel">Erreur de modification</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <div>Veuillez recommencer à modifier cet adhérent.</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

     <!-- Modal de message d'erreur importation-->
     <div class="modal fade" id="erreurModalImportation" tabindex="-1" aria-labelledby="erreurModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="erreurModalLabel">Erreur d'importation adherent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <div>Veuillez recommencer à importer votre liste d'adherent</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal d'importation -->
    <div class="modal fade" id="modalImporterAdherent" tabindex="-1" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Importer des adhérents depuis un fichier CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form action="importAdherent" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Sélectionner un fichier CSV :</label>
                            <input class="form-control" type="file" id="csvFile" name="csvFile" accept=".csv" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-primary">Importer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Supprimer tout les adherent -->
    <div class="modal fade" id="modalDeleteTousLesAdherent" tabindex="-1" aria-labelledby="importModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Supprimer tous les adherents ? </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form action="deleteAllAdherent" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Etes-vous certain de vouloir supprimer tous les adherents</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="submit" class="btn btn-danger"
                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les adhérents ? Cette action est irréversible.')">
                            Supprimer tous les adhérents
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
