<div class="row g-3 align-items-end mb-3">
    <div class="col-12 col-lg-6">
        <label class="form-label">Le souscripteur est-il l'assuré ? <span class="text-danger">*</span></label>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estAssure" id="estAssureOui" value="Oui" checked>
            <label class="form-check-label" for="estAssureOui">Oui</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="estAssure" id="estAssureNon" value="Non" disabled>
            <label class="form-check-label" for="estAssureNon">Non</label>
        </div>
    </div>
    <div class="col-12 col-lg-6 text-end" id="modalAssurerOpen">
        <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#createAssurerModal">
            <i class="fadeIn animated bx bx-plus"></i> Ajouter un(e) autre assuré(e)
        </button>
    </div>
</div>

<div class="overflow-auto">
    <table class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Assuré(e)</th>
                <th>Date de naissance</th>
                <th>Lieu de résidence</th>
                <th>n° de telephone</th>
                <th>n° de piece</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="tableAssuresBody">
            <!-- Contenu dynamique injecté ici par JavaScript -->
        </tbody>
    </table>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const radioOui = document.getElementById('estAssureOui');
    const radioNon = document.getElementById('estAssureNon');
    const storeAssurerBtn = document.getElementById('storeAssurerBtn');
    const assurerForm = document.getElementById('assurerForm');
    const modalAssurerOpen = document.getElementById('modalAssurerOpen');

    // ===== FONCTIONS DE BASE =====
    
    function getSouscriptionData() {
        try {
            const data = sessionStorage.getItem('souscriptionData');
            return data ? JSON.parse(data) : {};
        } catch (e) {
            console.error('Erreur de parsing sessionStorage:', e);
            return {};
        }
    }

    function saveSouscriptionData(data) {
        sessionStorage.setItem('souscriptionData', JSON.stringify(data));
        console.log('✅ Données sauvegardées:', data);
    }

    function isContratIndividuel() {
        const souscriptionData = getSouscriptionData();
        return souscriptionData.simulationData?.type === "Individuel";
    }

    // ===== SYNC SOUSCRIPTEUR → ASSURÉ =====
    function synchroniserSouscripteurVersAssure() {
        const souscriptionData = getSouscriptionData();
        const adherentData = souscriptionData.adherentData;

        if (!adherentData || Object.keys(adherentData).length === 0) {
            console.warn('⚠️ Aucune donnée souscripteur trouvée');
            return false;
        }

        // Vérifier si des champs obligatoires sont remplis
        const nom = adherentData.nom || '';
        const prenom = adherentData.prenom || '';
        if (!nom.trim() || !prenom.trim()) {
            // console.warn('⚠️ Données souscripteur incomplètes (nom/prénom manquants)');
            return false;
        }

        // Créer l'objet assuré
        const assure = {
            civilite: adherentData.civilite || '',
            nom: nom,
            prenom: prenom,
            datenaissance: adherentData.datenaissance || '',
            lieunaissance: adherentData.lieunaissance || '',
            naturepiece: adherentData.naturepiece || '',
            numeropiece: adherentData.numeropiece || '',
            lieuresidence: adherentData.lieuresidence || '',
            profession: adherentData.profession || '',
            employeur: adherentData.employeur || '',
            email: adherentData.email || '',
            mobile: adherentData.mobile || '',
            telephone: adherentData.telephone || '',
            telephone1: adherentData.mobile1 || '',
            situation_matrimoniale: adherentData.situation_matrimoniale || '',
            estSouscripteur: true
        };

        // Initialiser assureData
        souscriptionData.assureData = souscriptionData.assureData || [];

        // Supprimer l'ancien souscripteur
        const ancienIndex = souscriptionData.assureData.findIndex(a => a.estSouscripteur === true);
        if (ancienIndex !== -1) {
            souscriptionData.assureData.splice(ancienIndex, 1);
        }

        // Ajouter en première position
        souscriptionData.assureData.unshift(assure);
        saveSouscriptionData(souscriptionData);

        // Rafraîchir l'affichage
        initialiserTableauAssures();
        updateButtonState();

        console.log('✅ Synchronisation souscripteur → assuré réussie');
        return true;
    }

    // ===== AJOUTER UN ASSURÉ SUPPLÉMENTAIRE =====
    function ajouterAssure(assure) {
        const souscriptionData = getSouscriptionData();
        souscriptionData.assureData = souscriptionData.assureData || [];

        if (isContratIndividuel() && souscriptionData.assureData.length >= 1) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Un seul assuré est autorisé pour un contrat individuel.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        const existeDeja = souscriptionData.assureData.some(a => a.numeropiece === assure.numeropiece);
        if (existeDeja) {
            Swal.fire({
                icon: 'warning',
                title: 'Désolé',
                text: 'Cet assuré est déjà présent dans la liste.',
                confirmButtonText: 'Fermer'
            });
            return false;
        }

        souscriptionData.assureData.push(assure);
        saveSouscriptionData(souscriptionData);

        initialiserTableauAssures();
        updateButtonState();
        return true;
    }

    // ===== AFFICHER LE TABLEAU =====
    function initialiserTableauAssures() {
        const tbody = document.getElementById('tableAssuresBody');
        tbody.innerHTML = '';
        
        const souscriptionData = getSouscriptionData();
        const assures = souscriptionData.assureData || [];

        if (assures.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="6" class="text-center text-muted py-3">
                        Aucun assuré enregistré
                    </td>
                </tr>
            `;
            return;
        }

        assures.forEach(assure => {
            const tr = document.createElement('tr');
            tr.setAttribute('data-id', assure.numeropiece || 'souscripteur');
            tr.setAttribute('data-est-souscripteur', assure.estSouscripteur ? 'true' : 'false');

            if (assure.estSouscripteur) {
                tr.style.backgroundColor = '#e8f4fd';
                tr.style.fontWeight = 'bold';
            }

            const nomComplet = `${assure.civilite || ''} ${assure.nom || ''} ${assure.prenom || ''}`.trim();
            const telephone = assure.mobile || assure.telephone || '';

            tr.innerHTML = `
                <td>
                    ${nomComplet || 'Nom non renseigné'}
                    ${assure.estSouscripteur ? ' <span class="badge bg-primary">Souscripteur</span>' : ''}
                </td>
                <td>${assure.datenaissance || '-'}</td>
                <td>${assure.lieuresidence || '-'}</td>
                <td>${telephone || '-'}</td>
                <td>${assure.numeropiece || '-'}</td>
                <td>
                    ${!assure.estSouscripteur ? `
                        <button type="button" class="btn btn-danger btn-sm" onclick="supprimerLigne(this)">
                            <i class="bx bx-trash"></i> Supprimer
                        </button>
                    ` : `
                        <span class="text-muted"><i class="bx bx-lock"></i> Non supprimable</span>
                    `}
                </td>
            `;

            tbody.appendChild(tr);
        });
    }

    // ===== METTRE À JOUR LE BOUTON =====
    function updateButtonState() {
        const souscriptionData = getSouscriptionData();
        if (souscriptionData.simulationData?.type === "Individuel") {
            const assureCount = (souscriptionData.assureData || []).length;
            if (assureCount >= 1) {
                modalAssurerOpen.classList.add("disabled");
                modalAssurerOpen.style.pointerEvents = "none";
                modalAssurerOpen.style.opacity = "0.5";
            } else {
                modalAssurerOpen.classList.remove("disabled");
                modalAssurerOpen.style.pointerEvents = "auto";
                modalAssurerOpen.style.opacity = "1";
            }
        }
    }

    // ===== SYNC COMPLÈTE =====
    function forcerSynchronisationComplete() {
        // console.log('🔄 Forçage de la synchronisation...');
        
        // Récupérer les données
        const souscriptionData = getSouscriptionData();
        const adherentData = souscriptionData.adherentData;

        // Vérifier si on a des données souscripteur
        if (!adherentData || Object.keys(adherentData).length === 0) {
            console.warn('⚠️ Aucune donnée souscripteur disponible');
            initialiserTableauAssures();
            return;
        }

        // Vérifier si les champs sont remplis
        const nom = adherentData.nom || '';
        const prenom = adherentData.prenom || '';
        
        if (!nom.trim() || !prenom.trim()) {
            console.warn('⚠️ Données souscripteur incomplètes');
            initialiserTableauAssures();
            return;
        }

        // Synchroniser
        synchroniserSouscripteurVersAssure();
    }

    // ===== ÉCOUTEUR SUR LES CHAMPS DU SOUSCRIPTEUR =====
    function ecouterChangementsSouscripteur() {
        // Écouter les changements dans le formulaire souscripteur
        const formSouscripteur = document.querySelector('form#souscripteurForm') || document.querySelector('form');
        if (formSouscripteur) {
            formSouscripteur.addEventListener('change', function(e) {
                // Si le champ modifié fait partie des champs du souscripteur
                const target = e.target;
                if (target.id && target.id.startsWith('souscripteur')) {
                    console.log('🔄 Changement détecté sur:', target.id);
                    // Attendre que la saisie soit terminée
                    clearTimeout(window.syncTimeout);
                    window.syncTimeout = setTimeout(() => {
                        forcerSynchronisationComplete();
                    }, 300);
                }
            });
        }

        // Écouter également les inputs
        document.addEventListener('input', function(e) {
            const target = e.target;
            if (target.id && target.id.startsWith('souscripteur')) {
                clearTimeout(window.syncTimeout);
                window.syncTimeout = setTimeout(() => {
                    forcerSynchronisationComplete();
                }, 500);
            }
        });
    }

    // ===== ÉVÉNEMENTS =====

    // Radio "Oui"
    radioOui.addEventListener('change', function() {
        if (this.checked) {
            forcerSynchronisationComplete();
        }
    });

    // Bouton d'ajout d'assuré
    if (storeAssurerBtn) {
        storeAssurerBtn.addEventListener('click', function() {
            const formData = {
                civilite: document.querySelector('input[name="assurerCivilite"]:checked')?.value || '',
                nom: document.getElementById('assurerNom')?.value || '',
                prenom: document.getElementById('assurerPrenom')?.value || '',
                datenaissance: document.getElementById('assurerDatenaissance')?.value || '',
                lieunaissance: document.getElementById('assurerLieunaissance')?.value || '',
                filiation: document.getElementById('assurerFiliation')?.value || '',
                sexe: document.getElementById('assurerSexe')?.value || '',
                naturepiece: document.getElementById('assurerNaturepiece')?.value || '',
                numeropiece: document.getElementById('assurerNumeropiece')?.value || '',
                lieuresidence: document.getElementById('assurerLieuresidence')?.value || '',
                profession: document.getElementById('assurerProfession')?.value || '',
                employeur: document.getElementById('assurerEmployeur')?.value || '',
                email: document.getElementById('assurerEmail')?.value || '',
                telephone: document.getElementById('assurerTelephone')?.value || '',
                telephone1: document.getElementById('assurerTelephone1')?.value || '',
                mobile: document.getElementById('assurerMobile')?.value || '',
                estSouscripteur: false,
                justifResidence: document.getElementById('justifResidence')?.files || []
            };

            if (ajouterAssure(formData)) {
                const modal = bootstrap.Modal.getInstance(document.getElementById('createAssurerModal'));
                if (modal) modal.hide();
                if (assurerForm) assurerForm.reset();
            }
        });
    }

    // ===== ÉCOUTEUR STORAGE =====
    window.addEventListener('storage', function(e) {
        if (e.key === 'souscriptionData') {
            try {
                const nouvellesDonnees = JSON.parse(e.newValue);
                if (nouvellesDonnees && nouvellesDonnees.adherentData && radioOui.checked) {
                    forcerSynchronisationComplete();
                }
            } catch (error) {
                console.error('Erreur storage:', error);
            }
        }
    });

    // ===== INITIALISATION =====
    function init() {
        radioOui.checked = true;
        radioNon.checked = false;
        radioNon.disabled = true;

        // Synchroniser immédiatement
        forcerSynchronisationComplete();

        // Démarrer l'écoute des changements
        ecouterChangementsSouscripteur();

        // Synchroniser toutes les 2 secondes (au cas où)
        setInterval(() => {
            if (radioOui.checked) {
                forcerSynchronisationComplete();
            }
        }, 2000);

        console.log('✅ Initialisation terminée - Synchronisation active');
    }

    // EXPOSER LES FONCTIONS
    window.forcerSynchronisationComplete = forcerSynchronisationComplete;
    window.synchroniserSouscripteurVersAssure = synchroniserSouscripteurVersAssure;
    window.initialiserTableauAssures = initialiserTableauAssures;
    window.updateButtonState = updateButtonState;

    // LANCER L'INIT
    init();
});

// ===== SUPPRIMER UNE LIGNE =====
function supprimerLigne(btn) {
    const row = btn.closest('tr');
    if (!row) return;

    const id = row.getAttribute('data-id');
    const estSouscripteur = row.getAttribute('data-est-souscripteur') === 'true';

    if (estSouscripteur) {
        Swal.fire({
            icon: 'warning',
            title: 'Action non autorisée',
            text: 'Le souscripteur ne peut pas être supprimé de la liste des assurés.',
            confirmButtonText: 'Ok'
        });
        return;
    }

    Swal.fire({
        title: 'Êtes-vous sûr ?',
        text: "Vous ne pourrez pas revenir en arrière !",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Oui, supprimer !',
        cancelButtonText: 'Annuler'
    }).then((result) => {
        if (result.isConfirmed) {
            let souscriptionData = JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
            if (souscriptionData.assureData) {
                souscriptionData.assureData = souscriptionData.assureData.filter(a => a.numeropiece !== id);
                sessionStorage.setItem('souscriptionData', JSON.stringify(souscriptionData));
            }

            row.remove();

            const tbody = document.getElementById('tableAssuresBody');
            if (tbody.children.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="6" class="text-center text-muted py-3">
                            Aucun assuré enregistré
                        </td>
                    </tr>
                `;
            }

            if (typeof window.updateButtonState === 'function') {
                window.updateButtonState();
            }

            Swal.fire({
                icon: 'success',
                title: 'Supprimé !',
                text: 'L\'assuré a été supprimé avec succès.',
                timer: 1500,
                showConfirmButton: false
            });
        }
    });
}
</script>