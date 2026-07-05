<!-- Modal Ajouter Assuré -->
<div class="modal fade" id="createPropositionModal" tabindex="-1" aria-labelledby="createPropositionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPropositionModalLabel">Ajouter un assuré(e)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Civilité <span class="text-danger">*</span></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="Madame">
                            <label class="form-check-label">Madame</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="Mademoiselle">
                            <label class="form-check-label">Mademoiselle</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input civiliteAssur" type="radio" name="civiliteAssur" value="Monsieur">
                            <label class="form-check-label">Monsieur</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Nom <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nomAssur" placeholder="Nom">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Prénom(s) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="prenomAssur" placeholder="Prénom(s)">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Date naissance <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="datenaissanceAssur">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lieu naissance</label>
                        <input type="text" class="form-control" id="lieunaissanceAssur" placeholder="Lieu naissance">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Nature de la pièce <span class="text-danger">*</span></label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="CNI">
                            <label class="form-check-label">CNI</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="AT">
                            <label class="form-check-label">Attestation</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="Passport">
                            <label class="form-check-label">Passeport</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input naturepieceAssur" type="radio" name="naturepieceAssur" value="AUTRE">
                            <label class="form-check-label">Autre</label>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">N° Pièce d'identité</label>
                        <input type="text" class="form-control" id="numeropieceAssur" placeholder="Numéro pièce">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lien de parenté <span class="text-danger">*</span></label>
                        <select class="form-select" id="lienParente">
                            <option value="">Sélectionner</option>
                            <option value="Conjoint">Conjoint(e)</option>
                            <option value="Enfant">Enfant</option>
                            <option value="Père">Père</option>
                            <option value="Mère">Mère</option>
                            <option value="Frère">Frère</option>
                            <option value="Sœur">Sœur</option>
                            <option value="Autre">Autre</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Lieu de résidence</label>
                        <input type="text" class="form-control" id="lieuresidenceAssur" placeholder="Lieu résidence">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Mobile</label>
                        <input type="tel" class="form-control" id="mobileAssur" placeholder="Mobile">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailAssur" placeholder="Email">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-primary" id="btn-ajouter-assure">Ajouter</button>
            </div>
        </div>
    </div>
</div>
