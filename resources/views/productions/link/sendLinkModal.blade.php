<!-- Modal SMS Simple -->
<div class="modal fade" id="smsShareModal" tabindex="-1" aria-labelledby="smsShareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="smsShareModalLabel">
                    <i class="bi bi-chat-dots me-2 text-primary"></i>
                    Partager par SMS
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body pt-3">
                <p class="text-muted mb-3">Saisissez le numéro de téléphone du destinataire</p>

                <div class="mb-3">
                    <label for="phoneNumber" class="form-label fw-semibold">
                        <i class="bi bi-phone me-1"></i> Numéro de téléphone
                    </label>
                    <input
                        type="tel"
                        class="form-control form-control-lg"
                        id="phoneNumber"
                        placeholder="+225 07 00 00 00 00"
                        autocomplete="tel"
                    >
                    <div class="form-text">
                        <i class="bi bi-info-circle me-1"></i> Format : +225 07 00 00 00 00
                    </div>
                </div>

                <!-- Zone de statut -->
                <div id="smsStatus" class="alert d-none" role="alert">
                    <span id="statusText"></span>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-1"></i> Annuler
                </button>
                <button type="button" class="btn btn-primary btn-lg" id="sendSmsButton">
                    <i class="bi bi-send me-2"></i> Envoyer
                </button>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function() {

    console.log('✅ SMS Modal chargé');
    // Configuration
    const SOUSCRIPTION_URL = window.location.origin + '/link/create';

    // Références DOM
    const modal = new bootstrap.Modal(document.getElementById('smsShareModal'));
    const phoneInput = document.getElementById('phoneNumber');
    const sendButton = document.getElementById('sendSmsButton');
    const statusDiv = document.getElementById('smsStatus');
    const statusText = document.getElementById('statusText');
    const adhrentInfo = contratInfo.adherent;
    console.log(adhrentInfo);

    // Fonction pour ouvrir le modal
    window.openSmsModal = function() {
        // Réinitialiser
        phoneInput.value = adhrentInfo.mobile;
        phoneInput.classList.remove('is-invalid');
        statusDiv.classList.add('d-none');
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send me-2"></i> Envoyer';

        // Ouvrir le modal
        modal.show();

        // Focus sur le champ après l'ouverture
        setTimeout(() => phoneInput.focus(), 300);
    };

    // Fonction pour afficher le statut
    function setStatus(message, type = 'info') {
        statusDiv.className = `alert alert-${type}`;
        statusText.textContent = message;
        statusDiv.classList.remove('d-none');
    }

    // Fonction pour envoyer le SMS
    function sendSms() {
        const phone = phoneInput.value.trim();

        // Validation
        if (!phone) {
            phoneInput.classList.add('is-invalid');
            phoneInput.focus();
            return;
        }

        // Validation du format
        const cleanPhone = phone.replace(/\s/g, '');
        const phoneRegex = /^(\+\d{1,3})?\d{8,15}$/;
        if (!phoneRegex.test(cleanPhone)) {
            phoneInput.classList.add('is-invalid');
            setStatus('⚠ Format de numéro invalide. Utilisez +225 07 00 00 00 00', 'danger');
            return;
        }

        phoneInput.classList.remove('is-invalid');

        // Message
        const message = `Bonjour ${adhrentInfo.nom}, Veuillez procéder à votre souscription en cliquant ce lien ci-dessous : ${SOUSCRIPTION_URL}`;

        // Vérification longueur (155 caractères max)
        if (message.length > 155) {
            setStatus(`⚠ Le message dépasse 155 caractères (${message.length} caractères)`, 'danger');
            return;
        }

        // Désactiver le bouton
        sendButton.disabled = true;
        sendButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Envoi...';

        setStatus('📤 Envoi du SMS en cours...', 'info');

        // Appel API
        const formData = new FormData();
        formData.append('phone', phone);
        formData.append('message', message);

        fetch('https://apimain.yakoafricassur.com/api/send-sms', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`Erreur HTTP ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            setStatus(`✅ SMS envoyé avec succès à ${phone}`, 'success');

            // Fermer après 2 secondes
            setTimeout(() => {
                modal.hide();
                // Notification toast (optionnel)
                showToast('SMS envoyé avec succès !', 'success');
            }, 2000);
        })
        .catch(error => {
            console.error('Erreur:', error);
            setStatus('⚠ Échec de l\'envoi. Vérifiez le numéro et réessayez.', 'danger');

            // Réactiver le bouton
            sendButton.disabled = false;
            sendButton.innerHTML = '<i class="bi bi-arrow-repeat me-2"></i> Réessayer';
        });
    }

    // Toast simple (optionnel)
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `position-fixed top-0 end-0 p-3`;
        toast.style.zIndex = '9999';
        toast.innerHTML = `
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${type} text-white">
                    <strong class="me-auto">
                        <i class="bi bi-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                        ${type === 'success' ? 'Succès' : 'Information'}
                    </strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Fermer"></button>
                </div>
                <div class="toast-body">${message}</div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }

    // Événements
    sendButton.addEventListener('click', sendSms);

    phoneInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendSms();
        }
    });

    // Réinitialiser le modal lors de la fermeture
    document.getElementById('smsShareModal').addEventListener('hidden.bs.modal', function() {
        statusDiv.classList.add('d-none');
        phoneInput.classList.remove('is-invalid');
        sendButton.disabled = false;
        sendButton.innerHTML = '<i class="bi bi-send me-2"></i> Envoyer';
    });
});
</script>


