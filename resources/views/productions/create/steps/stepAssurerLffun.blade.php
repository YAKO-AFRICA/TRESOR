<div id="test-l-2" role="tabpanel" class="bs-stepper-pane" aria-labelledby="stepper1trigger2">

    <div class="lffun-container">
        <h5 class="mb-1">Informations des assurés - Assurance Funérailles</h5>
        <p class="mb-4 text-muted">
            Veuillez renseigner les informations de l'assuré principal, du conjoint (optionnel),
            des enfants (max 4) et des ascendants (max 2).
        </p>

        <!-- Alerte des capitaux avec couleur selon formule -->
        <div id="lffun-capitals-alert" class="alert mb-4"></div>

        <!-- Liste des assurés par groupe -->
        <div class="row">
            <div class="col-12">
                <!-- Assuré Principal -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light border-bottom">
                        <i class="bx bx-user-circle me-2"></i>
                        <strong>Assuré Principal</strong>
                    </div>
                    <div class="card-body">
                        <div id="principal-list"></div>
                    </div>
                </div>

                <!-- Conjoint -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <span><i class="bx bx-heart text-danger me-2"></i> <strong>Conjoint(e)</strong></span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="lffun-add-conjoint-btn">
                            <i class="bx bx-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="conjoint-list"></div>
                    </div>
                </div>

                <!-- Enfants -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <span><i class="bx bx-baby-carriage text-info me-2"></i> <strong>Enfants (maximum 4)</strong></span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="lffun-add-enfant-btn">
                            <i class="bx bx-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="enfants-list"></div>
                    </div>
                </div>

                <!-- Ascendants -->
                <div class="card mb-3 shadow-sm">
                    <div class="card-header bg-light border-bottom d-flex justify-content-between align-items-center">
                        <span><i class="bx bx-user text-success me-2"></i> <strong>Ascendants (maximum 2)</strong></span>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="lffun-add-ascendant-btn">
                            <i class="bx bx-plus"></i> Ajouter
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="ascendants-list"></div>
                    </div>
                </div>

                <input type="hidden" id="lffun_assures_data" name="lffun_assures_data">

                <!-- Boutons navigation -->
                <div class="d-flex align-items-center justify-content-between gap-3 mt-4 pt-3 border-top">
                    <button onclick="event.preventDefault(); stepper1.previous()" class="btn border-btn btn-previous-form">
                        <i class='bx bx-left-arrow-alt'></i> Précédent
                    </button>
                    <button onclick="event.preventDefault(); validateLffunAndNext()" class="btn btn-two btn-next-form">
                        Suivant <i class='bx bx-right-arrow-alt'></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Styles des alertes selon la formule */
        .lffun-alert-std {
            background: linear-gradient(135deg, #185FA5 0%, #1a6bb5 100%);
            color: white;
            border: none;
        }
        .lffun-alert-ser {
            background: linear-gradient(135deg, #BA7517 0%, #d4881c 100%);
            color: white;
            border: none;
        }
        .lffun-alert-prem {
            background: linear-gradient(135deg, #3B6D11 0%, #4a8a16 100%);
            color: white;
            border: none;
        }
        .lffun-alert-std .badge, .lffun-alert-ser .badge, .lffun-alert-prem .badge {
            background: rgba(255,255,255,0.2);
            color: white;
        }

        .lffun-person-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s;
        }
        .lffun-person-row:hover {
            background: #fafbfc;
        }
        .lffun-person-row:last-child {
            border-bottom: none;
        }
        .lffun-person-info {
            flex: 1;
        }
        .lffun-person-name {
            font-weight: 600;
            font-size: 15px;
            color: #2c3e50;
        }
        .lffun-person-details {
            font-size: 12px;
            color: #8a9aa8;
            margin-top: 4px;
        }
        .lffun-person-capital {
            background: #eef2f7;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            color: #2c7da0;
        }
        .lffun-edit-btn, .lffun-delete-btn {
            cursor: pointer;
            padding: 5px;
            margin-left: 8px;
            transition: all 0.2s;
            font-size: 16px;
            color: #8a9aa8;
        }
        .lffun-edit-btn:hover {
            color: #3498db;
            transform: scale(1.05);
        }
        .lffun-delete-btn:hover {
            color: #e74c3c;
            transform: scale(1.05);
        }
        .lffun-empty-message {
            color: #b0bec5;
            font-style: italic;
            padding: 20px;
            text-align: center;
            font-size: 13px;
        }
        .lffun-badge-souscripteur {
            background: #eef2f7;
            color: #5a6c7e;
            font-size: 10px;
            font-weight: normal;
            padding: 3px 8px;
            margin-left: 8px;
            border-radius: 12px;
        }
    </style>

    <!-- Modal Édition Assuré -->
    <div class="modal fade" id="lffunEditModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light border-bottom">
                    <h5 class="modal-title"><i class="bx bx-edit text-secondary me-2"></i> Modifier l'assuré</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="lffun_edit_type">
                    <input type="hidden" id="lffun_edit_index">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Nom <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lffun_edit_nom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Prénom(s) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="lffun_edit_prenom">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date naissance</label>
                            <input type="date" class="form-control" id="lffun_edit_ddn">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lieu naissance</label>
                            <input type="text" class="form-control" id="lffun_edit_lieu_naissance" placeholder="Lieu de naissance">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lien de parenté</label>
                            <input type="text" class="form-control" id="lffun_edit_lien" placeholder="ex: Époux, Fils, Père...">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="lffun_edit_telephone" placeholder="Téléphone">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="lffun_edit_email" placeholder="Email">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">N° Pièce d'identité</label>
                            <input type="text" class="form-control" id="lffun_edit_piece" placeholder="Numéro pièce">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="button" class="btn btn-primary" id="lffun_save_edit">Enregistrer</button>
                </div>
            </div>
        </div>
    </div>

    <script>
    (function() {
        if (window.lffunModuleInitialized) return;
        window.lffunModuleInitialized = true;

        document.addEventListener('DOMContentLoaded', initLffunModule);

        // Fonction pour afficher les notifications SweetAlert
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
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            } else {
                // Fallback si SweetAlert n'est pas disponible
                alert(title + (message ? ': ' + message : ''));
            }
        }

        function initLffunModule() {
            console.log('✅ Module LFFUN chargé');

            // Récupération des données simulateur
            const simulationData = JSON.parse(sessionStorage.getItem('simulationData') || '{}');
            const formule = simulationData.formule || 'STANDARD';

            // Configuration des capitaux avec couleurs
            const CAPITALS = {
                STANDARD: {
                    adherent: 1000000, conjoint: 1000000, enfant: 500000, ascendant: 1000000,
                    prime: 54945, class: 'std', color: '#185FA5', bgGradient: 'linear-gradient(135deg, #185FA5 0%, #1a6bb5 100%)'
                },
                SERENITE: {
                    adherent: 2000000, conjoint: 2000000, enfant: 1000000, ascendant: 2000000,
                    prime: 109890, class: 'ser', color: '#BA7517', bgGradient: 'linear-gradient(135deg, #BA7517 0%, #d4881c 100%)'
                },
                PREMIUM: {
                    adherent: 4000000, conjoint: 4000000, enfant: 2000000, ascendant: 4000000,
                    prime: 219780, class: 'prem', color: '#3B6D11', bgGradient: 'linear-gradient(135deg, #3B6D11 0%, #4a8a16 100%)'
                }
            };
            const capitals = CAPITALS[formule] || CAPITALS.STANDARD;

            // Affichage des capitaux avec couleur de la formule
            const alertDiv = document.getElementById('lffun-capitals-alert');
            if (alertDiv) {
                alertDiv.className = `alert mb-4 lffun-alert-${capitals.class}`;
                alertDiv.innerHTML = `
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bx bx-info-circle fs-5"></i>
                            <strong>Formule ${formule}</strong> — Prime annuelle: <strong>${capitals.prime.toLocaleString()} FCFA</strong>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <span class="badge">Adhérent: ${capitals.adherent.toLocaleString()} FCFA</span>
                            <span class="badge">Conjoint: ${capitals.conjoint.toLocaleString()} FCFA</span>
                            <span class="badge">Enfant: ${capitals.enfant.toLocaleString()} FCFA</span>
                            <span class="badge">Ascendant: ${capitals.ascendant.toLocaleString()} FCFA</span>
                        </div>
                    </div>
                `;
            }

            // Récupération des infos du souscripteur (depuis le formulaire étape 1)
            function getSouscripteurInfo() {
                const getValue = (id) => document.getElementById(id)?.value || '';
                const getRadioValue = (name) => {
                    const radios = document.querySelectorAll(`input[name="${name}"]`);
                    for (let radio of radios) {
                        if (radio.checked) return radio.value;
                    }
                    return '';
                };

                // Essayer de récupérer depuis sessionStorage d'abord
                const savedSouscripteur = sessionStorage.getItem('lffun_souscripteur_temp');
                let savedData = {};
                if (savedSouscripteur) {
                    try {
                        savedData = JSON.parse(savedSouscripteur);
                    } catch(e) {}
                }

                const souscripteurData = {
                    nom: savedData.nom || getValue('FisrtName') || getValue('nom_souscripteur'),
                    prenom: savedData.prenom || getValue('LastName') || getValue('prenom_souscripteur'),
                    civilite: savedData.civilite || getRadioValue('civilite'),
                    datenaissance: savedData.datenaissance || getValue('Date_naissance'),
                    lieuNaissance: savedData.lieuNaissance || getValue('lieunaissance'),
                    lienParente: 'Soi-même',
                    numeropieceAssur: savedData.numeropiece || getValue('numeropiece'),
                    telephone: savedData.telephone || getValue('contactprincipal'),
                    mobile: savedData.mobile || getValue('contactsecondaire'),
                    email: savedData.email || getValue('email'),
                    profession: savedData.profession || getValue('profession'),
                    employeur: savedData.employeur || getValue('employeur'),
                    lieuresidence: savedData.lieuresidence || getValue('lieuresidence'),
                    situationMatrimoniale: savedData.situationMatrimoniale || getRadioValue('situation_matrimoniale'),
                    capital: capitals.adherent
                };

                return souscripteurData;
            }

            // Sauvegarder les infos souscripteur en session
            function saveSouscripteurToSession(data) {
                sessionStorage.setItem('lffun_souscripteur_temp', JSON.stringify(data));
            }

            // Structure des données
            let assures = {
                principal: getSouscripteurInfo(),
                conjoint: null,
                enfants: [],
                ascendants: []
            };

            // Sauvegarder les infos souscripteur pour les prochains chargements
            saveSouscripteurToSession(assures.principal);

            // Restauration des données existantes
            if (simulationData.assures) {
                if (simulationData.assures.principal) {
                    assures.principal = { ...assures.principal, ...simulationData.assures.principal };
                }
                if (simulationData.assures.conjoint) assures.conjoint = simulationData.assures.conjoint;
                if (simulationData.assures.enfants) assures.enfants = simulationData.assures.enfants;
                if (simulationData.assures.ascendants) assures.ascendants = simulationData.assures.ascendants;
            }

            console.log('📋 Assuré principal chargé:', assures.principal);

            // Sauvegarde en session
            function saveToSession() {
                const current = JSON.parse(sessionStorage.getItem('simulationData') || '{}');
                current.assures = {
                    principal: assures.principal,
                    conjoint: assures.conjoint,
                    enfants: assures.enfants,
                    ascendants: assures.ascendants
                };
                sessionStorage.setItem('simulationData', JSON.stringify(current));

                const hiddenInput = document.getElementById('lffun_assures_data');
                if (hiddenInput) {
                    hiddenInput.value = JSON.stringify(current.assures);
                }
                console.log('💾 Données sauvegardées');
            }

            // Rendu d'une ligne personne
            function renderPersonRow(type, person, index = null) {
                const capital = type === 'principal' ? capitals.adherent :
                               type === 'conjoint' ? capitals.conjoint :
                               type === 'enfant' ? capitals.enfant : capitals.ascendant;

                // Vérifier si les données existent
                const nom = person?.nom || '';
                const prenom = person?.prenom || '';
                const displayName = (prenom + ' ' + nom).trim();
                const finalDisplayName = displayName || 'Non renseigné';

                const ddn = person?.datenaissance ? new Date(person.datenaissance).toLocaleDateString('fr-FR') : 'Date non renseignée';
                const lieu = person?.lieuNaissance || '';
                const lien = person?.lienParente || (type === 'principal' ? 'Soi-même' : '');
                const telephone = person?.telephone || '';

                return `
                    <div class="lffun-person-row" data-type="${type}" data-index="${index !== null ? index : ''}">
                        <div class="lffun-person-info">
                            <div class="lffun-person-name">
                                ${escapeHtml(finalDisplayName)}
                                ${type === 'principal' ? '<span class="lffun-badge-souscripteur">Souscripteur</span>' : ''}
                            </div>
                            <div class="lffun-person-details">
                                <i class="bx bx-calendar"></i> ${ddn}
                                ${lieu ? ` | <i class="bx bx-map"></i> ${escapeHtml(lieu)}` : ''}
                                ${lien ? ` | <i class="bx bx-link"></i> ${escapeHtml(lien)}` : ''}
                                ${telephone ? ` | <i class="bx bx-phone"></i> ${escapeHtml(telephone)}` : ''}
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="lffun-person-capital me-3">
                                ${capital.toLocaleString()} FCFA
                            </span>
                            ${type !== 'principal' ? `
                                <i class="bx bx-edit lffun-edit-btn" onclick="window.lffunOpenEditModal('${type}', ${index})"></i>
                                <i class="bx bx-trash lffun-delete-btn" onclick="window.lffunDeletePerson('${type}', ${index})"></i>
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
            function renderPrincipal() {
                const container = document.getElementById('principal-list');
                if (container && assures.principal) {
                    container.innerHTML = renderPersonRow('principal', assures.principal);
                }
            }

            function renderConjoint() {
                const container = document.getElementById('conjoint-list');
                if (!container) return;
                if (!assures.conjoint) {
                    container.innerHTML = '<div class="lffun-empty-message"><i class="bx bx-heart"></i> Aucun conjoint enregistré</div>';
                    return;
                }
                container.innerHTML = renderPersonRow('conjoint', assures.conjoint);
            }

            function renderEnfants() {
                const container = document.getElementById('enfants-list');
                if (!container) return;
                if (assures.enfants.length === 0) {
                    container.innerHTML = '<div class="lffun-empty-message"><i class="bx bx-baby-carriage"></i> Aucun enfant enregistré</div>';
                    return;
                }
                container.innerHTML = '';
                assures.enfants.forEach((enfant, idx) => {
                    container.innerHTML += renderPersonRow('enfant', enfant, idx);
                });
            }

            function renderAscendants() {
                const container = document.getElementById('ascendants-list');
                if (!container) return;
                if (assures.ascendants.length === 0) {
                    container.innerHTML = '<div class="lffun-empty-message"><i class="bx bx-user"></i> Aucun ascendant enregistré</div>';
                    return;
                }
                container.innerHTML = '';
                assures.ascendants.forEach((asc, idx) => {
                    container.innerHTML += renderPersonRow('ascendant', asc, idx);
                });
            }

            function renderAll() {
                renderPrincipal();
                renderConjoint();
                renderEnfants();
                renderAscendants();
                updateButtonsState();
            }

            // Gestion des boutons d'ajout
            function updateButtonsState() {
                const addConjoint = document.getElementById('lffun-add-conjoint-btn');
                if (addConjoint) addConjoint.disabled = assures.conjoint !== null;

                const addEnfant = document.getElementById('lffun-add-enfant-btn');
                if (addEnfant) addEnfant.disabled = assures.enfants.length >= 4;

                const addAscendant = document.getElementById('lffun-add-ascendant-btn');
                if (addAscendant) addAscendant.disabled = assures.ascendants.length >= 2;
            }

            // Ajouts avec notification SweetAlert
            function addConjoint() {
                if (assures.conjoint) {
                    showToast('info', 'Information', 'Un conjoint est déjà enregistré');
                    return;
                }
                assures.conjoint = {
                    nom: '', prenom: '', civilite: '', datenaissance: '', lieuNaissance: '',
                    lienParente: 'Époux/Épouse', numeropieceAssur: '', telephone: '', email: '',
                    capital: capitals.conjoint
                };
                renderAll();
                saveToSession();
                setTimeout(() => window.lffunOpenEditModal('conjoint', 0), 100);
            }

            function addEnfant() {
                if (assures.enfants.length >= 4) {
                    showToast('warning', 'Limite atteinte', 'Maximum 4 enfants autorisés');
                    return;
                }
                const newIndex = assures.enfants.length;
                assures.enfants.push({
                    nom: '', prenom: '', civilite: '', datenaissance: '', lieuNaissance: '',
                    lienParente: 'Fils/Fille', numeropieceAssur: '', telephone: '', email: '',
                    capital: capitals.enfant
                });
                renderAll();
                saveToSession();
                setTimeout(() => window.lffunOpenEditModal('enfant', newIndex), 100);
            }

            function addAscendant() {
                if (assures.ascendants.length >= 2) {
                    showToast('warning', 'Limite atteinte', 'Maximum 2 ascendants autorisés');
                    return;
                }
                const newIndex = assures.ascendants.length;
                assures.ascendants.push({
                    nom: '', prenom: '', civilite: '', datenaissance: '', lieuNaissance: '',
                    lienParente: 'Ascendant', numeropieceAssur: '', telephone: '', email: '',
                    capital: capitals.ascendant
                });
                renderAll();
                saveToSession();
                setTimeout(() => window.lffunOpenEditModal('ascendant', newIndex), 100);
            }

            // Suppression avec confirmation SweetAlert
            window.lffunDeletePerson = function(type, index) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Confirmation',
                        text: 'Supprimer cette personne ?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Oui, supprimer',
                        cancelButtonText: 'Annuler'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            if (type === 'conjoint') assures.conjoint = null;
                            if (type === 'enfant') assures.enfants.splice(index, 1);
                            if (type === 'ascendant') assures.ascendants.splice(index, 1);
                            renderAll();
                            saveToSession();
                            showToast('success', 'Supprimé', 'La personne a été supprimée');
                        }
                    });
                } else {
                    if (confirm('Supprimer cette personne ?')) {
                        if (type === 'conjoint') assures.conjoint = null;
                        if (type === 'enfant') assures.enfants.splice(index, 1);
                        if (type === 'ascendant') assures.ascendants.splice(index, 1);
                        renderAll();
                        saveToSession();
                    }
                }
            };

            // Édition - Modal
            window.lffunOpenEditModal = function(type, index) {
                let person = null;
                if (type === 'conjoint') person = assures.conjoint;
                else if (type === 'enfant') person = assures.enfants[index];
                else if (type === 'ascendant') person = assures.ascendants[index];

                if (!person) return;

                document.getElementById('lffun_edit_type').value = type;
                document.getElementById('lffun_edit_index').value = index;
                document.getElementById('lffun_edit_nom').value = person.nom || '';
                document.getElementById('lffun_edit_prenom').value = person.prenom || '';
                document.getElementById('lffun_edit_ddn').value = person.datenaissance || '';
                document.getElementById('lffun_edit_lieu_naissance').value = person.lieuNaissance || '';
                document.getElementById('lffun_edit_lien').value = person.lienParente || '';
                document.getElementById('lffun_edit_telephone').value = person.telephone || '';
                document.getElementById('lffun_edit_email').value = person.email || '';
                document.getElementById('lffun_edit_piece').value = person.numeropieceAssur || '';

                const modal = new bootstrap.Modal(document.getElementById('lffunEditModal'));
                modal.show();
            };

            // Sauvegarde édition avec notification
            document.getElementById('lffun_save_edit')?.addEventListener('click', function() {
                const type = document.getElementById('lffun_edit_type').value;
                const index = parseInt(document.getElementById('lffun_edit_index').value);

                const updatedData = {
                    nom: document.getElementById('lffun_edit_nom').value,
                    prenom: document.getElementById('lffun_edit_prenom').value,
                    datenaissance: document.getElementById('lffun_edit_ddn').value,
                    lieuNaissance: document.getElementById('lffun_edit_lieu_naissance').value,
                    lienParente: document.getElementById('lffun_edit_lien').value,
                    telephone: document.getElementById('lffun_edit_telephone').value,
                    email: document.getElementById('lffun_edit_email').value,
                    numeropieceAssur: document.getElementById('lffun_edit_piece').value
                };

                if (type === 'conjoint') {
                    assures.conjoint = { ...assures.conjoint, ...updatedData };
                } else if (type === 'enfant') {
                    assures.enfants[index] = { ...assures.enfants[index], ...updatedData };
                } else if (type === 'ascendant') {
                    assures.ascendants[index] = { ...assures.ascendants[index], ...updatedData };
                }

                renderAll();
                saveToSession();
                showToast('success', 'Enregistré', 'Les modifications ont été sauvegardées');

                const modal = bootstrap.Modal.getInstance(document.getElementById('lffunEditModal'));
                modal.hide();
            });

            // Validation avant next
            window.validateLffunAndNext = function() {
                if (!assures.principal.nom || !assures.principal.prenom) {
                    showToast('error', 'Champ requis', 'Veuillez renseigner le nom et prénom du souscripteur');
                    return;
                }
                saveToSession();
                if (typeof stepper1 !== 'undefined') {
                    stepper1.next();
                }
            };

            // Attacher les événements
            document.getElementById('lffun-add-conjoint-btn')?.addEventListener('click', addConjoint);
            document.getElementById('lffun-add-enfant-btn')?.addEventListener('click', addEnfant);
            document.getElementById('lffun-add-ascendant-btn')?.addEventListener('click', addAscendant);

            renderAll();
            saveToSession();
        }
    })();
    </script>

</div>
