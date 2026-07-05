<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mise à jour du dossier</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --brand: #0F7B4B;
            --brand-dark: #0a5c38;
            --brand-light: #E8F5EE;
        }

        body {
            background-color: #f4f5f7;
        }

        .step-item {
            cursor: pointer;
            transition: all .15s;
            border-left: 3px solid transparent;
        }

        .step-item.active {
            background: var(--brand-light);
            border-left-color: var(--brand);
            color: var(--brand);
            font-weight: 600;
        }

        .step-badge {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #EAECF0;
            color: #8A919E;
            font-size: 12px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .step-item.active .step-badge {
            background: var(--brand);
            color: #fff;
        }

        /* Bulletin */
        .bulletin {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #1e1e1e;
        }

        .bulletin .section-card .card-header {
            background: var(--brand);
            color: #fff;
            font-weight: 700;
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .bulletin label.field-label {
            font-size: 10.5px;
            text-transform: uppercase;
            font-weight: 600;
            color: #8A919E;
            letter-spacing: .3px;
            margin-bottom: 2px;
        }

        .bulletin .form-control-plaintext {
            padding: .1rem 0;
            border-bottom: 1px solid #d8dde3;
            min-height: 26px;
            font-weight: 600;
            color: #1e1e1e;
        }

        .bulletin .form-check-input:checked {
            background-color: var(--brand);
            border-color: var(--brand);
        }

        .modalite-banner {
            background: var(--brand);
            color: #fff;
        }

        .modalite-banner .badge {
            background: rgba(255, 255, 255, .18);
            font-weight: 600;
            font-size: 11.5px;
            padding: .45em .8em;
        }

        .bulletin thead th {
            background: var(--brand);
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: 600;
            border-color: var(--brand-dark);
        }

        .bulletin .table > :not(caption) > * > * {
            padding: .55rem .6rem;
        }

        /* Toast */
        .toast {
            position: fixed;
            bottom: 24px;
            right: 24px;
            background: var(--brand);
            color: #fff;
            padding: 12px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 4px 20px rgba(0, 0, 0, .15);
            display: none;
            align-items: center;
            gap: 8px;
            z-index: 999;
        }

        .toast.show {
            display: flex;
            animation: slideUp .25s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .form-control:focus {
            border-color: var(--brand) !important;
            box-shadow: 0 0 0 0.2rem rgba(15, 123, 75, 0.25) !important;
        }

        .btn-primary-custom {
            background-color: var(--brand);
            border-color: var(--brand);
            color: white;
        }

        .btn-primary-custom:hover {
            background-color: #1a9a60;
            border-color: #1a9a60;
            color: white;
        }

        .bg-primary-custom { background-color: var(--brand); }
        .text-primary-custom { color: var(--brand); }
        .bg-primary-light { background-color: var(--brand-light); }

        @media print {
            header, .col-lg-3, .card-footer, .toast { display: none !important; }
            .col-lg-9 { width: 100% !important; flex: 0 0 100% !important; max-width: 100% !important; }
            body { background: #fff; }
            .card { box-shadow: none !important; border: none !important; }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header class="bg-white border-bottom px-4 py-3 d-flex align-items-center gap-3 shadow-sm">
        <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0 bg-primary-custom" style="width:36px;height:36px;">
            <i class="bi bi-shield-check text-white fs-5"></i>
        </div>
        <span class="fw-semibold text-dark">Mise à jour du dossier</span>
        <span class="badge bg-primary-light text-primary-custom ms-auto d-none d-sm-inline-flex align-items-center gap-1">
            <i class="bi bi-file-earmark-text"></i> Étape 1 / 1
        </span>
    </header>

    <div class="container py-4">
        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-lg-3">
                <div class="card shadow-sm sticky-top" style="top:20px;">
                    <div class="card-header bg-white border-bottom">
                        <span class="text-xs fw-bold text-uppercase text-secondary">Sections</span>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="#" class="step-item list-group-item list-group-item-action border-0 active d-flex align-items-center gap-2 py-3" data-step="1">
                            <span class="step-badge">1</span>
                            <span class="small">Bulletin d'adhésion</span>
                            <i class="bi bi-check-circle-fill ms-auto text-primary-custom"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Main panel -->
            <div class="col-lg-9">
                <div class="card shadow-sm border-0">
                    <!-- Progress bar -->
                    <div class="progress rounded-0" style="height:4px;">
                        <div class="progress-bar bg-primary-custom" style="width:100%"></div>
                    </div>

                    <!-- ════ STEP 1 — Résumé ════ -->
                    <div class="step-section active" id="section-1">
                        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div>
                                <h2 class="h5 fw-bold text-dark mb-0">Bulletin d'adhésion</h2>
                                <p class="small text-secondary mt-1 mb-0">Bulletin d'adhésion <span class="text-uppercase">Tresor Solidaire</span></p>
                            </div>
                            {{-- <button class="btn btn-outline-secondary btn-sm d-print-none" onclick="window.print()">
                                <i class="bi bi-printer"></i> Imprimer
                            </button> --}}
                        </div>

                        <div class="card-body bg-light">
                            <div class="bulletin bg-white border rounded-3 overflow-hidden shadow-sm">
                                <div class="p-3 p-md-4 border-top border-4 border-primary-custom">

                                    <!-- HEADER DOCUMENT -->
                                    <div class="border-bottom border-2 border-primary-custom pb-3 mb-4">
                                        <div class="row align-items-center g-2">
                                            <div class="col-3 d-none d-md-block">
                                                <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('root/images/logo.png'))) }}"
                                                    alt="Logo" style="width: 70px; max-width: 100%;">
                                            </div>
                                            <div class="col-12 col-md-6 text-center">
                                                <div class="h5 fw-bold text-primary-custom mb-0">Formulaire d'adhésion <br> <span class="text-uppercase">Tresor Solidaire</span></div>
                                            </div>
                                            <div class="col-3 d-none d-md-block text-end">
                                                <img src="data:image/jpg;base64,{{ base64_encode(file_get_contents(public_path('logos/TRESOR.png'))) }}"
                                                    alt="Logo" style="width: 70px; max-width: 100%;">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SECTION 1 : INFOS ASSURÉ -->
                                    <div class="card section-card mb-3 border">
                                        <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center">
                                            <span>1. Informations de l'assuré</span>
                                            <span class="badge bg-white text-primary-custom">Individuel</span>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-3">
                                                <div class="col-12">
                                                    <label class="field-label d-block">Nom et Prénom</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->nom }} {{ $contrat->assures[0]->prenom }}</div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mt-1">
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Date de naissance</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->datenaissance }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Lieu de naissance</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->lieunaissance }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Nationalité</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->nationalite }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Sexe</label>
                                                    <div class="d-flex align-items-center gap-3 pt-1">
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="radio" disabled {{ $contrat->assures[0]->civilite === 'M' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">M</label>
                                                        </div>
                                                        <div class="form-check mb-0">
                                                            <input class="form-check-input" type="radio" disabled {{ $contrat->assures[0]->civilite === 'F' ? 'checked' : '' }}>
                                                            <label class="form-check-label small">F</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mt-1">
                                                <div class="col-6 col-md-4">
                                                    <label class="field-label d-block">Fonction</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->profession }}</div>
                                                </div>
                                                <div class="col-6 col-md-4">
                                                    <label class="field-label d-block">Type de pièce</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->naturepiece }}</div>
                                                </div>
                                                <div class="col-12 col-md-4">
                                                    <label class="field-label d-block">N° de pièce</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->numeropiece }}</div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mt-1">
                                                <div class="col-12">
                                                    <label class="field-label d-block">Adresse complète</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->lieuresidence }}</div>
                                                </div>
                                            </div>

                                            <div class="row g-3 mt-1">
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Tél 1</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->mobile }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">Tél 2</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->tel2 }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">WhatsApp</label>
                                                    <div class="form-control-plaintext">{{ $contrat->assures[0]->whatsapp }}</div>
                                                </div>
                                                <div class="col-6 col-md-3">
                                                    <label class="field-label d-block">E-mail</label>
                                                    <div class="form-control-plaintext text-truncate">{{ $contrat->assures[0]->email }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- MODALITÉ -->
                                    <div class="modalite-banner rounded-3 py-2 px-3 mb-3 d-flex flex-wrap gap-2 align-items-between justify-content-between">
                                        {{-- <span class="badge d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-check-circle-fill"></i> Modalité : Annuel
                                        </span> --}}
                                        <span class="badge d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-calendar-range"></i> Durée : 1 an Tacite reconduction
                                        </span>
                                        <span class="badge d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-calendar-event"></i> Début de contrat : 01/07/2026
                                        </span>
                                        <span class="badge d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-cash-stack"></i> Capital souscrit : 4 000 000 FCFA
                                        </span>
                                    </div>
                                    <div class="bg-light rounded-3 py-2 px-3 mb-3 ">
                                        <span ><i class="bi bi-people-fill me-1"></i> Bénéficiaire par defaut : </span> 
                                        <span >Fonds de soutien aux études et à la formation des orphélins</span>
                                    </div>

                                    <!-- ENFANTS -->
                                    <div class="card section-card border">
                                        <div class="card-header py-2 px-3">
                                            <i class="bi bi-people-fill me-1"></i> 2. Bénéficiaires (Enfants scolarisés)
                                        </div>
                                        <div class="card-body p-0">
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover align-middle mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:10%">N°</th>
                                                            <th style="width:35%">Nom et Prénoms</th>
                                                            <th style="width:25%">Date naissance</th>
                                                            <th style="width:30%">Niveau d'étude</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @forelse ($contrat->beneficiaires as $index => $beneficiaire)
                                                            <tr>
                                                                <td class="text-primary-custom fw-bold text-center">{{ $index + 1 }}</td>
                                                                <td>{{ $beneficiaire->nom ?? '' }} {{ $beneficiaire->prenom ?? '' }}</td>
                                                                <td>{{ \Carbon\Carbon::parse($beneficiaire->date_naissance)->format('d/m/Y') ?? '' }}</td>
                                                                <td>{{ $beneficiaire->bp ?? '' }}</td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center text-secondary py-3">Aucun enfant déclaré</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- PAIEMENT -->
                                    <table class="w-100 border mt-2">
                                        <tr><td class="bg-primary-custom text-white fw-bold px-3 py-1">Paiement des Primes</td></tr>
                                        <tr><td class="p-3">
                                            <p class="small mb-1">Le montant total des primes est payé par :</p>
                                            <ul class="list-unstyled m-0">
                                                <li class="py-1 border-bottom border-dashed small">Le Souscripteur (DGTCP) <span class="text-gray-400">Le versement étant effectué par l'intermédiaire du Fonds d'Entraide des Agents du Trésor.</span></li>
                                            </ul>
                                        </td></tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    

                    <!-- Footer -->
                    <div class="card-footer bg-white d-flex justify-content-between align-items-center d-print-none">
                        <span class="small text-secondary d-none d-sm-inline">
                            <i class="bi bi-info-circle"></i> Vérifiez les informations avant de confirmer.
                        </span>
                        <button class="btn btn-primary-custom btn-sm px-4" id="btnSubmit">
                            Confirmer <i class="bi bi-arrow-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast -->
    <div class="toast" id="toast">
        <i class="bi bi-check-circle-fill"></i>
        <span id="toastMessage">Dossier accepté avec succès !</span>
    </div>

    <!-- SweetAlert2 (chargé avant l'usage) -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitBtn = document.getElementById('btnSubmit');
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            // Configuration Axios
            axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken;
            axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

            // Récupération des données depuis la base
            function getFormData() {
                return {
                    civilite: document.getElementById('civilite')?.value || '',
                    nom: document.getElementById('nom')?.value || '',
                    prenom: document.getElementById('prenom')?.value || '',
                    datenaissance: document.getElementById('datenaissance')?.value || '',
                    lieunaissance: document.getElementById('lieunaissance')?.value || '',
                    nationalite: document.getElementById('nationalite')?.value || '',
                    naturepiece: document.getElementById('naturepiece')?.value || '',
                    numeropiece: document.getElementById('numeropiece')?.value || '',
                    lieuresidence: document.getElementById('lieuresidence')?.value || '',
                    profession: document.getElementById('profession')?.value || '',
                    employeur: document.getElementById('employeur')?.value || '',
                    mobile: document.getElementById('mobile')?.value || '',
                    tel2: document.getElementById('tel2')?.value || '',
                    whatsapp: document.getElementById('whatsapp')?.value || '',
                    email: document.getElementById('email')?.value || ''
                };
            }

            // Affichage du toast
            function showToast(message = 'Dossier accepté avec succès !') {
                toastMessage.textContent = message;
                toast.classList.add('show');
                setTimeout(() => toast.classList.remove('show'), 4000);
            }

            // Gestion de la soumission
            async function handleSubmit() {
                const formData = getFormData();

                // Vérification des champs obligatoires
                const requiredFields = ['nom', 'prenom', 'datenaissance', 'mobile', 'email'];
                const emptyFields = requiredFields.filter(field => !formData[field]);

                // if (emptyFields.length > 0) {
                //     showToast('⚠️ Veuillez remplir tous les champs obligatoires');
                //     return;
                // }

                // Confirmation Swal
                const { isConfirmed } = await Swal.fire({
                    title: 'Êtes-vous sûr ?',
                    text: "Vous êtes sur le point de soumettre le dossier. Veuillez vérifier toutes les informations avant de continuer.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#0F7B4B',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Oui, soumettre',
                    cancelButtonText: 'Annuler'
                });

                if (!isConfirmed) return;

                // Désactivation du bouton
                submitBtn.disabled = true;
                submitBtn.innerHTML = '⏳ Soumission en cours...';

                try {
                    const response = await axios.post('{{ route('link.update', ['id' => $contrat->id]) }}', formData, {
                        headers: { 'Content-Type': 'application/json' }
                    });

                    if (response.data.status === 'success') {
                        showToast('✅ Dossier accepté avec succès !');
                        setTimeout(() => {
                            window.location.href = '/link/success/' + {{ $contrat->id }};
                        }, 1000);
                    } else {
                        showToast('❌ Une erreur est survenue');
                    }
                } catch (error) {
                    console.error('Erreur :', error);
                    const errorMessage = error.response?.data?.message || 'Une erreur est survenue. Veuillez réessayer.';
                    showToast('❌ ' + errorMessage);
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = 'Je donne mon accord <i class="bi bi-arrow-right"></i>';
                }
            }

            // Écouteur d'événement
            submitBtn.addEventListener('click', handleSubmit);
        });
    </script>

</body>

</html>