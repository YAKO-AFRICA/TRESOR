@extends('layouts.main')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Prévisualisation des données</h3>
            <div class="card-tools">
                <span class="badge badge-info">Total: {{ count($data) }} lignes</span>
            </div>
        </div>
        <div class="card-body">
            @if(empty($data))
                <div class="alert alert-warning">
                    Aucune donnée à prévisualiser.
                    <a href="{{ route('integration.excel.index') }}" class="alert-link">Retour à l'import</a>
                </div>
            @else
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> 
                    <strong>{{ count($data) }}</strong> ligne(s) à importer (les lignes vides ont été automatiquement ignorées)
                </div>
                
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                @foreach($headers as $header)
                                    <th>{{ $header }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $row)
                                <tr>
                                    @foreach($headers as $header)
                                        <td>{{ $row[$header] ?? '' }}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3 d-flex justify-content-between">
                    <a href="{{ route('integration.excel.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Retour
                    </a>
                    
                    <form method="POST" action="{{ route('integration.excel.import') }}" onsubmit="return confirm('Êtes-vous sûr de vouloir importer ces {{ count($data) }} lignes ?')">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirmer l'import ({{ count($data) }} lignes)
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection