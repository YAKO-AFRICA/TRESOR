
<!-- Modal pour chaque assuré -->
@if($nbEnfants > 0)
<div class="modal fade modal-enfants" id="modalEnfants{{ $index }}" tabindex="-1" role="dialog" aria-labelledby="modalEnfantsLabel{{ $index }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content shadow-lg">
            <div class="modal-header" style="background: linear-gradient(135deg, #076603 0%, #083306 100%);">
                <h5 class="modal-title text-white" id="modalEnfantsLabel{{ $index }}">
                    <i class="fas fa-child mr-2"></i>
                    Enfants de <strong>{{ $assure['nom'] }} {{ $assure['prenoms'] }}</strong>
                    <span class="badge badge-light ml-2">{{ $nbEnfants }}</span>
                </h5>
                <button type="button" class="close text-danger px-2" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 500px; overflow-y: auto;">
                @if($nbEnfants > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Matricule</th>
                                <th>Nom</th>
                                <th>Prénoms</th>
                                <th>Genre</th>
                                <th>Date naissance</th>
                                <th>Niveau étude</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enfantsAssure as $enfantIndex => $enfant)
                            <tr>
                                <td>{{ $enfantIndex + 1 }}</td>
                                <td><code>{{ $enfant['matricule'] }}</code></td>
                                <td>{{ $enfant['nom'] }}</td>
                                <td>{{ $enfant['prenoms'] }}</td>
                                <td>
                                    <span class="badge badge-{{ $enfant['genre'] == 'M' ? 'primary' : 'danger' }} px-3 py-2 text-{{ $enfant['genre'] == 'M' ? 'primary' : 'danger' }}">
                                        <i class="fas fa-{{ $enfant['genre'] == 'M' ? 'mars' : 'venus' }} mr-1"></i>
                                        {{ $enfant['genre'] }}
                                    </span>
                                </td>
                                <td>
                                    @if($enfant['date_naissance'])
                                        <i class="fas fa-calendar-alt text-muted mr-1"></i>
                                        {{ \Carbon\Carbon::parse($enfant['date_naissance'])->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">Non renseigné</span>
                                    @endif
                                </td>
                                <td>
                                    @if($enfant['niveau_etude'])
                                        <span class="badge badge-secondary text-secondary">
                                            {{ $enfant['niveau_etude'] }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-5">
                    <i class="fas fa-child fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Aucun enfant trouvé pour cet assuré</p>
                </div>
                @endif
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between w-100 align-items-center">
                    <div>
                        <span class="text-muted">
                            <i class="fas fa-users mr-1"></i>
                            Total : <strong class="text-primary">{{ $nbEnfants }}</strong> enfant(s)
                        </span>
                        <span class="text-muted ml-3">
                            <i class="fas fa-venus-mars mr-1"></i>
                            <span class="badge badge-primary">M: {{ $enfantsAssure->where('genre', 'M')->count() }}</span>
                            <span class="badge badge-danger ml-1">F: {{ $enfantsAssure->where('genre', 'F')->count() }}</span>
                        </span>
                    </div>
                    <div>
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">
                            <i class="fas fa-times mr-1"></i>
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif