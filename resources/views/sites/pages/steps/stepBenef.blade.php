<!-- Section Bénéficiaires -->
<div class="row g-3">
    <div class="col-12 col-lg-12">
        <label class="form-label fw-bold fs-5">Bénéficiaires</label>
        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Bénéficiaire désigné -->
                <div class="benef-design-section mb-4 p-3 bg-white rounded-3 border border-2 border-success border-opacity-25">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-user-plus fs-4 text-success"></i>
                        <h6 class="fw-bold mb-0 text-success">Bénéficiaire désigné</h6>
                        <span class="badge bg-success bg-opacity-10 text-white ms-auto" id="designCount">0 bénéficiaire</span>
                    </div>
                    
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Nom & Prénoms *</label>
                            <input type="text" class="form-control form-control-sm" id="benefDesignNom" placeholder="Nom complet">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Lien *</label>
                            <select id="benefDesignLien" class="form-select">
                                <option selected value="" disabled  class="form-control form-control-sm">Lien de Parenté</option>
                                @foreach ($filliations as $filliation)
                                    <option  class="form-control form-control-sm" value="{{ $filliation->MonLibelle }}">{{ $filliation->MonLibelle }}</option>
                                @endforeach
                            </select>

                            {{-- <input type="text" class="form-control form-control-sm" id="benefDesignLien" placeholder="Parenté"> --}}
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Téléphone *</label>
                            <input type="tel" class="form-control form-control-sm" id="benefDesignTel" placeholder="Numéro" minlength="10" maxlength="15">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Adresse</label>
                            <input type="text" class="form-control form-control-sm" id="benefDesignAdresse" placeholder="Adresse">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-success btn-sm w-100" id="btnAjouterDesign" onclick="ajouterBenefDesign()">
                                <i class="fa-solid fa-plus me-1"></i> Ajouter
                            </button>
                        </div>
                    </div>

                    <!-- Tableau des bénéficiaires désignés -->
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0" id="designTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 30%">Nom & Prénoms</th>
                                        <th style="width: 20%">Lien</th>
                                        <th style="width: 20%">Téléphone</th>
                                        <th style="width: 20%">Adresse</th>
                                        <th style="width: 5%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="designTableBody">
                                    <!-- Les bénéficiaires désignés s'affichent ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Enfants Scolarisés -->
                <div class="enfants-section p-3 bg-white rounded-3 border border-2 border-info border-opacity-25">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <i class="fa-solid fa-children fs-4 text-info"></i>
                        <h6 class="fw-bold mb-0 text-info">Enfants scolarisés</h6>
                        <span class="badge bg-info bg-opacity-10 text-info ms-auto" id="enfantsCount">0 enfant</span>
                    </div>
                    
                    <div class="row g-2 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Nom & Prénoms *</label>
                            <input type="text" class="form-control form-control-sm" id="enfantNom" placeholder="Nom complet">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Date naissance</label>
                            <input type="date" class="form-control form-control-sm" id="enfantDateNaiss">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label small fw-semibold">Niveau *</label>
                            <select class="form-select form-select-sm" id="enfantNiveau">
                                <option value="">Choisir...</option>
                                <option value="Maternelle">Maternelle</option>
                                <option value="CP">CP</option>
                                <option value="CE1">CE1</option>
                                <option value="CE2">CE2</option>
                                <option value="CM1">CM1</option>
                                <option value="CM2">CM2</option>
                                <option value="6ème">6ème</option>
                                <option value="5ème">5ème</option>
                                <option value="4ème">4ème</option>
                                <option value="3ème">3ème</option>
                                <option value="Seconde">Seconde</option>
                                <option value="1ère">1ère</option>
                                <option value="Terminale">Terminale</option>
                                <option value="Université">Université</option>
                                <option value="Autre">Autre</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-semibold">Observation</label>
                            <input type="text" class="form-control form-control-sm" id="enfantObservation" placeholder="Optionnel">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-info btn-sm w-100 text-white" onclick="ajouterEnfant()">
                                <i class="fa-solid fa-plus me-1"></i> Ajouter
                            </button>
                        </div>
                    </div>

                    <!-- Tableau des enfants -->
                    <div class="mt-3">
                        <div class="table-responsive">
                            <table class="table table-sm table-borderless mb-0" id="enfantsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 5%">#</th>
                                        <th style="width: 30%">Nom & Prénoms</th>
                                        <th style="width: 15%">Date naissance</th>
                                        <th style="width: 20%">Niveau</th>
                                        <th style="width: 25%">Observation</th>
                                        <th style="width: 5%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="enfantsTableBody">
                                    <!-- Les enfants s'affichent ici -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau récapitulatif global -->
<div class="row g-3 mt-2">
    <div class="col-12">
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">
                    <i class="fa-solid fa-list-ul me-2"></i>Récapitulatif des bénéficiaires
                </h6>
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="reinitialiserBeneficiaires()">
                    <i class="fa-solid fa-rotate me-1"></i> Réinitialiser
                </button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="beneficiairesTable">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 10%">Type</th>
                                <th style="width: 30%">Nom & Prénoms</th>
                                <th style="width: 15%">Lien</th>
                                <th style="width: 15%">Téléphone</th>
                                <th style="width: 20%">Infos complémentaires</th>
                                <th style="width: 10%" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody id="beneficiairesTableBody">
                            <!-- Tous les bénéficiaires s'affichent ici -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    chargerBeneficiaires();
});

// ===== GESTION SESSION =====
function getSouscription() {
    return JSON.parse(sessionStorage.getItem('souscriptionData')) || {};
}

function saveSouscription(souscription) {
    sessionStorage.setItem('souscriptionData', JSON.stringify(souscription));
}

function getBeneficiaires() {
    const souscription = getSouscription();
    return souscription.benefData || [];
}

function setBeneficiaires(benefs) {
    const souscription = getSouscription();
    souscription.benefData = benefs;
    saveSouscription(souscription);
}

// ===== BÉNÉFICIAIRE PAR DÉFAUT =====
function getBeneficiaireDefaut() {
    return {
        id: 'defaut',
        type: 'defaut',
        nom: 'Fonds de soutien aux études et à la formation des orphelins',
        lien: 'Fonds initié par l\'employeur',
        telephone: '-',
        adresse: '-',
        isDefault: true
    };
}

// ===== AJOUTER BÉNÉFICIAIRE DÉSIGNÉ =====
window.ajouterBenefDesign = function() {
    const nom = document.getElementById('benefDesignNom').value.trim();
    const lien = document.getElementById('benefDesignLien').value.trim();
    const tel = document.getElementById('benefDesignTel').value.trim();
    const adresse = document.getElementById('benefDesignAdresse').value.trim();

    if (!nom || !lien || !tel) {
        toast('Veuillez remplir tous les champs obligatoires (*)', 'warning');
        return;
    }

    const benefs = getBeneficiaires();
    
    // Vérifier si un bénéficiaire désigné existe déjà
    const existant = benefs.find(b => b.type === 'design');
    if (existant) {
        toast('Un bénéficiaire désigné existe déjà !', 'danger');
        return;
    }

    const nouveauBenef = {
        id: 'design_' + Date.now(),
        type: 'design',
        nom: nom,
        lien: lien,
        telephone: tel,
        adresse: adresse || '-',
        isDesign: true
    };

    benefs.push(nouveauBenef);
    setBeneficiaires(benefs);
    afficherBeneficiaires();

    // Réinitialiser le formulaire
    document.getElementById('benefDesignNom').value = '';
    document.getElementById('benefDesignLien').value = '';
    document.getElementById('benefDesignTel').value = '';
    document.getElementById('benefDesignAdresse').value = '';

    toast('Bénéficiaire désigné ajouté avec succès !', 'success');
};

// ===== AJOUTER ENFANT =====
window.ajouterEnfant = function() {
    const nom = document.getElementById('enfantNom').value.trim();
    const dateNaiss = document.getElementById('enfantDateNaiss').value;
    const niveau = document.getElementById('enfantNiveau').value;
    const observation = document.getElementById('enfantObservation').value.trim();

    if (!nom || !niveau) {
        toast('Veuillez remplir le nom et le niveau d\'étude', 'warning');
        return;
    }

    const benefs = getBeneficiaires();
    const enfants = benefs.filter(b => b.type === 'enfant');

    if (enfants.length >= 5) {
        toast('Maximum 5 enfants atteint !', 'danger');
        return;
    }

    const nouvelEnfant = {
        id: 'enfant_' + Date.now(),
        type: 'enfant',
        nom: nom,
        dateNaissance: dateNaiss || '-',
        niveau: niveau,
        observation: observation || '-',
        telephone: '-',
        adresse: '-',
        lien: 'Enfant scolarisé'
    };

    benefs.push(nouvelEnfant);
    setBeneficiaires(benefs);
    afficherBeneficiaires();

    // Réinitialiser le formulaire
    document.getElementById('enfantNom').value = '';
    document.getElementById('enfantDateNaiss').value = '';
    document.getElementById('enfantNiveau').value = '';
    document.getElementById('enfantObservation').value = '';

    toast('Enfant ajouté avec succès !', 'success');
};

// ===== SUPPRIMER BÉNÉFICIAIRE =====
window.supprimerBeneficiaire = function(id) {
    if (!confirm('Voulez-vous vraiment supprimer ce bénéficiaire ?')) return;

    let benefs = getBeneficiaires();
    benefs = benefs.filter(b => b.id !== id);
    setBeneficiaires(benefs);
    afficherBeneficiaires();
    toast('Bénéficiaire supprimé', 'info');
};

// ===== AFFICHER TOUS LES BÉNÉFICIAIRES =====
function afficherBeneficiaires() {
    let benefs = getBeneficiaires();

    // S'assurer que le bénéficiaire par défaut existe
    const defaut = benefs.find(b => b.type === 'defaut');
    if (!defaut) {
        benefs.unshift(getBeneficiaireDefaut());
        setBeneficiaires(benefs);
    }

    // ===== Gérer le bouton Ajouter désigné =====
    const btnDesign = document.getElementById('btnAjouterDesign');
    const designExist = benefs.some(b => b.type === 'design');
    btnDesign.disabled = designExist;
    if (designExist) {
        btnDesign.innerHTML = '<i class="fa-solid fa-check me-1"></i> Ajouté';
        btnDesign.classList.remove('btn-success');
        btnDesign.classList.add('btn-secondary');
    } else {
        btnDesign.innerHTML = '<i class="fa-solid fa-plus me-1"></i> Ajouter';
        btnDesign.classList.remove('btn-secondary');
        btnDesign.classList.add('btn-success');
    }

    // ===== 1. Afficher dans le tableau global =====
    const tbody = document.getElementById('beneficiairesTableBody');
    
    // Trier : defaut, design, enfant
    const ordre = { defaut: 0, design: 1, enfant: 2 };
    benefs.sort((a, b) => (ordre[a.type] || 99) - (ordre[b.type] || 99));

    tbody.innerHTML = '';

    benefs.forEach(b => {
        const isDefault = b.type === 'defaut';
        const isDesign = b.type === 'design';
        const isEnfant = b.type === 'enfant';

        let badgeType = '';
        let iconType = '';
        if (isDefault) {
            badgeType = '<span class="badge bg-primary bg-opacity-10 text-white"><i class="fa-solid fa-house me-1"></i>Par défaut</span>';
            iconType = '<i class="fa-solid fa-house"></i>';
        } else if (isDesign) {
            badgeType = '<span class="badge bg-success bg-opacity-10 text-white"><i class="fa-solid fa-user-check me-1"></i>Désigné</span>';
            iconType = '<i class="fa-solid fa-user"></i>';
        } else if (isEnfant) {
            badgeType = '<span class="badge bg-info bg-opacity-10 text-info"><i class="fa-solid fa-child me-1"></i>Enfant</span>';
            iconType = '<i class="fa-solid fa-child"></i>';
        }

        let infos = '';
        if (isEnfant) {
            infos = `<i class="fa-solid fa-calendar me-1"></i>${b.dateNaissance} • <i class="fa-solid fa-book me-1"></i>${b.niveau}`;
            if (b.observation && b.observation !== '-') infos += ` • ${b.observation}`;
        } else {
            infos = b.adresse || '-';
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${badgeType}</td>
            <td><span class="fw-semibold">${b.nom}</span></td>
            <td>${b.lien || '-'}</td>
            <td>${b.telephone || '-'}</td>
            <td><small>${infos}</small></td>
            <td class="text-center">
                ${!isDefault ? `<button class="btn btn-sm btn-danger" onclick="supprimerBeneficiaire('${b.id}')" title="Supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>` : '<span class="text-muted">—</span>'}
            </td>
        `;
        tbody.appendChild(tr);
    });

    // ===== 2. Afficher dans le tableau des bénéficiaires désignés =====
    const designBody = document.getElementById('designTableBody');
    const designBenefs = benefs.filter(b => b.type === 'design');
    designBody.innerHTML = '';
    if (designBenefs.length === 0) {
        designBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-3">
                    <i class="fa-solid fa-user-slash fs-4 d-block mb-1"></i>
                    Aucun bénéficiaire désigné
                </td>
            </tr>
        `;
    } else {
        designBenefs.forEach((b, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><span class="fw-semibold">${b.nom}</span></td>
                <td>${b.lien}</td>
                <td>${b.telephone}</td>
                <td>${b.adresse}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger" onclick="supprimerBeneficiaire('${b.id}')" title="Supprimer">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;
            designBody.appendChild(tr);
        });
    }
    document.getElementById('designCount').textContent = `${designBenefs.length} bénéficiaire${designBenefs.length > 1 ? 's' : ''}`;

    // ===== 3. Afficher dans le tableau des enfants =====
    const enfantsBody = document.getElementById('enfantsTableBody');
    const enfants = benefs.filter(b => b.type === 'enfant');
    enfantsBody.innerHTML = '';
    if (enfants.length === 0) {
        enfantsBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted py-3">
                    <i class="fa-solid fa-child-slash fs-4 d-block mb-1"></i>
                    Aucun enfant scolarisé
                </td>
            </tr>
        `;
    } else {
        enfants.forEach((e, index) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${index + 1}</td>
                <td><span class="fw-semibold">${e.nom}</span></td>
                <td>${e.dateNaissance || '-'}</td>
                <td><span class="badge bg-secondary bg-opacity-10 text-secondary">${e.niveau}</span></td>
                <td>${e.observation || '-'}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger" onclick="supprimerBeneficiaire('${e.id}')" title="Supprimer">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            `;
            enfantsBody.appendChild(tr);
        });
    }
    document.getElementById('enfantsCount').textContent = `${enfants.length} enfant${enfants.length > 1 ? 's' : ''}`;
}

// ===== CHARGER AU DÉMARRAGE =====
function chargerBeneficiaires() {
    let benefs = getBeneficiaires();
    const defaut = benefs.find(b => b.type === 'defaut');
    if (!defaut) {
        benefs.unshift(getBeneficiaireDefaut());
        setBeneficiaires(benefs);
    }
    afficherBeneficiaires();
}

// ===== RÉINITIALISER =====
window.reinitialiserBeneficiaires = function() {
    if (!confirm('Voulez-vous réinitialiser tous les bénéficiaires ?')) return;
    const defaut = getBeneficiaireDefaut();
    setBeneficiaires([defaut]);
    afficherBeneficiaires();
    toast('Bénéficiaires réinitialisés', 'info');
};

// ===== TOAST NOTIFICATION =====
function toast(message, type = 'info') {
    const colors = {
        success: 'bg-success text-white',
        danger: 'bg-danger text-white',
        warning: 'bg-warning text-dark',
        info: 'bg-info text-white'
    };
    
    const icons = {
        success: 'fa-solid fa-check-circle',
        danger: 'fa-solid fa-xmark-circle',
        warning: 'fa-solid fa-triangle-exclamation',
        info: 'fa-solid fa-circle-info'
    };
    
    const toastContainer = document.createElement('div');
    toastContainer.className = 'position-fixed bottom-0 end-0 p-3';
    toastContainer.style.zIndex = '9999';
    toastContainer.innerHTML = `
        <div class="toast show" role="alert">
            <div class="toast-body ${colors[type] || 'bg-light'} rounded-3 shadow d-flex align-items-center gap-2">
                <i class="${icons[type] || 'fa-solid fa-circle-info'} fs-5"></i>
                <span>${message}</span>
                <button type="button" class="btn-close btn-close-white ms-2" style="font-size: 0.7rem;" onclick="this.closest('.toast').remove()"></button>
            </div>
        </div>
    `;
    document.body.appendChild(toastContainer);
    setTimeout(() => toastContainer.remove(), 3000);
}
</script>