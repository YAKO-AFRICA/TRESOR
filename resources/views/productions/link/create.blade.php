<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'identité</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!--favicon-->
	<link rel="icon" href="{{ asset('root/images/logo-icon.png')}}" type="image/png"/>

    
    <style>
        /* Styles personnalisés */
        body {
            background: linear-gradient(135deg, #076633 0%, #09411E 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .text-primary {
            color: #076633 !important;
        }

        .modal-content {
            border-radius: 24px !important;
            border: none !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .modal-body {
            padding: 40px !important;
        }

        .modal-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #076633 0%, #076633 100%);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
        }

        .modal-icon i {
            font-size: 36px;
            color: white;
        }

        /* OTP Inputs */
        .otp-container {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .otp-input {
            width: 50px;
            height: 56px;
            text-align: center;
            font-size: 24px;
            font-weight: 600;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f7fafc;
            text-transform: uppercase; /* Pour afficher les lettres en majuscules */
        }

        .otp-input:focus {
            border-color: #076633;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
            outline: none;
            background: white;
        }

        .otp-input.is-valid {
            border-color: #28a745;
            background: #d4edda;
        }

        .otp-input.is-invalid {
            border-color: #dc3545;
            background: #f8d7da;
        }

        .otp-timer {
            text-align: center;
            font-size: 14px;
            color: #718096;
            margin-top: 10px;
        }

        .otp-timer span {
            font-weight: 600;
            color: #667eea;
        }

        .otp-timer.expired {
            color: #dc3545;
        }

        .otp-timer.expired span {
            color: #dc3545;
        }

        /* Boutons */
        .btn-primary-custom {
            background: linear-gradient(135deg, #E08B00 0%, #E08B00 100%);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(238, 137, 43, 0.3);
        }

        .btn-primary-custom:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Loader */
        .spinner-border-sm {
            width: 1rem;
            height: 1rem;
            border-width: 0.2em;
        }

        /* Toast personnalisé */
        .toast-container-custom {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
        }

        /* Indicateur de type de caractères */
        .otp-hint {
            text-align: center;
            font-size: 12px;
            color: #a0aec0;
            margin-top: 5px;
        }

        .otp-hint i {
            margin-right: 4px;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .modal-body {
                padding: 24px !important;
            }

            .otp-input {
                width: 40px;
                height: 48px;
                font-size: 20px;
            }

            .modal-icon {
                width: 60px;
                height: 60px;
            }

            .modal-icon i {
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

<!-- MODAL 1: Vérification du matricule -->
<div class="modal fade" id="identityModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="modal-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="fw-bold">Vérification d'identité</h3>
                    <p class="text-muted">Entrez votre matricule pour continuer</p>
                    <div class="mx-auto" style="width: 60px; height: 4px; border-radius: 2px; background-color: #076633;"></div>
                </div>
                
                <form id="checkIdentityForm">
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
                            <input type="text" 
                                   name="matricule" 
                                   id="matriculeInput" 
                                   class="form-control form-control-lg" 
                                   placeholder="Entrez votre matricule" 
                                   required 
                                   autofocus
                                   autocomplete="off">
                        </div>
                        <div id="matriculeError" class="text-danger mt-2" style="display: none; font-size: 14px;">
                            <i class="fas fa-exclamation-circle me-1"></i>
                            <span id="matriculeErrorMessage">Matricule invalide</span>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom btn-lg w-100 text-white" id="checkMatriculeBtn">
                        <span id="btnMatriculeText">
                            <i class="fas fa-check-circle me-2"></i>
                            Vérifier mon matricule
                        </span>
                        <span id="btnMatriculeLoader" style="display: none;">
                            <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                            Vérification en cours...
                        </span>
                    </button>
                </form>
                
                <p class="text-center text-muted mt-4 mb-0 small">
                    <i class="fas fa-info-circle me-1"></i>
                    Une erreur ? <a href="#" class="text-decoration-none" onclick="showHelp()">Contactez le support</a>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL 2: Saisie OTP -->
<div class="modal fade" id="otpModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mb-4">
                    <div class="modal-icon" style="background: linear-gradient(135deg, #076633 0%, #076633 100%);">
                        <i class="fas fa-mobile-alt"></i>
                    </div>
                    <h3 class="fw-bold">Code de vérification</h3>
                    <p class="text-muted">Un code a été envoyé sur votre téléphone</p>
                    <p class="text-muted small" id="otpPhoneDisplay"></p>
                    <div class="bg-warning mx-auto" style="width: 60px; height: 4px; border-radius: 2px;"></div>
                </div>
                
                <div class="otp-container" id="otpContainer">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="0">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="1">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="2">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="3">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="4">
                    <input type="text" class="otp-input" maxlength="1" inputmode="text" autocomplete="off" data-index="5">
                </div>
                
                <div class="otp-hint">
                    <i class="fas fa-info-circle"></i>
                    Code alphanumérique (lettres et chiffres)
                </div>
                
                <div id="otpError" class="text-danger text-center" style="display: none; font-size: 14px; margin-top: 10px;">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    <span id="otpErrorMessage">Code invalide</span>
                </div>
                
                <div class="otp-timer" id="otpTimer">
                    <i class="fas fa-clock me-1"></i>
                    Code valide pendant : <span id="otpCountdown">2:00</span>
                </div>
                
                <div class="text-center mt-3">
                    <button class="btn btn-link text-decoration-none" id="resendOtpBtn" style="display: none;">
                        <i class="fas fa-redo me-1"></i>
                        Renvoyer le code
                    </button>
                </div>
                
                <button class="btn btn-primary-custom btn-lg w-100 mt-3 text-white" id="verifyOtpBtn">
                    <span id="btnOtpText">
                        <i class="fas fa-check-circle me-2"></i>
                        Vérifier le code
                    </span>
                    <span id="btnOtpLoader" style="display: none;">
                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                        Vérification...
                    </span>
                </button>
                
                <div class="text-center mt-3">
                    <button class="btn btn-link text-decoration-none" id="changePhoneBtn">
                        <i class="fas fa-arrow-left me-1"></i>
                        Changer de numéro
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast Container -->
<div class="toast-container-custom" id="toastContainer"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    // Configuration
    const OTP_API = '{{ config("services.otp_api") }}';
    const CHECK_ASSURER_URL = '{{ route("checkAssure") }}';
    const REDIRECT_URL_TEMPLATE = '{{ route("link.edit", ["data" => ":data"]) }}';
    
    const OTP_LENGTH = 6;
    
    // Variables
    let otpInterval = null;
    let otpExpirationTime = 120;
    let matriculeData = null;
    
    // Éléments DOM
    const identityModal = new bootstrap.Modal(document.getElementById('identityModal'), {
        backdrop: 'static',
        keyboard: false
    });
    
    const otpModal = new bootstrap.Modal(document.getElementById('otpModal'), {
        backdrop: 'static',
        keyboard: false
    });
    
    const matriculeInput = document.getElementById('matriculeInput');
    const checkMatriculeBtn = document.getElementById('checkMatriculeBtn');
    const btnMatriculeText = document.getElementById('btnMatriculeText');
    const btnMatriculeLoader = document.getElementById('btnMatriculeLoader');
    const matriculeError = document.getElementById('matriculeError');
    const matriculeErrorMessage = document.getElementById('matriculeErrorMessage');
    
    const otpInputs = document.querySelectorAll('.otp-input');
    const verifyOtpBtn = document.getElementById('verifyOtpBtn');
    const btnOtpText = document.getElementById('btnOtpText');
    const btnOtpLoader = document.getElementById('btnOtpLoader');
    const otpError = document.getElementById('otpError');
    const otpErrorMessage = document.getElementById('otpErrorMessage');
    const otpTimer = document.getElementById('otpTimer');
    const otpCountdown = document.getElementById('otpCountdown');
    const resendOtpBtn = document.getElementById('resendOtpBtn');
    const changePhoneBtn = document.getElementById('changePhoneBtn');
    const otpPhoneDisplay = document.getElementById('otpPhoneDisplay');
    const checkIdentityForm = document.getElementById('checkIdentityForm');
    
    // 1. OUVERTURE AUTOMATIQUE DU MODAL
    document.addEventListener('DOMContentLoaded', function() {
        identityModal.show();
        matriculeInput.focus();
    });
    
    // 2. GESTION DU MATRICULE
    checkIdentityForm.addEventListener('submit', function(e) {
        e.preventDefault();
        checkMatricule();
    });
    
    matriculeInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            checkMatricule();
        }
    });
    
    // Validation en temps réel du matricule
    matriculeInput.addEventListener('input', function() {
        const value = this.value.trim();
        if (value.length >= 3) {
            matriculeError.style.display = 'none';
        }
    });
    
    function checkMatricule() {
        const matricule = matriculeInput.value.trim();
        
        if (!matricule || matricule.length < 3) {
            showMatriculeError('Le matricule doit contenir au moins 3 caractères');
            return;
        }
        
        // Afficher le loader
        btnMatriculeText.style.display = 'none';
        btnMatriculeLoader.style.display = 'inline-block';
        checkMatriculeBtn.disabled = true;
        matriculeError.style.display = 'none';
        
        // Envoyer la requête
        fetch(CHECK_ASSURER_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({ matricule: matricule })
        })
        .then(response => response.json())
        .then(data => {
            btnMatriculeText.style.display = 'inline-block';
            btnMatriculeLoader.style.display = 'none';
            checkMatriculeBtn.disabled = false;
            
            if (data.status) {
                // Matricule trouvé
                matriculeData = data.adherentData;
                showToast('success', 'Matricule vérifié avec succès !');
                
                // Envoyer l'OTP
                sendOtp(matriculeData);
                
                // Fermer le modal et ouvrir OTP
                identityModal.hide();
                setTimeout(() => {
                    otpModal.show();
                    setupOtpInputs();
                    startOtpTimer();
                    otpPhoneDisplay.textContent = `📱 ${matriculeData.mobile || matriculeData.telephone || 'Numéro non disponible'}`;
                }, 500);
                
            } else {
                // Matricule non trouvé
                showMatriculeError(data.message || 'Matricule non trouvé');
                matriculeInput.classList.add('is-invalid');
                setTimeout(() => {
                    matriculeInput.classList.remove('is-invalid');
                }, 3000);
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            btnMatriculeText.style.display = 'inline-block';
            btnMatriculeLoader.style.display = 'none';
            checkMatriculeBtn.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: 'Impossible de vérifier le matricule. Veuillez réessayer.',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // 3. ENVOI DE L'OTP
    function sendOtp(adherentData) {
        const phone = adherentData.mobile || adherentData.telephone;
        
        if (!phone) {
            Swal.fire({
                icon: 'warning',
                title: 'Numéro de téléphone non disponible',
                text: 'Aucun numéro de téléphone trouvé pour cet assuré.',
                confirmButtonText: 'OK'
            });
            return;
        }
        
        fetch(`${OTP_API}api/send-otp`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                telIndicatif: "225",
                telephone: phone
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success' || data.status === 200) {
                showToast('success', 'Code OTP envoyé avec succès !');
                otpExpirationTime = 120;
                startOtpTimer();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur d\'envoi OTP',
                    text: data.message || 'Impossible d\'envoyer le code. Veuillez réessayer.',
                    confirmButtonText: 'OK'
                });
            }
        })
        .catch(error => {
            console.error('Erreur envoi OTP:', error);
            Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: 'Impossible d\'envoyer le code OTP. Veuillez réessayer.',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // 4. GESTION DES INPUTS OTP (Alphanumérique)
    function setupOtpInputs() {
        otpInputs.forEach((input, index) => {
            // Supprimer les anciens événements
            input.removeEventListener('input', handleOtpInput);
            input.removeEventListener('keydown', handleOtpKeydown);
            input.removeEventListener('paste', handleOtpPaste);
            input.removeEventListener('focus', handleOtpFocus);
            
            // Ajouter les nouveaux événements
            input.addEventListener('input', handleOtpInput);
            input.addEventListener('keydown', handleOtpKeydown);
            input.addEventListener('paste', handleOtpPaste);
            input.addEventListener('focus', handleOtpFocus);
            
            // Réinitialiser
            input.value = '';
            input.classList.remove('is-valid', 'is-invalid');
            input.style.textTransform = 'uppercase';
        });
        
        // Focus sur le premier input
        otpInputs[0].focus();
        otpError.style.display = 'none';
    }
    
    function handleOtpInput(e) {
        const input = e.target;
        const value = input.value;
        const index = parseInt(input.dataset.index);
        
        // Convertir en majuscules pour les lettres
        input.value = value.toUpperCase();
        
        // Supprimer les caractères non alphanumériques
        input.value = input.value.replace(/[^A-Z0-9]/g, '');
        
        // Si un caractère est saisi, passer à l'input suivant
        if (input.value.length === 1) {
            if (index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
        }
        
        // Si l'utilisateur supprime le contenu, revenir en arrière
        if (value === '' && index > 0) {
            // Ne pas revenir automatiquement, l'utilisateur utilise Backspace
        }
        
        // Masquer l'erreur
        otpError.style.display = 'none';
        
        // Vérifier si tous les champs sont remplis
        const allFilled = Array.from(otpInputs).every(inp => inp.value.length === 1);
        if (allFilled) {
            // Auto-vérification après un court délai
            clearTimeout(window.otpAutoVerify);
            window.otpAutoVerify = setTimeout(() => {
                verifyOtp();
            }, 500);
        }
    }
    
    function handleOtpKeydown(e) {
        const input = e.target;
        const index = parseInt(input.dataset.index);
        
        // Backspace - revenir à l'input précédent
        if (e.key === 'Backspace' && input.value === '' && index > 0) {
            e.preventDefault();
            otpInputs[index - 1].focus();
            otpInputs[index - 1].value = '';
            // Déclencher l'événement input pour mettre à jour
            otpInputs[index - 1].dispatchEvent(new Event('input'));
            return;
        }
        
        // Flèche gauche
        if (e.key === 'ArrowLeft' && index > 0) {
            e.preventDefault();
            otpInputs[index - 1].focus();
        }
        
        // Flèche droite
        if (e.key === 'ArrowRight' && index < otpInputs.length - 1) {
            e.preventDefault();
            otpInputs[index + 1].focus();
        }
        
        // Home - aller au premier input
        if (e.key === 'Home') {
            e.preventDefault();
            otpInputs[0].focus();
        }
        
        // End - aller au dernier input
        if (e.key === 'End') {
            e.preventDefault();
            otpInputs[otpInputs.length - 1].focus();
        }
        
        // Supprimer les touches non alphanumériques (sauf les touches de contrôle)
        const key = e.key;
        if (key.length === 1 && !/^[A-Za-z0-9]$/.test(key) && !e.ctrlKey && !e.metaKey) {
            e.preventDefault();
        }
    }
    
    function handleOtpPaste(e) {
        e.preventDefault();
        const pasteData = e.clipboardData.getData('text');
        // Accepter les caractères alphanumériques
        const chars = pasteData.replace(/[^A-Za-z0-9]/g, '').toUpperCase();
        
        // Remplir les inputs avec les caractères collés
        const length = Math.min(chars.length, otpInputs.length);
        for (let i = 0; i < length; i++) {
            otpInputs[i].value = chars[i] || '';
        }
        
        // Focus sur le dernier input rempli ou le prochain vide
        if (length < otpInputs.length) {
            otpInputs[length].focus();
        } else {
            otpInputs[otpInputs.length - 1].focus();
            // Auto-vérifier si tous les champs sont remplis
            setTimeout(() => verifyOtp(), 300);
        }
    }
    
    function handleOtpFocus(e) {
        const input = e.target;
        input.select();
    }
    
    // 5. VÉRIFICATION DE L'OTP
    verifyOtpBtn.addEventListener('click', function() {
        verifyOtp();
    });
    
    function verifyOtp() {
        let otp = '';
        otpInputs.forEach(input => {
            otp += input.value;
        });
        
        // Vérifier que tous les champs sont remplis
        const allFilled = Array.from(otpInputs).every(inp => inp.value.length === 1);
        
        if (!allFilled || otp.length !== OTP_LENGTH) {
            showOtpError(`Veuillez saisir les ${OTP_LENGTH} caractères du code`);
            otpInputs.forEach(input => {
                if (input.value.length === 0) {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                }
            });
            return;
        }
        
        // Afficher le loader
        btnOtpText.style.display = 'none';
        btnOtpLoader.style.display = 'inline-block';
        verifyOtpBtn.disabled = true;
        otpError.style.display = 'none';

        console.log('matriculeData :', matriculeData);
        
        const phone = matriculeData?.mobile || matriculeData?.telephone;
        
        
        fetch(`${OTP_API}api/verify-otp`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            },
            body: JSON.stringify({
                telephone: `225${phone}`,
                otp: otp
            })
        })
        .then(response => response.json())
        .then(data => {
            btnOtpText.style.display = 'inline-block';
            btnOtpLoader.style.display = 'none';
            verifyOtpBtn.disabled = false;
            
            if (data.status === 200 || data.status === 'success') {
                // OTP validé
                otpInputs.forEach(input => {
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                });
                
                showToast('success', '✅ Vérification réussie !');
                
                // Arrêter le timer
                clearInterval(otpInterval);
                
                // Rediriger après un délai
                Swal.fire({
                    icon: 'success',
                    title: 'Authentification réussie !',
                    text: 'Vous allez être redirigé vers la page de souscription.',
                    showConfirmButton: true,
                    confirmButtonText: 'Continuer',
                    timer: 3000,
                    timerProgressBar: true
                }).then(() => {
                    const redirectUrl = REDIRECT_URL_TEMPLATE.replace(':data', encodeURIComponent(matriculeData.refcontratsource));
                    window.location.href = redirectUrl;
                });
                
            } else if (data.status === 400) {
                showOtpError('Code OTP incorrect. Veuillez réessayer.');
                otpInputs.forEach(input => {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                });
            } else {
                showOtpError(data.message || 'Code OTP expiré ou invalide.');
                otpInputs.forEach(input => {
                    input.classList.remove('is-valid');
                    input.classList.add('is-invalid');
                });
            }
        })
        .catch(error => {
            console.error('Erreur vérification OTP:', error);
            btnOtpText.style.display = 'inline-block';
            btnOtpLoader.style.display = 'none';
            verifyOtpBtn.disabled = false;
            
            Swal.fire({
                icon: 'error',
                title: 'Erreur de connexion',
                text: 'Impossible de vérifier le code. Veuillez réessayer.',
                confirmButtonText: 'OK'
            });
        });
    }
    
    // 6. TIMER OTP (2 minutes)
    function startOtpTimer() {
        clearInterval(otpInterval);
        otpExpirationTime = 120;
        updateOtpDisplay();
        
        otpInterval = setInterval(() => {
            otpExpirationTime--;
            updateOtpDisplay();
            
            if (otpExpirationTime <= 0) {
                clearInterval(otpInterval);
                otpTimer.classList.add('expired');
                otpCountdown.textContent = 'Expiré';
                resendOtpBtn.style.display = 'inline-block';
                verifyOtpBtn.disabled = true;
            }
        }, 1000);
    }
    
    function updateOtpDisplay() {
        const minutes = Math.floor(otpExpirationTime / 60);
        const seconds = otpExpirationTime % 60;
        otpCountdown.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // 7. RENVOYER L'OTP
    resendOtpBtn.addEventListener('click', function() {
        if (matriculeData) {
            sendOtp(matriculeData);
            resendOtpBtn.style.display = 'none';
            verifyOtpBtn.disabled = false;
            otpTimer.classList.remove('expired');
            otpExpirationTime = 120;
            startOtpTimer();
            
            // Réinitialiser les inputs
            otpInputs.forEach(input => {
                input.value = '';
                input.classList.remove('is-valid', 'is-invalid');
            });
            otpInputs[0].focus();
            otpError.style.display = 'none';
            
            showToast('info', 'Nouveau code envoyé !');
        }
    });
    
    // 8. CHANGER DE NUMÉRO
    changePhoneBtn.addEventListener('click', function() {
        otpModal.hide();
        setTimeout(() => {
            identityModal.show();
            matriculeInput.focus();
            matriculeInput.select();
        }, 500);
    });
    
    // 9. AFFICHER LES ERREURS
    function showMatriculeError(message) {
        matriculeErrorMessage.textContent = message;
        matriculeError.style.display = 'block';
        matriculeInput.classList.add('is-invalid');
    }
    
    function showOtpError(message) {
        otpErrorMessage.textContent = message;
        otpError.style.display = 'block';
    }
    
    // 10. TOAST NOTIFICATION
    function showToast(type, message) {
        const container = document.getElementById('toastContainer');
        const colors = {
            success: 'bg-success text-white',
            error: 'bg-danger text-white',
            info: 'bg-info text-white',
            warning: 'bg-warning text-dark'
        };
        
        const toast = document.createElement('div');
        toast.className = `toast align-items-center ${colors[type] || 'bg-primary text-white'} border-0 show`;
        toast.role = 'alert';
        toast.ariaLive = 'assertive';
        toast.ariaAtomic = 'true';
        toast.style.marginBottom = '10px';
        toast.style.borderRadius = '12px';
        toast.style.boxShadow = '0 4px 12px rgba(0,0,0,0.15)';
        
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'times-circle' : 'info-circle'} me-2"></i>
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                toast.remove();
            }, 300);
        }, 4000);
    }
    
    // 11. AIDE / SUPPORT
    function showHelp() {
        Swal.fire({
            icon: 'info',
            title: 'Support technique',
            text: 'Contactez notre équipe au +225 XX XX XX XX ou par email à support@votre-domaine.com',
            confirmButtonText: 'OK'
        });
    }
    
    // 12. EMPÊCHER LA FERMETURE DU MODAL AVEC ECHAP
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            e.preventDefault();
        }
    });
</script>
</body>
</html>