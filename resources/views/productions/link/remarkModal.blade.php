<div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="remarkModalLabel">
                    <i class="bi bi-exclamation-triangle text-danger"></i> Signaler une incohérence
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body">
                <form id="remarkForm">
                    <div class="mb-3">
                        <label for="remarkText" class="form-label">
                            Décrivez clairement l'anomalie rencontrée (listé par des tirets) <span class="text-danger">*</span>
                        </label>
                        <textarea
                            class="form-control"
                            id="remarkText"
                            name="remark"
                            rows="6"
                            placeholder="Exemple :
                            - L'âge de l'enfant est incorrect
                            - Le numéro de téléphone est incorrect"
                            required
                        >{{ $contrat->details ?? '' }}</textarea>
                        <div class="invalid-feedback">
                            Veuillez décrire l'incohérence avant de valider.
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <button type="button" class="btn btn-danger" id="btnSubmitRemark">
                    <i class="bi bi-send"></i> Envoyer le signalement
                </button>
            </div>
        </div>
    </div>
</div>
