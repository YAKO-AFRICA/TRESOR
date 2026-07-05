<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Succès - Mise à jour du dossier</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #f8f9fa 0%, #e8f5ee 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .success-card {
            background: white;
            border-radius: 24px;
            padding: 50px 40px;
            box-shadow: 0 20px 60px rgba(15, 123, 75, 0.15);
            max-width: 600px;
            width: 100%;
            text-align: center;
            position: relative;
            overflow: hidden;
            animation: slideUp 0.6s ease;
        }

        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #0F7B4B, #22c55e, #0F7B4B);
            background-size: 200% 100%;
            animation: gradientMove 3s ease infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #0F7B4B, #22c55e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: bounceIn 0.8s ease 0.3s both;
            box-shadow: 0 10px 30px rgba(15, 123, 75, 0.3);
        }

        @keyframes bounceIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            50% {
                transform: scale(1.1);
            }
            70% {
                transform: scale(0.95);
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .success-icon i {
            font-size: 50px;
            color: white;
        }

        .checkmark {
            stroke: white;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .title {
            color: #1a1a2e;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #6c757d;
            font-size: 16px;
            margin-bottom: 30px;
        }

        .info-box {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 20px;
            text-align: left;
            margin-bottom: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-item i {
            color: #0F7B4B;
            font-size: 18px;
            width: 30px;
        }

        .info-item .label {
            color: #6c757d;
            font-size: 13px;
            font-weight: 500;
            min-width: 100px;
        }

        .info-item .value {
            color: #1a1a2e;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-container {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #0F7B4B, #1a9a60);
            border: none;
            color: white;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(15, 123, 75, 0.3);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(15, 123, 75, 0.4);
            color: white;
            background: linear-gradient(135deg, #0F7B4B, #22c55e);
        }

        .btn-outline-custom {
            background: transparent;
            border: 2px solid #0F7B4B;
            color: #0F7B4B;
            padding: 12px 32px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 15px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-outline-custom:hover {
            background: #0F7B4B;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 25px rgba(15, 123, 75, 0.2);
        }

        .confetti-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 9999;
            overflow: hidden;
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            animation: confettiFall linear forwards;
        }

        @keyframes confettiFall {
            0% {
                transform: translateY(-10px) rotate(0deg);
                opacity: 1;
            }
            100% {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        .badge-success {
            background: #dcfce7;
            color: #0F7B4B;
            padding: 4px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
            margin-top: 10px;
        }

        @media (max-width: 576px) {
            .success-card {
                padding: 30px 20px;
                margin: 20px;
            }

            .title {
                font-size: 22px;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 4px;
            }

            .info-item .label {
                min-width: auto;
            }

            .btn-container {
                flex-direction: column;
            }

            .btn-primary-custom,
            .btn-outline-custom {
                justify-content: center;
            }

            .success-icon {
                width: 80px;
                height: 80px;
            }

            .success-icon i {
                font-size: 40px;
            }
        }
    </style>
</head>

<body>
    <!-- Confetti Container -->
    <div class="confetti-container" id="confettiContainer"></div>

    <div class="success-card">
        <!-- Icône de succès -->
        <div class="success-icon">
            <i class="bi bi-check-lg"></i>
        </div>

        <!-- Titre -->
        <h1 class="title">Mise à jour réussie !</h1>
        <p class="subtitle">Le dossier a été mis à jour avec succès</p>

        <span class="badge-success">
            <i class="bi bi-clock-history me-1"></i>
            Mis à jour le {{ now()->format('d/m/Y à H:i') }}
        </span>

        <!-- Informations -->
        <div class="info-box mt-4">
            <div class="info-item">
                <i class="bi bi-person"></i>
                <span class="label">Assuré</span>
                <span class="value">{{ $contrat->assures[0]->prenom ?? '' }} {{ $contrat->assures[0]->nom ?? '' }}</span>
            </div>
            <div class="info-item">
                <i class="bi bi-file-text"></i>
                <span class="label">Numéro dossier</span>
                <span class="value">#{{ $contrat->id ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <i class="bi bi-calendar3"></i>
                <span class="label">Date mise à jour</span>
                <span class="value">{{ now()->format('d/m/Y à H:i') }}</span>
            </div>
            <div class="info-item">
                <i class="bi bi-check-circle"></i>
                <span class="label">Statut</span>
                <span class="value text-success">✓ Validé</span>
            </div>
        </div>

        <!-- Boutons d'action -->
        <div class="btn-container">
            <a href="https://web.yakoafricassur.com/" class="btn-outline-custom">
                <i class="bi bi-house"></i>
                Retour à l'accueil
            </a>
        </div>

        <!-- Message de confirmation -->
        {{-- <p class="mt-4 mb-0 text-muted" style="font-size: 13px;">
            <i class="bi bi-envelope me-1"></i>
            Un email de confirmation a été envoyé à votre adresse
        </p> --}}
    </div>

    <!-- Script pour les confettis -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Générer des confettis
            const container = document.getElementById('confettiContainer');
            const colors = ['#0F7B4B', '#22c55e', '#fbbf24', '#ef4444', '#3b82f6', '#8b5cf6', '#ec4899', '#14b8a6'];
            
            for (let i = 0; i < 100; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.width = (Math.random() * 8 + 4) + 'px';
                confetti.style.height = (Math.random() * 8 + 4) + 'px';
                confetti.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
                confetti.style.animationDuration = (Math.random() * 3 + 2) + 's';
                confetti.style.animationDelay = (Math.random() * 2) + 's';
                container.appendChild(confetti);
            }

            // Nettoyer les confettis après l'animation
            setTimeout(() => {
                container.innerHTML = '';
            }, 5000);

            // Effet de scrolling automatique vers la page de succès
            // setTimeout(() => {
            //     window.location.href = 'https://web.yakoafricassur.com/';
            // }, 8000);
        });
    </script>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>