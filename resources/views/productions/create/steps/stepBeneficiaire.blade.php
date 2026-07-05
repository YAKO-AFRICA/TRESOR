<div id="test-l-3" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger3">

    @php
        $isLffun = ($product->CodeProduit == 'LFFUN');
    @endphp

    @if($isLffun)
        <!-- =================================================== -->
        <!-- INTERFACE LFFUN - BÉNÉFICIAIRES -->
        <!-- =================================================== -->
        <div class="lffun-benef-container">
            <h5 class="mb-1">Bénéficiaires - Assurance Funérailles</h5>
            <p class="mb-4 text-muted">
                Veuillez désigner le ou les bénéficiaires du contrat.
            </p>

            <!-- Bénéficiaire Désigné -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <i class="bx bx-user-check text-primary me-2"></i>
                    <strong>1. Bénéficiaire Désigné</strong>
                </div>
                <div class="card-body">
                    <div id="designated-benef-list"></div>
                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-designated-btn">
                        <i class="bx bx-plus"></i> Ajouter un bénéficiaire désigné
                    </button>
                </div>
            </div>

            <!-- Bénéficiaire par défaut (Employeur) -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-light border-bottom">
                    <i class="bx bx-building text-secondary me-2"></i>
                    <strong>2. Bénéficiaire par défaut</strong>
                </div>
                <div class="card-body">
                    <div id="default-benef-list"></div>
                    <div class="alert alert-info mt-2 small">
                        <i class="bx bx-info-circle"></i>
                        En l'absence de bénéficiaire désigné, le capital sera versé à l'employeur.
                    </div>
                </div>
            </div>

            <input type="hidden" id="lffun_beneficiaires_data" name="lffun_beneficiaires_data">

            <!-- Boutons navigation -->
            <div class="d-flex align-items-center justify-content-between gap-3 mt-4 pt-3 border-top">
                <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn btn-previous-form">
                    <i class='bx bx-left-arrow-alt'></i> Précédent
                </button>
                <button onclick="event.preventDefault(); validateLffunBenefAndNext()" class="btn btn-two btn-next-form">
                    Suivant <i class='bx bx-right-arrow-alt'></i>
                </button>
            </div>
        </div>

        <style>
            .lffun-benef-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 12px;
                border-bottom: 1px solid #f0f0f0;
                transition: background 0.2s;
            }
            .lffun-benef-row:hover {
                background: #fafbfc;
            }
            .lffun-benef-row:last-child {
                border-bottom: none;
            }
            .lffun-benef-info {
                flex: 1;
            }
            .lffun-benef-name {
                font-weight: 600;
                font-size: 15px;
                color: #2c3e50;
            }
            .lffun-benef-details {
                font-size: 12px;
                color: #8a9aa8;
                margin-top: 4px;
            }
            .lffun-benef-badge {
                background: #eef2f7;
                padding: 4px 10px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 500;
                color: #2c7da0;
            }
            .lffun-benef-edit-btn, .lffun-benef-delete-btn {
                cursor: pointer;
                padding: 5px;
                margin-left: 8px;
                transition: all 0.2s;
                font-size: 16px;
                color: #8a9aa8;
            }
            .lffun-benef-edit-btn:hover {
                color: #3498db;
                transform: scale(1.05);
            }
            .lffun-benef-delete-btn:hover {
                color: #e74c3c;
                transform: scale(1.05);
            }
            .lffun-empty-message {
                color: #b0bec5;
                font-style: italic;
                padding: 15px;
                text-align: center;
                font-size: 13px;
            }
        </style>

        <!-- Modal Ajout/Édition Bénéficiaire Désigné -->
        <div class="modal fade" id="lffunBenefModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-light border-bottom">
                        <h5 class="modal-title"><i class="bx bx-user-plus text-primary me-2"></i> <span id="lffunBenefModalTitle">Ajouter un bénéficiaire</span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="lffun_benef_edit_index">

                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Nom et prénoms <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lffun_benef_nom" placeholder="Nom et prénoms">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Lien avec l'adhérent <span class="text-danger">*</span></label>
                                <select class="form-select" id="lffun_benef_lien">
                                    <option value="">Sélectionner</option>
                                    <option value="Conjoint">Conjoint(e)</option>
                                    <option value="Enfant">Enfant</option>
                                    <option value="Père">Père</option>
                                    <option value="Mère">Mère</option>
                                    <option value="Frère">Frère</option>
                                    <option value="Sœur">Sœur</option>
                                    <option value="Oncle">Oncle</option>
                                    <option value="Tante">Tante</option>
                                    <option value="Cousin">Cousin</option>
                                    <option value="Autre">Autre</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="lffun_benef_telephone" placeholder="Téléphone">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="lffun_benef_adresse" placeholder="Adresse complète">
                            </div>
                            <div class="col-12">
                                <label class="form-label">Taux (%)</label>
                                <input type="number" class="form-control" id="lffun_benef_taux" placeholder="100" value="100" min="1" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" id="lffun_save_benef">Enregistrer</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        (function() {
            if (window.lffunBenefModuleInitialized) return;
            window.lffunBenefModuleInitialized = true;

            document.addEventListener('DOMContentLoaded', initLffunBenefModule);

            // Notification SweetAlert
            function showToast(icon, title, message = '') {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: icon,
                        title: title,
                        text: message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                } else {
                    alert(title + (message ? ': ' + message : ''));
                }
            }

            function initLffunBenefModule() {
                console.log('✅ Module LFFUN Bénéficiaires chargé');

                function getEmployeurInfo() {

                    // Valeur par défaut
                    employeurNom = 'Fond du Trésor Public';
                    employeurAdresse = 'Abidjan, Côte d\'Ivoire';


                    return {
                        nom: employeurNom,
                        lien: 'Employeur',
                        telephone: '',
                        adresse: employeurAdresse,
                        taux: 100,
                        type: 'default'
                    };
                }

                // Structure des données
                let beneficiaries = {
                    designated: [],  // Bénéficiaires désignés
                    default: getEmployeurInfo()  // Bénéficiaire par défaut (employeur)
                };

                // Récupérer les données existantes
                const simulationData = JSON.parse(sessionStorage.getItem('simulationData') || '{}');
                if (simulationData.beneficiaires) {
                    if (simulationData.beneficiaires.designated) beneficiaries.designated = simulationData.beneficiaires.designated;
                    if (simulationData.beneficiaires.default) beneficiaries.default = simulationData.beneficiaires.default;
                }

                // Sauvegarde en session
                function saveToSession() {
                    const current = JSON.parse(sessionStorage.getItem('simulationData') || '{}');
                    current.beneficiaires = {
                        designated: beneficiaries.designated,
                        default: beneficiaries.default
                    };
                    sessionStorage.setItem('simulationData', JSON.stringify(current));

                    const hiddenInput = document.getElementById('lffun_beneficiaires_data');
                    if (hiddenInput) {
                        hiddenInput.value = JSON.stringify(current.beneficiaires);
                    }
                    console.log('💾 Bénéficiaires sauvegardés');
                }

                // Rendu d'une ligne bénéficiaire
                function renderBenefRow(benef, index, type) {
                    const displayName = benef.nom || 'Non renseigné';
                    const lien = benef.lien || '';
                    const telephone = benef.telephone || '';
                    const adresse = benef.adresse || '';
                    const taux = benef.taux || 100;

                    return `
                        <div class="lffun-benef-row" data-type="${type}" data-index="${index}">
                            <div class="lffun-benef-info">
                                <div class="lffun-benef-name">
                                    ${escapeHtml(displayName)}
                                    <span class="lffun-benef-badge ms-2">${taux}%</span>
                                </div>
                                <div class="lffun-benef-details">
                                    ${lien ? `<i class="bx bx-link"></i> ${escapeHtml(lien)}` : ''}
                                    ${telephone ? ` | <i class="bx bx-phone"></i> ${escapeHtml(telephone)}` : ''}
                                    ${adresse ? ` | <i class="bx bx-map"></i> ${escapeHtml(adresse)}` : ''}
                                </div>
                            </div>
                            <div class="d-flex align-items-center">
                                ${type === 'designated' ? `
                                    <i class="bx bx-edit lffun-benef-edit-btn" onclick="window.lffunOpenBenefModal(${index})"></i>
                                    <i class="bx bx-trash lffun-benef-delete-btn" onclick="window.lffunDeleteBenef(${index})"></i>
                                ` : ''}
                            </div>
                        </div>
                    `;
                }

                function escapeHtml(str) {
                    if (!str) return '';
                    return String(str).replace(/[&<>]/g, function(m) {
                        if (m === '&') return '&amp;';
                        if (m === '<') return '&lt;';
                        if (m === '>') return '&gt;';
                        return m;
                    });
                }

                // Rendu des listes
                function renderDesignatedList() {
                    const container = document.getElementById('designated-benef-list');
                    if (!container) return;

                    if (beneficiaries.designated.length === 0) {
                        container.innerHTML = '<div class="lffun-empty-message"><i class="bx bx-user"></i> Aucun bénéficiaire désigné</div>';
                        return;
                    }

                    container.innerHTML = '';
                    beneficiaries.designated.forEach((benef, idx) => {
                        container.innerHTML += renderBenefRow(benef, idx, 'designated');
                    });
                }

                function renderDefaultList() {
                    const container = document.getElementById('default-benef-list');
                    if (!container) return;
                    container.innerHTML = renderBenefRow(beneficiaries.default, 0, 'default');
                }

                function renderAll() {
                    renderDesignatedList();
                    renderDefaultList();
                }

                // Ajout d'un bénéficiaire désigné
                function addDesignatedBenef(data) {
                    beneficiaries.designated.push({
                        nom: data.nom,
                        lien: data.lien,
                        telephone: data.telephone,
                        adresse: data.adresse,
                        taux: data.taux || 100,
                        type: 'designated'
                    });
                    renderAll();
                    saveToSession();
                    showToast('success', 'Ajouté', 'Bénéficiaire désigné ajouté');
                }

                // Modification d'un bénéficiaire désigné
                function updateDesignatedBenef(index, data) {
                    beneficiaries.designated[index] = {
                        ...beneficiaries.designated[index],
                        nom: data.nom,
                        lien: data.lien,
                        telephone: data.telephone,
                        adresse: data.adresse,
                        taux: data.taux || 100
                    };
                    renderAll();
                    saveToSession();
                    showToast('success', 'Modifié', 'Bénéficiaire modifié');
                }

                // Suppression d'un bénéficiaire désigné
                window.lffunDeleteBenef = function(index) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Confirmation',
                            text: 'Supprimer ce bénéficiaire ?',
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Oui, supprimer',
                            cancelButtonText: 'Annuler'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                beneficiaries.designated.splice(index, 1);
                                renderAll();
                                saveToSession();
                                showToast('success', 'Supprimé', 'Bénéficiaire supprimé');
                            }
                        });
                    } else {
                        if (confirm('Supprimer ce bénéficiaire ?')) {
                            beneficiaries.designated.splice(index, 1);
                            renderAll();
                            saveToSession();
                        }
                    }
                };

                // Ouverture du modal pour ajout/édition
                window.lffunOpenBenefModal = function(index = null) {
                    const isEdit = index !== null;
                    const modalTitle = document.getElementById('lffunBenefModalTitle');
                    const editIndexInput = document.getElementById('lffun_benef_edit_index');

                    if (isEdit) {
                        modalTitle.textContent = 'Modifier le bénéficiaire';
                        editIndexInput.value = index;

                        const benef = beneficiaries.designated[index];
                        document.getElementById('lffun_benef_nom').value = benef.nom || '';
                        document.getElementById('lffun_benef_lien').value = benef.lien || '';
                        document.getElementById('lffun_benef_telephone').value = benef.telephone || '';
                        document.getElementById('lffun_benef_adresse').value = benef.adresse || '';
                        document.getElementById('lffun_benef_taux').value = benef.taux || 100;
                    } else {
                        modalTitle.textContent = 'Ajouter un bénéficiaire';
                        editIndexInput.value = '';
                        document.getElementById('lffun_benef_nom').value = '';
                        document.getElementById('lffun_benef_lien').value = '';
                        document.getElementById('lffun_benef_telephone').value = '';
                        document.getElementById('lffun_benef_adresse').value = '';
                        document.getElementById('lffun_benef_taux').value = 100;
                    }

                    const modal = new bootstrap.Modal(document.getElementById('lffunBenefModal'));
                    modal.show();
                };

                // Sauvegarde depuis le modal
                document.getElementById('lffun_save_benef')?.addEventListener('click', function() {
                    const nom = document.getElementById('lffun_benef_nom').value.trim();
                    const lien = document.getElementById('lffun_benef_lien').value;
                    const telephone = document.getElementById('lffun_benef_telephone').value;
                    const adresse = document.getElementById('lffun_benef_adresse').value;
                    const taux = parseInt(document.getElementById('lffun_benef_taux').value) || 100;

                    if (!nom) {
                        showToast('error', 'Champ requis', 'Veuillez renseigner le nom du bénéficiaire');
                        document.getElementById('lffun_benef_nom').focus();
                        return;
                    }

                    if (!lien) {
                        showToast('error', 'Champ requis', 'Veuillez sélectionner le lien avec l\'adhérent');
                        document.getElementById('lffun_benef_lien').focus();
                        return;
                    }

                    const editIndex = document.getElementById('lffun_benef_edit_index').value;
                    const data = { nom, lien, telephone, adresse, taux };

                    if (editIndex !== '') {
                        updateDesignatedBenef(parseInt(editIndex), data);
                    } else {
                        addDesignatedBenef(data);
                    }

                    const modal = bootstrap.Modal.getInstance(document.getElementById('lffunBenefModal'));
                    modal.hide();
                });

                // Validation avant next
                window.validateLffunBenefAndNext = function() {
                    // Vérifier qu'il y a au moins un bénéficiaire désigné ou que le default est présent
                    if (beneficiaries.designated.length === 0) {
                        showToast('warning', 'Attention', 'Aucun bénéficiaire désigné. En cas de décès, le capital sera versé à l\'employeur.');
                        // On continue quand même, c'est juste un avertissement
                    }

                    // Vérifier que le total des taux des bénéficiaires désignés ne dépasse pas 100%
                    const totalTaux = beneficiaries.designated.reduce((sum, b) => sum + (b.taux || 0), 0);
                    if (totalTaux > 100) {
                        showToast('error', 'Erreur', 'Le total des taux des bénéficiaires ne peut pas dépasser 100%');
                        return;
                    }

                    saveToSession();
                    if (typeof stepper1 !== 'undefined') {
                        stepper1.next();
                    }
                };

                // Bouton ajout bénéficiaire désigné
                document.getElementById('add-designated-btn')?.addEventListener('click', function() {
                    window.lffunOpenBenefModal();
                });

                renderAll();
                saveToSession();
            }
        })();
        </script>

    @else
        <!-- Interface standard pour les autres produits -->
        <h5 class="mb-1">Informations du ou des bénéficiaire(s)</h5>
        <p class="mb-4">Veuillez entrer les informations relatives au(x) bénéficiaire(s) en tenant compte des champs
            obligatoires.</p>

        <div class="row g-3">

            @if ($product->CodeProduit == 'YKE_2018' || $product->CodeProduit == 'YKE_2008')
                <div class="col-12 col-lg-6">
                    <label for="" class="form-label">Au terme du contrat</label>
                    <div class="card" style="width: 80%">
                        <div class="card-body">
                            <small>
                                Pas de beneficiaire au terme du contrat pour ce produit
                            </small>
                        </div>
                    </div>
                </div>
            @elseif ($product->CodeProduit == 'DOIHOO')
                <div class="col-12 col-lg-6">
                    <label for="" class="form-label">Au terme du contrat</label>
                    <div class="card" style="width: 80%">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="addBeneficiary" value="adherent" name="benef_terme" checked readonly>
                                <label class="form-check-label" for="addBeneficiary">Adhérent</label>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <label class="form-label">Au terme du contrat</label>

                            <div class="form-check">
                                <input type="radio" name="benef_terme" value="adherent" class="form-check-input">
                                <label class="form-check-label">Adhérent</label>
                            </div>

                            <div class="form-check">
                                <input type="radio" name="benef_terme" value="conjoint" class="form-check-input">
                                <label class="form-check-label">Conjoint</label>
                            </div>

                            <div class="form-check">
                                <input type="radio" name="benef_terme" value="enfants" class="form-check-input">
                                <label class="form-check-label">Enfants</label>
                            </div>

                            <div class="form-check">
                                <input type="radio" name="benef_terme" value="autre" class="form-check-input">
                                <label class="form-check-label">Autre</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="col-12 col-lg-6">
                <label for="" class="form-label">En cas de décès avant le terme</label>
                <div class="card" style="width: 80%">
                    <div class="card-body">
                        <div class="form-check">
                            <input type="radio" name="benef_deces" value="conjoint">
                            <label class="form-check-label">Le conjoint non divorcé, ni séparé de corps</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" name="benef_deces" value="enfants">
                            <label class="form-check-label">Les enfants nés et à naître</label>
                        </div>
                        <div class="form-check" data-bs-toggle="modal" data-bs-target="#addBenefModal">
                            <input type="radio" name="benef_deces" value="autre">
                            <label class="form-check-label">Autres, à préciser</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="card">
                <div class="card-body overflow-auto">
                    <table class="table mb-0 table-striped" id="beneficiariesTable">
                        <thead>
                            <tr>
                                <th scope="col">Nom & Prénoms</th>
                                <th scope="col">Né(e) le</th>
                                <th scope="col">Lieu de naissance</th>
                                <th scope="col">Lieu de résidence</th>
                                <th scope="col">Filiation</th>
                                <th scope="col">Téléphone</th>
                                <th scope="col">Email</th>
                                <th scope="col">Taux (%)</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn btn-previous-form">
                    <i class='bx bx-left-arrow-alt'></i>Précédent
                </button>
                <button onclick="event.preventDefault(); stepper1.next()" class="btn btn-two btn-next-form">
                    Suivant<i class='bx bx-right-arrow-alt'></i>
                </button>
            </div>
        </div>

        <!-- Modal pour ajouter bénéficiaire -->
        <div class="modal fade" id="addBenefModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Ajouter un bénéficiaire</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="benefContexte">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label>Nom <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nomBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Prénom(s) <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="prenomBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Date naissance</label>
                                <input type="date" class="form-control" id="datenaissanceBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Lieu naissance</label>
                                <input type="text" class="form-control" id="lieunaissanceBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Lieu résidence</label>
                                <input type="text" class="form-control" id="lieuresidenceBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Lien de parenté</label>
                                <select class="form-select" id="lienParenteBenef">
                                    <option value="">Sélectionner</option>
                                    <option value="Conjoint">Conjoint(e)</option>
                                    <option value="Enfant">Enfant</option>
                                    <option value="Père">Père</option>
                                    <option value="Mère">Mère</option>
                                    <option value="Frère">Frère</option>
                                    <option value="Sœur">Sœur</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Téléphone <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control" id="mobileBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" id="emailBenef">
                            </div>
                            <div class="col-md-6">
                                <label>Taux (%)</label>
                                <input type="number" class="form-control" id="partBenef" value="100" min="1" max="100">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                        <button type="button" class="btn btn-primary" onclick="addBeneficiary()">Ajouter</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
        let beneficiaries = [];

        function getAdherentInfos() {
            return {
                nom: document.getElementById('FisrtName')?.value || '',
                prenom: document.getElementById('LastName')?.value || '',
                dateNaissance: document.getElementById('Date_naissance')?.value || '',
                lieuNaissance: document.getElementById('lieunaissance')?.value || '',
                lieuResidence: document.getElementById('lieuresidence')?.value || '',
                telephone: document.querySelector('input[name="mobile"]')?.value || '',
                email: document.getElementById('email')?.value || ''
            };
        }

        function resetContexte(contexte) {
            beneficiaries = beneficiaries.filter(b => b.contexte !== contexte);
        }

        function updateHiddenInput() {
            document.getElementById('beneficiariesInput').value = JSON.stringify(beneficiaries);
        }

        function renderTable() {
            const tbody = document.querySelector('#beneficiariesTable tbody');
            if (!tbody) return;
            tbody.innerHTML = '';

            beneficiaries.forEach((b, index) => {
                const badge = b.contexte === 'terme'
                    ? '<span class="badge bg-success">Terme</span>'
                    : '<span class="badge bg-danger">Décès</span>';

                const row = `
                    <tr>
                        <td>${b.nom} ${b.prenom}</td>
                        <td>${b.dateNaissance || ''}</td>
                        <td>${b.lieuNaissance || ''}</td>
                        <td>${b.lieuResidence || ''}</td>
                        <td>${b.lien}</td>
                        <td>${b.telephone || ''}</td>
                        <td>${b.email || ''}</td>
                        <td>${b.part}%</td>
                        <td>${badge}</td>
                        <td>
                            <a href="#" class="text-danger" onclick="removeBeneficiary(${index})">
                                <i class="bx bx-x fs-4"></i>
                            </a>
                        </td>
                    </tr>
                `;
                tbody.insertAdjacentHTML('beforeend', row);
            });

            updateHiddenInput();
        }

        function setAutoBeneficiary(type, contexte) {
            let benef = {};

            if (type === 'adherent') {
                const a = getAdherentInfos();
                if (!a.nom || !a.prenom) {
                    alert("Veuillez renseigner l'adhérent avant");
                    return;
                }
                benef = { ...a, lien: 'Adhérent', part: 100, contexte };
            }

            if (type === 'conjoint') {
                benef = { nom: 'Conjoint', prenom: 'Non séparé de corps', lien: 'Conjoint', part: 100, contexte };
            }

            if (type === 'enfants') {
                benef = { nom: 'Enfants', prenom: 'Nés et à naître', lien: 'Enfants', part: 100, contexte };
            }

            resetContexte(contexte);
            beneficiaries.push(benef);
            renderTable();
        }

        function removeBeneficiary(index) {
            beneficiaries.splice(index, 1);
            renderTable();
        }

        function openModal(contexte) {
            document.getElementById('benefContexte').value = contexte;
            new bootstrap.Modal(document.getElementById('addBenefModal')).show();
        }

        function validateField(el) {
            if (!el.value.trim()) {
                el.classList.add('is-invalid');
                return false;
            }
            el.classList.remove('is-invalid');
            el.classList.add('is-valid');
            return true;
        }

        function addBeneficiary() {
            const contexte = document.getElementById('benefContexte').value;
            const nom = document.getElementById('nomBenef');
            const prenom = document.getElementById('prenomBenef');
            const tel = document.getElementById('mobileBenef');

            if (!validateField(nom) || !validateField(prenom) || !validateField(tel)) return;

            const benef = {
                nom: nom.value,
                prenom: prenom.value,
                dateNaissance: document.getElementById('datenaissanceBenef').value,
                lieuNaissance: document.getElementById('lieunaissanceBenef').value,
                lieuResidence: document.getElementById('lieuresidenceBenef').value,
                lien: document.getElementById('lienParenteBenef').selectedOptions[0]?.text || 'Autre',
                telephone: tel.value,
                email: document.getElementById('emailBenef').value,
                part: document.getElementById('partBenef').value || 100,
                contexte
            };

            resetContexte(contexte);
            beneficiaries.push(benef);
            renderTable();

            document.getElementById('beneficiaryForm')?.reset();
            bootstrap.Modal.getInstance(document.getElementById('addBenefModal')).hide();
        }

        function initEvents() {
            document.querySelectorAll('input[name="benef_terme"]').forEach(el => {
                el.addEventListener('change', function() {
                    if (this.value === 'autre') {
                        openModal('terme');
                        return;
                    }
                    setAutoBeneficiary(this.value, 'terme');
                });
            });

            document.querySelectorAll('input[name="benef_deces"]').forEach(el => {
                el.addEventListener('change', function() {
                    if (this.value === 'autre') {
                        openModal('deces');
                        return;
                    }
                    setAutoBeneficiary(this.value, 'deces');
                });
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            initEvents();
        });
        </script>
    @endif
</div>
