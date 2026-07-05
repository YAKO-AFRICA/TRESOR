@extends('layouts.main')

@section('content')

{{-- Styles --}}
<style>
    * { box-sizing: border-box; margin: 0; padding: 0; }

    .qr-page {
        padding: 2rem 1.5rem;
        font-family: 'Segoe UI', system-ui, sans-serif;
        color: #1a1a1a;
    }

    .page-title {
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        color: #888;
        margin-bottom: 1.5rem;
    }

    .grid-layout {
        display: grid;
        grid-template-columns: 1.15fr 0.85fr;
        gap: 1.5rem;
        align-items: start;
    }

    /* ---- Cards ---- */
    .card {
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
        padding: 1.25rem;
    }

    .card + .card { margin-top: 1rem; }

    .section-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #aaa;
        margin-bottom: 0.75rem;
    }

    /* ---- Fiche commerciale ---- */
    .commercial-header {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .avatar {
        width: 54px;
        height: 54px;
        border-radius: 50%;
        background: #e8f0fe;
        color: #3b5bdb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 600;
        flex-shrink: 0;
    }

    .commercial-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 2px;
    }

    .commercial-role {
        font-size: 13px;
        color: #777;
        margin-bottom: 6px;
    }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 11px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 20px;
        background: #e6f9f0;
        color: #1a7f5a;
    }

    /* ---- Infos ---- */
    .info-list {
        display: flex;
        flex-direction: column;
        gap: 9px;
    }

    .info-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 14px;
        color: #333;
    }

    .info-row svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        color: #aaa;
    }

    /* ---- Boutons partage ---- */
    .share-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
        background: #fff;
        color: #1a1a1a;
        font-size: 14px;
        cursor: pointer;
        transition: background 0.15s;
        text-align: left;
        margin-bottom: 8px;
    }

    .share-btn:last-of-type { margin-bottom: 0; }
    .share-btn:hover { background: #f7f7f7; }

    .share-btn svg {
        width: 18px;
        height: 18px;
        flex-shrink: 0;
        color: #888;
    }

    .share-btn .arrow {
        margin-left: auto;
        color: #ccc;
        font-size: 14px;
    }

    .divider {
        height: 1px;
        background: #f0f0f0;
        margin: 1rem 0;
    }

    /* ---- Lien box ---- */
    .link-box {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 9px 12px;
        background: #f7f7f7;
        border-radius: 10px;
        border: 1px solid #eee;
        font-size: 12px;
        color: #666;
        margin-top: 8px;
    }

    .link-box span {
        flex: 1;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .copy-icon-btn {
        flex-shrink: 0;
        background: none;
        border: none;
        cursor: pointer;
        color: #aaa;
        padding: 2px;
        display: flex;
    }

    .copy-icon-btn:hover { color: #333; }

    .copied-tip {
        display: none;
        font-size: 12px;
        color: #1a7f5a;
        margin-top: 6px;
    }

    .copied-tip.show { display: block; }

    /* ---- Stats ---- */
    .stats-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 8px;
    }

    .stat {
        text-align: center;
        padding: 0.5rem;
    }

    .stat-val {
        font-size: 20px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .stat-lbl {
        font-size: 11px;
        color: #aaa;
        margin-top: 2px;
    }

    /* ---- QR Code ---- */
    .qr-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1rem;
    }

    .qr-frame {
        padding: 16px;
        background: #fff;
        border: 1px solid #e8e8e8;
        border-radius: 14px;
    }

    #qrcode-container canvas,
    #qrcode-container img {
        display: block;
    }

    .qr-caption {
        font-size: 12px;
        color: #999;
        text-align: center;
        line-height: 1.5;
    }

    .dl-btn {
        width: 100%;
        padding: 10px 14px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
        background: #fff;
        color: #333;
        font-size: 13px;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: background 0.15s;
    }

    .dl-btn:hover { background: #f7f7f7; }

    .dl-btn svg {
        width: 16px;
        height: 16px;
        color: #888;
    }

    /* ---- Modal ---- */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        z-index: 1000;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .modal-overlay.active { display: flex; }

    .modal-box {
        background: #fff;
        border-radius: 16px;
        padding: 1.75rem;
        width: 360px;
        max-width: 95vw;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        animation: modalIn 0.2s ease;
    }

    @keyframes modalIn {
        from { transform: translateY(12px); opacity: 0; }
        to   { transform: translateY(0);   opacity: 1; }
    }

    .modal-box h3 {
        font-size: 17px;
        font-weight: 600;
        margin-bottom: 4px;
    }

    .modal-box p {
        font-size: 13px;
        color: #777;
        margin-bottom: 1.25rem;
    }

    .modal-box input[type="tel"],
    .modal-box input[type="email"] {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        font-size: 14px;
        background: #fafafa;
        color: #1a1a1a;
        margin-bottom: 12px;
        outline: none;
        transition: border-color 0.15s;
    }

    .modal-box input:focus {
        border-color: #3b5bdb;
        box-shadow: 0 0 0 3px rgba(59,91,219,0.08);
    }

    .btn-send {
        width: 100%;
        padding: 11px;
        border-radius: 10px;
        border: none;
        background: #1a1a1a;
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: opacity 0.15s;
    }

    .btn-send:hover { opacity: 0.86; }

    .btn-cancel {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #e8e8e8;
        background: transparent;
        color: #888;
        font-size: 13px;
        cursor: pointer;
        margin-top: 8px;
        transition: background 0.15s;
    }

    .btn-cancel:hover { background: #f7f7f7; }

    /* Toast */
    #toast {
        position: fixed;
        bottom: 28px;
        left: 50%;
        transform: translateX(-50%);
        background: #1a1a1a;
        color: #fff;
        padding: 10px 20px;
        border-radius: 24px;
        font-size: 13px;
        z-index: 9999;
        pointer-events: none;
        opacity: 0;
        transition: opacity 0.3s;
    }

    @media (max-width: 768px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }
    }
</style>

{{-- Toast notification --}}
<div id="toast"></div>

{{-- Modal overlay --}}
<div class="modal-overlay" id="modal-overlay" onclick="closeModal(event)">
    <div class="modal-box" id="modal-box">
        <h3 id="modal-title">Partager par SMS</h3>
        <p id="modal-desc">Saisissez le numéro de téléphone destinataire</p>
        <input type="tel" id="modal-input" placeholder="+225 07 00 00 00 00" />
        <button class="btn-send" onclick="sendShare()">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            Envoyer
        </button>
        <button class="btn-cancel" onclick="closeModal()">Annuler</button>
    </div>
</div>

{{-- Page --}}
<div class="qr-page">

    <div class="page-title">Génération &amp; partage — Lien de souscription</div>

    <div class="grid-layout">

        {{-- Colonne gauche --}}
        <div>

            {{-- Fiche commerciale --}}
            <div class="card">
                <div class="commercial-header">
                    <div class="avatar">
                        {{ strtoupper(substr($commercial->prenom ?? 'K', 0, 1)) }}{{ strtoupper(substr($commercial->nom ?? 'D', 0, 1)) }}
                    </div>
                    <div>
                        <div class="commercial-name">{{ $commercial->prenom ?? 'Konan' }} {{ $commercial->nom ?? 'Didier' }}</div>
                        <div class="commercial-role">{{ $commercial->profession ?? 'Commercial Senior' }} — {{ $commercial->nomagence ?? 'Région Abidjan' }}</div>
                        <span class="badge">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Compte vérifié
                        </span>
                    </div>
                </div>
            </div>

            {{-- Informations --}}
            <div class="card">
                <div class="section-label">Informations</div>
                <div class="info-list">
                    <div class="info-row">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.15 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.08 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 21 16.92z"/></svg>
                        {{ $commercial->tel ?? '+225 07 08 09 10 11' }}
                    </div>
                    <div class="info-row">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                        {{ $commercial->email ?? 'k.didier@entreprise.ci' }}
                    </div>
                    <div class="info-row">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
                        {{ $commercial->partenaire ?? 'Entreprise CI' }} — {{ $commercial->codeagent ?? 'Direction Commerciale' }}
                    </div>
                </div>
            </div>

            {{-- Partage --}}
            <div class="card">
                <div class="section-label">Partager le lien</div>

                <button class="share-btn" onclick="openModal('sms')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    Partager par SMS
                    <span class="arrow">→</span>
                </button>

                <button class="share-btn" onclick="openModal('email')">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    Partager par e-mail
                    <span class="arrow">→</span>
                </button>

                <div class="divider"></div>

                <button class="share-btn" onclick="copyLink()">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    Copier le lien
                </button>

                <p class="copied-tip" id="copy-tip">✓ Lien copié dans le presse-papier !</p>

                <div class="link-box">
                    {{-- <span id="display-link">{{ url('/site/souscription/' . ($commercial->idmembre ?? '230806')) }}</span> --}}
                    <span id="display-link">{{ url('/link/create') }}</span>
                    <button class="copy-icon-btn" onclick="copyLink()" aria-label="Copier le lien">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    </button>
                </div>
            </div>

            {{-- Stats --}}
            {{-- <div class="card">
                <div class="section-label">Statistiques</div>
                <div class="stats-grid">
                    <div class="stat">
                        <div class="stat-val">{{ $stats['scans'] ?? 142 }}</div>
                        <div class="stat-lbl">Scans</div>
                    </div>
                    <div class="stat">
                        <div class="stat-val">{{ $stats['souscriptions'] ?? 38 }}</div>
                        <div class="stat-lbl">Souscriptions</div>
                    </div>
                    <div class="stat">
                        <div class="stat-val">
                            @php
                                $scans = $stats['scans'] ?? 142;
                                $sous  = $stats['souscriptions'] ?? 38;
                                $taux  = $scans > 0 ? round(($sous / $scans) * 100, 1) : 0;
                            @endphp
                            {{ $taux }}%
                        </div>
                        <div class="stat-lbl">Taux conv.</div>
                    </div>
                </div>
            </div> --}}

        </div>

        {{-- Colonne droite — QR Code --}}
        <div class="card qr-wrap">
            <div class="section-label" style="align-self: flex-start;">QR Code — Lien de souscription</div>

            <div class="qr-frame">
                <div id="qrcode-container"></div>
            </div>

            <p class="qr-caption">
                Scannez ce code pour accéder<br>au lien de souscription
            </p>

            <button class="dl-btn" onclick="downloadQR()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Télécharger le QR code (.png)
            </button>
        </div>

    </div>
</div>

{{-- QRCode.js lib --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

<script>
    // ── Lien de souscription ──────────────────────────────────────────────
    // const SOUSCRIPTION_URL = "{{ url('/site/souscription/' . ($commercial->idmembre ?? '230806')) }}";
    const SOUSCRIPTION_URL = "{{ url('/link/create') }}";

    // ── Génération du QR code ─────────────────────────────────────────────
    const qr = new QRCode(document.getElementById('qrcode-container'), {
        text: SOUSCRIPTION_URL,
        width: 200,
        height: 200,
        colorDark: '#1a1a1a',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.H
    });

    // ── Téléchargement PNG ────────────────────────────────────────────────
    function downloadQR() {
        setTimeout(function () {
            const canvas = document.querySelector('#qrcode-container canvas');
            if (!canvas) {
                showToast('Impossible de générer le fichier.');
                return;
            }
            const link = document.createElement('a');
            link.download = 'qrcode-souscription-{{ $commercial->idmembre ?? "230806" }}.png';
            link.href = canvas.toDataURL('image/png');
            link.click();
            showToast('QR code téléchargé ✓');
        }, 200);
    }

    // ── Copier le lien ────────────────────────────────────────────────────
    function copyLink() {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(SOUSCRIPTION_URL).catch(() => fallbackCopy());
        } else {
            fallbackCopy();
        }
        const tip = document.getElementById('copy-tip');
        tip.classList.add('show');
        setTimeout(() => tip.classList.remove('show'), 2500);
    }

    function fallbackCopy() {
        const el = document.createElement('textarea');
        el.value = SOUSCRIPTION_URL;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    }

    // ── Modal SMS / Email ─────────────────────────────────────────────────
    let activeMode = 'sms';

    function openModal(mode) {
        activeMode = mode;
        const title  = document.getElementById('modal-title');
        const desc   = document.getElementById('modal-desc');
        const input  = document.getElementById('modal-input');

        if (mode === 'sms') {
            title.textContent = 'Partager par SMS';
            desc.textContent  = 'Saisissez le numéro de téléphone destinataire';
            input.placeholder = '+225 07 00 00 00 00';
            input.type        = 'tel';
        } else {
            title.textContent = 'Partager par e-mail';
            desc.textContent  = "Saisissez l'adresse e-mail destinataire";
            input.placeholder = 'exemple@mail.com';
            input.type        = 'email';
        }

        input.value = '';
        document.getElementById('modal-overlay').classList.add('active');
        setTimeout(() => input.focus(), 80);
    }

    function closeModal(e) {
        if (!e || e.target === document.getElementById('modal-overlay')) {
            document.getElementById('modal-overlay').classList.remove('active');
        }
    }

    function sendShare() {
        const val = document.getElementById('modal-input').value.trim();
        if (!val) {
            document.getElementById('modal-input').focus();
            return;
        }

        if (activeMode === 'sms') {
            sendSMS(val);
        } else {
            sendEmail(val);
        }
    }

    // ── Envoi SMS via API YakoAfricAssur ─────────────────────────────────
    function sendSMS(phone) {
        const btnSend  = document.querySelector('.btn-send');
        const msgText  = 'Veuillez procéder à votre souscription en cliquant ce lien ci-dessous : ' + SOUSCRIPTION_URL;

        // Vérification longueur (155 caractères max)
        if (msgText.length > 155) {
            showToast('⚠ Le message dépasse 155 caractères (' + msgText.length + ')');
            return;
        }

        btnSend.disabled    = true;
        btnSend.textContent = 'Envoi en cours…';

        const formData = new FormData();
        formData.append('phone',   phone);
        formData.append('message', msgText);

        fetch('https://apimain.yakoafricassur.com/api/send-sms', {
            method: 'POST',
            body: formData
        })
        .then(r => {
            if (!r.ok) throw new Error('Erreur HTTP ' + r.status);
            return r.json();
        })
        .then(data => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('SMS envoyé au ' + phone + ' ✓');
        })
        .catch(err => {
            console.error('SMS error:', err);
            showToast('⚠ Échec de l\'envoi. Vérifiez le numéro.');
        })
        .finally(() => {
            btnSend.disabled = false;
            btnSend.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg> Envoyer`;
        });
    }

    // ── Envoi Email via Laravel ───────────────────────────────────────────
    function sendEmail(email) {
        fetch('', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                email: email,
                lien: SOUSCRIPTION_URL,
                commercial_id: {{ $commercial->id ?? 'null' }}
            })
        })
        .then(r => r.json())
        .then(() => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('E-mail envoyé à ' + email + ' ✓');
        })
        .catch(() => {
            document.getElementById('modal-overlay').classList.remove('active');
            showToast('E-mail envoyé à ' + email + ' ✓');
        });
    }

    // ── Toast ─────────────────────────────────────────────────────────────
    function showToast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.style.opacity = '1';
        clearTimeout(t._timer);
        t._timer = setTimeout(() => { t.style.opacity = '0'; }, 2800);
    }
</script>

@endsection
