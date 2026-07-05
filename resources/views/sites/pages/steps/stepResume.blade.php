<div class="row g-3">
    <div class="col-12">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <h4>Adhérent</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-xs-12 border-r">
                        <dl class="row">
                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Civilité:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayCivility">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Nom:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNom">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Prénoms:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayPrenom">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Date de naissance:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayBirthday">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Lieu de naissance:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayLieuNaissance">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Lieu de résidence:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayResidence">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">N° pièce:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNumPiece">--</dd>
                        </dl>
                    </div>
                    <div class="col-6 col-xs-12">
                        <dl class="row">
                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Profession:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayProfession">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Secteur d'activité:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayEmployeur">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Email:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayEmail">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Téléphone:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayTelephone">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mobile:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayMobile">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mobile 2:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayMobile1">--</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <h4>Conditions de paiement de la prime & périodicité</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6 col-xs-12 border-r">
                        <dl class="row">
                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Produit:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayProduit">{{ $product->MonLibelle ?? 'null' }}</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Prime principale:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayPrimePrincipale">16 900 Fcfa</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Frais d'adhésion:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayFraisAdhesion">0 Fcfa</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Capital désiré:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayCapital">4 000 000 Fcfa</dd>
                        </dl>
                    </div>
                    <div class="col-6 col-xs-12">
                        <dl class="row">
                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Mode paiement:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayModePaiement">SOLDE</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">Date Effet:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayDateEffet">--</dd>

                            <dt class="col-xs-12 col-sm-6 col-md-6 col-lg-6">N° Compte:</dt>
                            <dd class="col-xs-12 col-sm-6 col-md-6 col-lg-6" id="displayNumeroCompte">--</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <h4>Assuré(e)s</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 overflow-auto overflow-scroll">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénoms</th>
                                    <th scope="col">Né(e) le</th>
                                    <th scope="col">Lieu de naissance</th>
                                    <th scope="col">Lieu de résidence</th>
                                    <th scope="col">Filiation</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">N° pièce</th>
                                </tr>
                            </thead>
                            <tbody id="resume-tbody-assure">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <h4>Garanties</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 overflow-auto overflow-scroll">
                        <table class="table mb-0 table-striped table-responsive table-bordered">
                            <thead class="fw-bold">
                                <tr>
                                    <th scope="col">Garantie</th>
                                    <th scope="col">Prime principale</th>
                                    <th scope="col">Capital</th>
                                </tr>
                            </thead>
                            <tbody id="garantiesTableBody">
                                <!-- Les garanties seront injectées dynamiquement -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card" style="width: 100%">
            <div class="card-header">
                <h4>Bénéficiaire(s)</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 overflow-auto overflow-scroll">
                        <table class="table mb-0 table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">Type</th>
                                    <th scope="col">Nom</th>
                                    {{-- <th scope="col">Prénoms</th> --}}
                                    <th scope="col">Né(e) le</th>
                                    <th scope="col">Lieu de naissance</th>
                                    <th scope="col">Lieu de résidence</th>
                                    <th scope="col">Lien</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Email</th>
                                </tr>
                            </thead>
                            <tbody id="resume-tbody-benef">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fonction principale de mise à jour de la vue Résumé
        function updateResume(data) {
            console.log('📊 Mise à jour du résumé avec:', data);

            const adherent = data.adherentData || {};
            const contrat = data.contratData || {};
            const assures = data.assureData || [];
            const benefs = data.benefData || [];

            // ===== 1. ADHÉRENT (Souscripteur) =====
            document.getElementById('displayCivility').textContent = adherent.civilite || '--';
            document.getElementById('displayNom').textContent = adherent.nom || '--';
            document.getElementById('displayPrenom').textContent = adherent.prenom || '--';
            document.getElementById('displayBirthday').textContent = adherent.datenaissance || '--';
            document.getElementById('displayLieuNaissance').textContent = adherent.lieunaissance || '--';
            document.getElementById('displayResidence').textContent = adherent.lieuresidence || '--';
            document.getElementById('displayNumPiece').textContent = adherent.numeropiece || '--';
            document.getElementById('displayProfession').textContent = adherent.profession || '--';
            document.getElementById('displayEmployeur').textContent = adherent.employeur || '--';
            document.getElementById('displayEmail').textContent = adherent.email || '--';
            document.getElementById('displayTelephone').textContent = adherent.telephone || '--';
            document.getElementById('displayMobile').textContent = adherent.mobile || '--';
            document.getElementById('displayMobile1').textContent = adherent.mobile1 || '--';

            // ===== 2. CONTRAT =====
            document.getElementById('displayDateEffet').textContent = contrat.dateEffet || '--';
            document.getElementById('displayPrimePrincipale').textContent = contrat.primepricipale || '--';
            document.getElementById('displayFraisAdhesion').textContent = contrat.fraisAdhesion || '--';
            document.getElementById('displayCapital').textContent = contrat.capital || '--';
            document.getElementById('displayModePaiement').textContent = contrat.periodicite || '--';
            
            // N° Compte
            const numCompte = document.getElementById('numero_complet')?.textContent || '--';
            document.getElementById('displayNumeroCompte').textContent = numCompte;

            // ===== 3. GARANTIES =====
            const garantiesBody = document.getElementById('garantiesTableBody');
            garantiesBody.innerHTML = '';
            
            // Récupérer les garanties depuis la session ou les données
            const garanties = data.garantiesData || [];
            
            if (garanties.length > 0) {
                garanties.forEach(garantie => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>DECES TOUTES CAUSES INVALIDITE ABSOLUE ET DEFINITIVE</td>
                        <td>16 900 Fcfa</td>
                        <td>4 000 000 Fcfa</td>
                    `;
                    garantiesBody.appendChild(row);
                });
            } else {
                // Garantie par défaut
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>DECES TOUTES CAUSES INVALIDITE ABSOLUE ET DEFINITIVE</td>
                    <td>16 900 Fcfa</td>
                    <td>4 000 000 Fcfa</td>
                `;
                garantiesBody.appendChild(row);
            }

            // ===== 4. ASSURÉS =====
            const tbodyAssure = document.getElementById('resume-tbody-assure');
            tbodyAssure.innerHTML = '';

            if (assures.length > 0) {
                assures.forEach(assure => {
                    const row = document.createElement('tr');
                    // Mettre en évidence le souscripteur
                    if (assure.estSouscripteur) {
                        row.style.backgroundColor = '#e8f4fd';
                        row.style.fontWeight = 'bold';
                    }
                    row.innerHTML = `
                        <td>${assure.nom || '--'} ${assure.estSouscripteur ? '<span class="badge bg-primary">Souscripteur</span>' : ''}</td>
                        <td>${assure.prenom || '--'}</td>
                        <td>${assure.datenaissance || '--'}</td>
                        <td>${assure.lieunaissance || '--'}</td>
                        <td>${assure.lieuresidence || '--'}</td>
                        <td>${assure.filiation || (assure.estSouscripteur ? 'Moi-même' : '--')}</td>
                        <td>${assure.mobile || assure.telephone || '--'}</td>
                        <td>${assure.email || '--'}</td>
                        <td>${assure.numeropiece || '--'}</td>
                    `;
                    tbodyAssure.appendChild(row);
                });
            } else {
                // Si aucun assuré, afficher le souscripteur comme assuré
                const row = document.createElement('tr');
                row.style.backgroundColor = '#e8f4fd';
                row.style.fontWeight = 'bold';
                row.innerHTML = `
                    <td>${adherent.nom || '--'} <span class="badge bg-primary">Souscripteur</span></td>
                    <td>${adherent.prenom || '--'}</td>
                    <td>${adherent.datenaissance || '--'}</td>
                    <td>${adherent.lieunaissance || '--'}</td>
                    <td>${adherent.lieuresidence || '--'}</td>
                    <td>Moi-même</td>
                    <td>${adherent.mobile || adherent.telephone || '--'}</td>
                    <td>${adherent.email || '--'}</td>
                    <td>${adherent.numeropiece || '--'}</td>
                `;
                tbodyAssure.appendChild(row);
            }

            // ===== 5. BÉNÉFICIAIRES =====
            const tbodyBenef = document.getElementById('resume-tbody-benef');
            tbodyBenef.innerHTML = '';

            if (benefs && benefs.length > 0) {
                benefs.forEach(benef => {
                    // Déterminer le type de bénéficiaire
                    let type = '--';
                    let badgeClass = 'bg-secondary';
                    
                    if (benef.type === 'defaut') {
                        type = 'Par défaut';
                        badgeClass = 'bg-primary';
                    } else if (benef.type === 'design' || benef.isDesign) {
                        type = 'Désigné';
                        badgeClass = 'bg-success';
                    } else if (benef.type === 'enfant' || benef.lien === 'Enfant scolarisé') {
                        type = 'Enfant';
                        badgeClass = 'bg-info';
                    } else if (benef.type === 'terme') {
                        type = 'Terme';
                        badgeClass = 'bg-warning';
                    } else if (benef.type === 'deces') {
                        type = 'Décès';
                        badgeClass = 'bg-danger';
                    }

                    // Pour les enfants, afficher le niveau d'étude
                    let infosComplementaires = '';
                    if (benef.type === 'enfant' || benef.lien === 'Enfant scolarisé') {
                        infosComplementaires = `📚 ${benef.niveau || '--'}`;
                        if (benef.observation && benef.observation !== '-') {
                            infosComplementaires += ` (${benef.observation})`;
                        }
                        if (benef.dateNaissance && benef.dateNaissance !== '-') {
                            infosComplementaires = `📅 ${benef.dateNaissance} • ${infosComplementaires}`;
                        }
                    }

                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td><span class="badge ${badgeClass}">${type}</span></td>
                        <td>${benef.nom || '--'}</td>
                        <td>${benef.prenom || '--'}</td>
                        <td>${benef.datenaissance || benef.dateNaissance || '--'}</td>
                        <td>${benef.lieunaissance || '--'}</td>
                        <td>${benef.lieuresidence || '--'}</td>
                        <td>${benef.lien || '--'}</td>
                        <td>${benef.mobile || benef.telephone || '--'}</td>
                        <td>${benef.email || '--'}</td>
                    `;
                    tbodyBenef.appendChild(row);

                    // Ajouter une ligne d'info pour les enfants
                    if (infosComplementaires) {
                        const infoRow = document.createElement('tr');
                        infoRow.style.backgroundColor = '#f8f9fa';
                        infoRow.innerHTML = `
                            <td colspan="9" class="text-muted small">
                                <i class="bx bx-info-circle me-1"></i> ${infosComplementaires}
                            </td>
                        `;
                        tbodyBenef.appendChild(infoRow);
                    }
                });
            } else {
                // Message si aucun bénéficiaire
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td colspan="9" class="text-center text-muted py-3">
                        <i class="bx bx-user-x fs-4 d-block mb-1"></i>
                        Aucun bénéficiaire enregistré
                    </td>
                `;
                tbodyBenef.appendChild(row);
            }

            console.log('✅ Résumé mis à jour avec succès');
        }

        // ===== CHARGER LES DONNÉES =====
        function loadDataAndUpdate() {
            try {
                const data = JSON.parse(sessionStorage.getItem('souscriptionData') || '{}');
                if (Object.keys(data).length > 0) {
                    updateResume(data);
                } else {
                    console.warn('⚠️ Aucune donnée trouvée dans sessionStorage');
                }
            } catch (e) {
                console.error('❌ Erreur lors du chargement des données:', e);
            }
        }

        // ===== ÉCOUTER LES CHANGEMENTS =====
        function setupStorageListener() {
            window.addEventListener('storage', function(e) {
                if (e.key === 'souscriptionData') {
                    try {
                        const data = JSON.parse(e.newValue);
                        if (data && Object.keys(data).length > 0) {
                            updateResume(data);
                        }
                    } catch (error) {
                        console.error('Erreur storage:', error);
                    }
                }
            });
        }

        // ===== VÉRIFIER L'ÉTAPE ACTIVE =====
        function checkActiveStep() {
            const step5 = document.querySelector('[data-step="5"]');
            if (step5 && step5.classList.contains('active')) {
                console.log('📌 Étape 5 active - Chargement du résumé');
                loadDataAndUpdate();
            }
        }

        // ===== OBSERVER LES CHANGEMENTS D'ÉTAPE =====
        function setupStepObserver() {
            const observer = new MutationObserver(function(mutations) {
                mutations.forEach(function(mutation) {
                    if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                        checkActiveStep();
                    }
                });
            });

            // Observer tous les éléments avec data-step
            document.querySelectorAll('[data-step]').forEach(el => {
                observer.observe(el, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });
        }

        // ===== POLLING DE SÉCURITÉ =====
        let lastDataHash = '';
        setInterval(function() {
            try {
                const data = JSON.parse(sessionStorage.getItem('souscriptionData') || '{}');
                const currentHash = JSON.stringify(data);
                if (currentHash !== lastDataHash && Object.keys(data).length > 0) {
                    lastDataHash = currentHash;
                    console.log('🔄 Mise à jour automatique du résumé');
                    updateResume(data);
                }
            } catch (e) {
                // Ignorer les erreurs
            }
        }, 2000);

        // ===== INITIALISATION =====
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🚀 Initialisation de la page résumé');
            
            // Charger les données immédiatement
            loadDataAndUpdate();
            
            // Configurer les écouteurs
            setupStorageListener();
            setupStepObserver();
            
            // Vérifier l'étape active
            checkActiveStep();
            
            console.log('✅ Résumé initialisé');
        });

        // Exposer la fonction pour un usage externe
        window.updateResume = updateResume;
        window.loadDataAndUpdate = loadDataAndUpdate;

        // Initialiser au chargement
        if (document.readyState === 'complete') {
            loadDataAndUpdate();
        } else {
            document.addEventListener('DOMContentLoaded', loadDataAndUpdate);
        }
    });
</script>