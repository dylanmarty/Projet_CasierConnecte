   <!-- Fenêtre modale pour l'ajout d une famille -->

   <!-- The Modal -->
   <div class="modal" id="modalAJoutFamille">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ajout d'une famille de materiel</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <form action="addFamille" method="POST">
                <div class="modal-body">
                    @csrf
                    @if ($errors->has('nomFamille'))
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">nom de la famille de materiel</span>
                        <input id="nomFamille" name="nomFamille" type="nom" class="form-control"
                            placeholder="famille" value="{{ old('nomFamille') }}" />
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

<!-- Fenêtre modale pour l'ajout d un matériel -->

<!-- The Modal -->
<div class="modal" id="modalAJoutMateriel">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Ajout d'un materiel</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <!-- Modal body -->
            <form action="addMateriel" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @if (
                        $errors->has('nomMateriel') ||
                            $errors->has('imageMateriel') ||
                            $errors->has('duree') ||
                            $errors->has('familleMateriel'))
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endif
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">nom du materiel</span>
                        <input id="nom" name="nomMateriel" type="nomMateriel" class="form-control"
                            placeholder="nom" value="{{ old('nomMateriel') }}" />
                    </div>
                    <div class="form-group">
                        <label for="imageMateriel">Image du matériel</label>
                        <input type="file" class="form-control-file" id="imageMateriel" name="imageMateriel">
                    </div>
                    &emsp;
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">duree_emprunt</span>
                        <input id="duree" name="duree" type="nom" class="form-control"
                            placeholder="duree en h" value="{{ old('duree') }}" />
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">Ce matériel fait partie de la famille
                            :</span>
                        <select id="familleMateriel" name="familleMateriel" class="form-select">
                            <option value="-1">-- Choisissez une famille de matériel --</option>
                            @foreach ($Famille_materiel as $famille)
                                <option value="{{ $famille->id }}">{{ $famille->nom }}</option>
                            @endforeach
                        </select>

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

<!-- Modal Supprimer tout les Materiels -->
<div class="modal fade" id="modalDeleteToutLesMateriels" tabindex="-1" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Supprimer tous les materiels ? </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="deleteAllMateriel" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Etes-vous certain de vouloir supprimer tous les materiels</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les materiels ? Cette action est irréversible.')">
                        Supprimer tous les materiels
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Supprimer tout les Familles -->
<div class="modal fade" id="modalDeleteToutesLesFamilles" tabindex="-1" aria-labelledby="importModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Supprimer toutes les familles de materiels ainsi que
                    ses autres données associées ? </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <form action="deleteAllFamille" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Etes-vous certain de vouloir supprimer toutes les familles de
                            materiels ainsi que ses autres données associées</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer tous les famillesmateriels ? Cette action est irréversible.')">
                        Supprimer tous les familles ?
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal de message d'erreur Famille -->
<div class="modal fade" id="erreurModalFamille" tabindex="-1" aria-labelledby="erreurModalLabel"
    aria-hidden="true">
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
                    <div>Veuillez recommencer à modifier cet famille de materiel.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de message d'erreur Materiel -->
<div class="modal fade" id="erreurModalMateriel" tabindex="-1" aria-labelledby="erreurModalLabel"
    aria-hidden="true">
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
                    <div>Veuillez recommencer à modifier ce materiel.</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
