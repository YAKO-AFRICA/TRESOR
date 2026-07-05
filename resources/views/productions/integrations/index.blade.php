@extends('layouts.main')

@section('content')
<div class="page-content">
    <!--breadcrumb-->
    <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
        <div class="breadcrumb-title pe-3"><a href="/shared/home"><i class="bx bx-home-alt"></i></a></div>
        <div class="ps-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item active" aria-current="page">Productions</li>
                    <li class="breadcrumb-item active" aria-current="page">Intégration de fichier </li>
                </ol>
            </nav>
        </div>
        <div class="ms-auto">

        </div>
    </div>
    <!--end breadcrumb-->
    <div class="container-fluid">
        <!-- Messages d'alerte -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check-circle"></i> Succès !</h5>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-times-circle"></i> Erreur !</h5>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-bs-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Attention !</h5>
                <p>{{ session('warning') }}</p>
                @if(session('error_details'))
                    <hr>
                    <ul>
                        @foreach(session('error_details') as $detail)
                            <li>{{ $detail }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        @endif

        @include('productions.integrations.importFichier')

        <!-- Section des résultats -->
        @if(isset($assures) && count($assures) > 0)
        <div class="row mt-4">
            <div class="col-md-12">
                <div class="card card-success card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="fas fa-chart-bar mr-2"></i>
                            Rapport d'intégration
                        </h3>
                        <div class="card-tools float-end">
                          <div class="btn-group">
                                <form action="{{ route('integrations.valider') }}" method="POST" class="d-inline mx-3" id="validationForm">
                                    @csrf
                                    <button type="button" class="btn btn-success btn-sm" onclick="confirmValidation()">
                                        <i class="lni lni-checkbox mr-1 fs-6"></i>
                                        Valider les données
                                    </button>
                                </form>
                                <form action="{{ route('integrations.annuler') }}" method="POST" class="d-inline ml-1" id="annulationForm">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmAnnulation()">
                                        <i class="lni lni-close mr-1 fs-6"></i>
                                        Annuler
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Statistiques -->
                        <div class="row mb-4">
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-info">
                                    <div class="inner text-white">
                                        <h3 class="text-white">{{ $rapport['total_assures'] ?? 0 }}</h3>
                                        <p>Nombre d'assurés dans le fichier
</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-success">
                                    <div class="inner text-white">
                                        <h3 class="text-white">{{ $rapport['valides'] ?? 0 }}</h3>
                                        <p>Nombre d'assurés intégrés</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-danger">
                                    <div class="inner text-white">
                                        <h3 class="text-white">{{ count($rapport['erreurs'] ?? []) }}</h3>
                                        <p>Nombre d'assurés non intégrés</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="small-box bg-warning">
                                    <div class="inner text-white">
                                        <h3 class="text-white">{{ $rapport['enfants_total'] ?? 0 }}</h3>
                                        <p>Nombre d'enfants dans le fichier</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-child"></i>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Onglets -->
                        <ul class="nav nav-tabs" id="dataTabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="assures-tab" data-bs-toggle="tab" href="#assures" role="tab">
                                    <i class="fas fa-user-circle mr-1"></i>
                                    Assurés integrés
                                    <span class="badge badge-success ml-1">{{ count($assures) }}</span>
                                </a>
                            </li>
                            @if(isset($rapport['erreurs']) && count($rapport['erreurs']) > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="erreurs-assures-tab" data-bs-toggle="tab" href="#erreurs-assures" role="tab">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Erreurs assurés
                                    <span class="badge badge-danger ml-1">{{ count($rapport['erreurs']) }}</span>
                                </a>
                            </li>
                            @endif
                            @if(isset($enfants) && count($enfants) > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="enfants-tab" data-bs-toggle="tab" href="#enfants" role="tab">
                                    <i class="fas fa-child mr-1"></i>
                                    Enfants importés
                                    <span class="badge badge-info ml-1">{{ count($enfants) }}</span>
                                </a>
                            </li>
                            @endif
                            @if(isset($rapport['enfants_erreurs']) && count($rapport['enfants_erreurs']) > 0)
                            <li class="nav-item">
                                <a class="nav-link" id="erreurs-enfants-tab" data-bs-toggle="tab" href="#erreurs-enfants" role="tab">
                                    <i class="fas fa-exclamation-triangle mr-1"></i>
                                    Erreurs enfants
                                    <span class="badge badge-warning ml-1">{{ count($rapport['enfants_erreurs']) }}</span>
                                </a>
                            </li>
                            @endif
                        </ul>

                        <div class="tab-content mt-3" id="dataTabsContent">
                            <!-- Tab Assurés valides -->
                            <div class="tab-pane fade show active" id="assures" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="assuresTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Matricule</th>
                                                <th>Nom</th>
                                                <th>Prénoms</th>
                                                <th>Genre</th>
                                                <th>Date naissance</th>
                                                <th>Lieu naissance</th>
                                                <th>Téléphone</th>
                                                <th>Email</th>
                                                <th>Enfants</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($assures as $index => $assure)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><code>{{ $assure['matricule'] }}</code></td>
                                                <td>{{ $assure['nom'] }}</td>
                                                <td>{{ $assure['prenoms'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $assure['genre'] == 'M' ? 'primary' : 'danger' }} text-{{ $assure['genre'] == 'M' ? 'primary' : 'danger' }}">
                                                        {{ $assure['genre'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $assure['date_naissance'] }}</td>
                                                <td>{{ $assure['lieu_naissance'] }}</td>
                                                <td>{{ $assure['numero_tel'] }}</td>
                                                <td>{{ $assure['email'] }}</td>
                                                <td>
                                                    @php
                                                        $enfantsAssure = collect($enfants)->where('matricule', $assure['matricule']);
                                                        $nbEnfants = $enfantsAssure->count();
                                                    @endphp
                                                    @if($nbEnfants > 0)
                                                        <div class="d-flex align-items-center">
                                                            <span class="badge badge-info badge-pill px-1 py-2 text-info">
                                                                <i class="fas fa-child mr-1"></i>
                                                                {{ $nbEnfants }}
                                                            </span>
                                                            <button type="button" class="btn btn-sm btn-outline-info ml-2 btn-enfants"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#modalEnfants{{ $index }}"
                                                                    data-nb-enfants="{{ $nbEnfants }}"
                                                                    title="Voir les {{ $nbEnfants }} enfants">
                                                                <i class="lni lni-magnifier fs-6"></i>
                                                            </button>
                                                        </div>
                                                        @include('productions.integrations.showEnf' )
                                                    @else
                                                        <span class="badge badge-secondary badge-pill px-1 py-2 text-secondary">
                                                            <i class="lni lni-magnifier mr-1"></i>
                                                            0
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <!-- Tab Erreurs assurés -->
                            @if(isset($rapport['erreurs']) && count($rapport['erreurs']) > 0)
                            <div class="tab-pane fade" id="erreurs-assures" role="tabpanel">
                                <div class="alert alert-danger">
                                    <h5><i class="icon fas fa-ban"></i> Erreurs dans le fichier des assurés</h5>
                                    <table class="table table-bordered table-striped" id="erreursAssuresTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ligne</th>
                                                <th>Message</th>
                                                <th>Données</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rapport['erreurs'] as $index => $erreur)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="badge badge-danger">{{ $erreur['ligne'] }}</span></td>
                                                <td>
                                                    <span class="text-danger">
                                                        <i class="fas fa-times-circle mr-1"></i>
                                                        {{ $erreur['message'] }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <pre class="mb-0" style="max-height: 100px; overflow-y: auto; background: #f8f9fa; padding: 8px; border-radius: 4px;">
                                                        {{ json_encode($erreur['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                                    </pre>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            <!-- Tab Enfants importés -->
                            @if(isset($enfants) && count($enfants) > 0)
                            <div class="tab-pane fade" id="enfants" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover" id="enfantsTable">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>#</th>
                                                <th>Matricule parent</th>
                                                <th>Nom</th>
                                                <th>Prénoms</th>
                                                <th>Genre</th>
                                                <th>Date naissance</th>
                                                <th>Niveau étude</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($enfants as $index => $enfant)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><code>{{ $enfant['matricule'] }}</code></td>
                                                <td>{{ $enfant['nom'] }}</td>
                                                <td>{{ $enfant['prenoms'] }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $enfant['genre'] == 'M' ? 'primary' : 'danger' }}">
                                                        {{ $enfant['genre'] }}
                                                    </span>
                                                </td>
                                                <td>{{ $enfant['date_naissance'] }}</td>
                                                <td>{{ $enfant['niveau_etude'] }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif

                            <!-- Tab Erreurs enfants -->
                            @if(isset($rapport['enfants_erreurs']) && count($rapport['enfants_erreurs']) > 0)
                            <div class="tab-pane fade" id="erreurs-enfants" role="tabpanel">
                                <div class="alert alert-warning">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Erreurs dans le fichier des enfants</h5>
                                        <div>
                                            <span class="badge badge-warning badge-pill mr-2 text-danger">
                                                <i class="lni lni-alarm mr-1 text-danger"></i>
                                                {{ count($rapport['enfants_erreurs']) }} erreurs
                                            </span>
                                            <button class="btn btn-success btn-sm" onclick="telechargerErreursExcel()">
                                                <i class="lni lni-cloud-upload mr-1"></i>
                                                Télécharger le rapport
                                            </button>
                                        </div>
                                    </div>
                                    <table class="table table-bordered table-striped" id="erreursEnfantsTable">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ligne</th>
                                                <th>Message</th>
                                                <th>Données</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($rapport['enfants_erreurs'] as $index => $erreur)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td><span class="badge badge-warning">{{ $erreur['ligne'] }}</span></td>
                                                <td>
                                                    <span class="text-danger">
                                                        <i class="fas fa-exclamation-circle mr-1"></i>
                                                        {{ $erreur['message'] ?? 'Erreur non spécifiée' }}
                                                    </span>
                                                    @if(isset($erreur['message_original']) && is_array($erreur['message_original']))
                                                        <br>
                                                        <small class="text-muted">
                                                            <i class="fas fa-info-circle mr-1"></i>
                                                            Détails: {{ implode(', ', $erreur['message_original']) }}
                                                        </small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <pre class="mb-0" style="max-height: 100px; overflow-y: auto; background: #f8f9fa; padding: 8px; border-radius: 4px;">
                                                        {{ json_encode($erreur['data'], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}
                                                    </pre>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- @push('scripts') --}}
    <script>
        // Gestion des noms de fichiers
        document.querySelectorAll('.custom-file-input').forEach(function(input) {
            input.addEventListener('change', function(e) {
                var fileName = e.target.files[0] ? e.target.files[0].name : 'Choisir un fichier...';
                var label = e.target.nextElementSibling;
                label.innerHTML = '<i class="fas fa-file-excel mr-1"></i> ' + fileName;
            });
        });

        // Téléchargement des erreurs enfants en Excel
        function telechargerErreursExcel() {
            const table = document.getElementById('erreursEnfantsTable');
            if (!table) {
                alert('Aucune erreur à exporter');
                return;
            }

            const rows = table.querySelectorAll('tbody tr');
            if (rows.length === 0) {
                alert('Aucune erreur à exporter');
                return;
            }

            let csvContent = "#,Ligne,Message,Données\n";

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                const num = cells[0].textContent.trim();
                const ligne = cells[1].textContent.trim();
                const message = cells[2].textContent.replace(/\n/g, ' ').replace(/,/g, ';').trim();
                const donnees = cells[3].textContent.replace(/\n/g, ' ').replace(/,/g, ';').trim();
                csvContent += `${num},"${ligne}","${message}","${donnees}"\n`;
            });

            const blob = new Blob(["\uFEFF" + csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            link.setAttribute('href', url);
            link.setAttribute('download', `rapport_erreurs_enfants_${new Date().toISOString().split('T')[0]}.csv`);
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
            URL.revokeObjectURL(url);
        }

        // Initialiser DataTables si disponible
        @if(isset($assures) && count($assures) > 0)
        $(document).ready(function() {
            if ($.fn.DataTable) {
                $('#assuresTable').DataTable({
                    "pageLength": 25,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                    }
                });
                @if(isset($enfants) && count($enfants) > 0)
                $('#enfantsTable').DataTable({
                    "pageLength": 25,
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/French.json"
                    }
                });
                @endif
            }
        });
        @endif
    </script>
    {{-- @endpush --}}

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    function confirmValidation() {
        Swal.fire({
            title: 'Validation des données',
            text: 'Voulez-vous vraiment valider ces données ?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, valider',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('validationForm').submit();
            }
        });
    }

    function confirmAnnulation() {
        Swal.fire({
            title: 'Annulation de l\'importation',
            text: 'Voulez-vous vraiment annuler cette importation ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, annuler',
            cancelButtonText: 'Non',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('annulationForm').submit();
            }
        });
    }
    </script>

    {{-- @push('styles') --}}
    <style>
        /* Cartes et statistiques */
        .small-box {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .small-box:hover {
            transform: translateY(-5px);
        }
        .small-box .inner {
            padding: 15px;
        }
        .small-box .icon {
            font-size: 50px;
            opacity: 0.3;
        }

        /* Onglets */
        .nav-tabs .nav-link {
            border-radius: 4px 4px 0 0;
            padding: 10px 20px;
            font-weight: 500;
        }
        .nav-tabs .nav-link.active {
            border-top: 3px solid #28a745;
        }

        /* Badges */
        .badge-pill {
            padding: 5px 12px;
        }

        /* Tables */
        .table thead th {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
        }
        .table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Pre */
        pre {
            background: #f8f9fa;
            padding: 8px;
            border-radius: 4px;
            font-size: 12px;
            max-height: 100px;
            overflow-y: auto;
            border: 1px solid #e9ecef;
        }

        /* Alertes */
        .alert {
            border-radius: 8px;
            border-left: 4px solid;
        }
        .alert-success {
            border-left-color: #28a745;
        }
        .alert-danger {
            border-left-color: #dc3545;
        }
        .alert-warning {
            border-left-color: #ffc107;
        }

        /* Boutons */
        .btn-lg {
            padding: 10px 30px;
            border-radius: 8px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        /* Custom file input */
        .custom-file-label::after {
            content: "Parcourir";
        }
        .custom-file-input:focus ~ .custom-file-label {
            border-color: #80bdff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
    </style>
    {{-- @endpush --}}
</div>
@endsection
