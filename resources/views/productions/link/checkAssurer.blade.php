<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'identité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!--favicon-->
	<link rel="icon" href="{{ asset('root/images/logo-icon.png')}}" type="image/png"/>
</head>
<body style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh;">

<!-- Modal Bootstrap -->
<div class="modal fade" id="identityModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 24px; border: none;">
            <div class="modal-body p-5">
                <!-- Contenu du modal -->
                <div class="text-center mb-4">
                    <div class="bg-primary bg-gradient rounded-circle d-inline-flex p-4 mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt text-white" style="font-size: 36px; margin: auto;"></i>
                    </div>
                    <h3 class="fw-bold">Vérification d'identité</h3>
                    <p class="text-muted">Pour des raisons de sécurité</p>
                    <div class="bg-primary mx-auto" style="width: 60px; height: 4px; border-radius: 2px;"></div>
                </div>
                
                <form action="{{ route('checkIdentity') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">
                            <i class="fas fa-id-card text-primary me-2"></i>
                            Matricule
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-user text-muted"></i>
                            </span>
                            <input type="text" name="matricule" class="form-control form-control-lg" 
                                   placeholder="Entrez votre matricule" required autofocus>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100">
                        <i class="fas fa-check-circle me-2"></i>
                        Confirmer mon identité
                    </button>
                </form>
                
                <p class="text-center text-muted mt-4 mb-0 small">
                    <i class="fas fa-info-circle me-1"></i>
                    Une erreur ? <a href="#" class="text-decoration-none">Contactez le support</a>
                </p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Ouvrir le modal automatiquement
    document.addEventListener('DOMContentLoaded', function() {
        const modal = new bootstrap.Modal(document.getElementById('identityModal'), {
            backdrop: 'static',
            keyboard: false
        });
        modal.show();
    });
</script>
</body>
</html>