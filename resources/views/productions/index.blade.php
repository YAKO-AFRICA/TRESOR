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
                    <li class="breadcrumb-item active" aria-current="page">Mes Propositions</li>
                </ol>
            </nav>
        </div>
    </div>
    <!--end breadcrumb-->

    <div class="card">
        <div class="card-body">
            <div class="d-lg-flex align-items-center mb-4 gap-3">
                <form action="{{ route('prod.index') }}" method="get" class="d-flex flex-wrap align-items-center gap-2">
                    <div class="position-relative">
                        <select id="statusFilter" name="etape" class="form-select">
                            <option value="">Tous les statuts</option>
                            {{-- <option value="0">Saisie non achevée</option> --}}
                            <option value="1" {{ request('etape') == '1' ? 'selected' : '' }}>Lien Envoyé</option>
                            <option value="2" {{ request('etape') == '2' ? 'selected' : '' }}>Accord donné</option>
                            <option value="3" {{ request('etape') == '3' ? 'selected' : '' }}>Accepté</option>
                            <option value="4" {{ request('etape') == '4' ? 'selected' : '' }}>Rejeté</option>
                        </select>
                    </div>
                    <select name="observation" class="form-select" aria-label="Filtrer par observation">
                        <option value="">Toutes les observations</option>
                        <option value="avec" {{ request('observation') == 'avec' ? 'selected' : '' }}>Avec observation</option>
                        <option value="sans" {{ request('observation') == 'sans' ? 'selected' : '' }}>Sans observation</option>
                    </select>
                    <input type="search" name="recherche" class="form-control" value="{{ request('recherche') }}" placeholder="Rechercher dans les observations">
                    <button type="submit" class="btn btn-outline-primary">Filtrer</button>
                </form>
                <div class="ms-auto">
                    <a href="{{ route('prod.stepProduct') }}" class="btn btn-primary radius-30 mt-2 mt-lg-0">
                    <i class="bx bxs-plus-square"></i>Nouvelle proposition
                    </a>
                </div>
            </div>


            <div class="table-responsive">

                <!-- Tableau -->
                <table class="table mb-0" id="example2">
                    <thead class="table-light">
                        <tr>
                            @foreach ($defaultColumns as $defaultColumn)
                                <th>{{ $defaultColumn }}</th>
                            @endforeach
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($datas['allPropositionsFiltered'] as $item)
                        <tr class="articleByCat {{ trim((string) $item->details) !== '' ? 'table-warning' : '' }}" data-status="{{ strtolower($item->etape) }}">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->adherent->nom ?? "" }} {{ $item->adherent->prenom ?? "" }}</td>
                            <td>{{ $item->beneficiaires_count }}</td>
                            <td>{{ $item->adherent->datenaissance ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->dateeffet)->locale('fr')->translatedFormat('d M Y') ?? '' }}</td>
                            <td>{{ $item->prime ?? "" }}</td>
                            <td>{{ $item->capital ?? 0 }}</td>
                            <td>
                                @if ($item->etape == '0')
									<div class="badge rounded-pill text-secondary bg-light-secondary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Saisie non achevée</div>
								@elseif ($item->etape == '1')
									<div class="badge rounded-pill text-info bg-light-info p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Lien envoyé</div>
								@elseif ($item->etape == '2')
									<div class="badge rounded-pill text-primary bg-light-primary p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Accord donné</div>
								@elseif ($item->etape == '3')
									<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Accepté</div>
								@elseif ($item->etape == '4')
									<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class='bx bxs-circle me-1'></i>Rejeté</div>
								@endif
                            </td>

                            <td>
                                @if (trim((string) $item->details) !== '')
                                    <span class="badge rounded-pill text-warning bg-light-warning me-1">À suivre</span>
                                    <span title="{{ $item->details }}">{{ Str::limit(trim($item->details), 120) }}</span>
                                @else
                                    <span class="text-muted">Aucune observation</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex order-actions">
                                    <a href="{{ route('prod.show', $item->id)}}">
                                        <i class='bx bxs-show'></i>
                                    </a>
                                    @if (!in_array($item->etape, [2, 3]))

                                        @can('Modifier une souscription')
                                            <a href="{{ route('prod.edit', $item->id)}}" class="ms-3">
                                                <i class='bx bxs-edit'></i>
                                            </a>
                                        @endcan


                                        @can('Suprimer une souscription')
                                            <a class="deleteConfirmation ms-3" data-uuid="{{$item->id}}"
                                                data-type="confirmation_redirect" data-placement="top"
                                                data-token="{{ csrf_token() }}"
                                                data-url="{{route('prod.destroy',$item->id)}}"
                                                data-title="Vous êtes sur le point de supprimer la proposition N° {{$item->id}} "
                                                data-id="{{$item->id}}" data-param="0"
                                                data-route="{{route('prod.destroy',$item->id)}}"><i
                                                    class='bx bxs-trash' style="cursor: pointer"></i>
                                            </a>
                                        @endcan

                                    @else
                                    <a href="javascript:;" class="ms-3 text-muted" title="Vous ne pouvez pas modifier une proposition transmise ou migrer">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <a class="ms-3 text-muted" data-uuid="{{$item->id}}" title="Vous ne pouvez pas supprimer une proposition transmise ou migrer">

                                        <i class='bx bxs-trash' style="cursor: pointer"></i>
                                    </a>
                                    @endif


                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="{{ count($defaultColumns) + 1 }}">Aucun contrat trouvé</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                let statusSelect = document.getElementById('statusFilter');
                statusSelect.addEventListener('change', function () {
                    this.form.submit();
                });
            });
        </script>

</div>
@endsection
