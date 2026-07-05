<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>YNOV Direct Entreprise – Pilotage des souscriptions</title>

    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#076633">

    <!-- iOS support -->
    <link rel="apple-touch-icon" href="{{ asset('images/icon-192.png') }}">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">

    <!-- Icons -->
    <link rel="icon" href="{{ asset('root/images/logo-icon.png')}}" type="image/png"/>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            background:#076633 !important;
            overflow-x:hidden;
        }

        :root{
            --de-primary:#f7a400;
            --de-primary-dark:#e09100;
            --de-gray-50:#f9fafb;
            --de-gray-100:#f1f5f9;
            --de-gray-200:#e2e8f0;
            --de-gray-600:#475569;
            --de-gray-700:#334155;
            --de-gray-800:#1e293b;
            --de-white:#ffffff;
            --de-shadow:0 10px 25px -5px rgba(0,0,0,0.1),
                        0 8px 10px -6px rgba(0,0,0,0.05);
        }

        .de-bg{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:#076633;
            z-index:-2;
        }

        .de-bg::before{
            content:'';
            position:absolute;
            width:200%;
            height:200%;
            background:radial-gradient(circle at 20% 30%, rgba(247,164,0,0.12) 0%, transparent 60%);
            animation:softBreathing 18s infinite alternate;
        }

        @keyframes softBreathing{
            0%{
                transform:scale(1) translate(-5%, -5%);
                opacity:0.4;
            }

            100%{
                transform:scale(1.2) translate(5%, 5%);
                opacity:0.8;
            }
        }

        .dot-pattern{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background-image:radial-gradient(circle at 1px 1px, rgba(247,164,0,0.1) 1px, transparent 1px);
            background-size:32px 32px;
            pointer-events:none;
            z-index:-1;
        }

        .login-wrapper{
            min-height:100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding:2rem;
            position:relative;
        }

        .de-card{
            max-width:1200px;
            width:100%;
            background:var(--de-white);
            border-radius:48px;
            overflow:hidden;
            box-shadow:var(--de-shadow);
            display:grid;
            grid-template-columns:1fr 1fr;
        }

        /* LEFT PANEL */
        .de-brand-panel{
            background:linear-gradient(145deg,#fef9f0 0%,#ffffff 100%);
            padding:3rem 2.5rem;
            position:relative;
        }

        .de-logo-area{
            margin-bottom:3rem;
        }

        .de-badge{
            display:inline-flex;
            align-items:center;
            gap:10px;
            background:rgba(247,164,0,0.15);
            padding:0.5rem 1.2rem;
            border-radius:100px;
            margin-bottom:2rem;
            border:1px solid rgba(247,164,0,0.3);
        }

        .de-badge i{
            color:var(--de-primary);
            font-size:1.1rem;
        }

        .de-badge span{
            color:var(--de-gray-800);
            font-weight:600;
            font-size:0.8rem;
            letter-spacing:1px;
        }

        .de-logo-main h1{
            color:var(--de-gray-800);
            font-size:2.5rem;
            font-weight:700;
        }

        .de-logo-main h1 span{
            color:var(--de-primary);
        }

        .de-logo-main p{
            color:var(--de-gray-600);
            margin-top:0.5rem;
            font-size:0.9rem;
        }

        /* FEATURES */
        .features-widget{
            background:white;
            border-radius:32px;
            padding:1.8rem;
            margin:2rem 0;
            box-shadow:0 4px 20px rgba(0,0,0,0.04);
            border:1px solid var(--de-gray-200);
        }

        .features-widget h3{
            font-size:0.9rem;
            text-transform:uppercase;
            letter-spacing:2px;
            color:var(--de-primary);
            margin-bottom:1.5rem;
            display:flex;
            align-items:center;
            gap:8px;
        }

        .feature-list-vertical{
            display:flex;
            flex-direction:column;
            gap:1.3rem;
        }

        .feature-item{
            display:flex;
            align-items:center;
            gap:14px;
            padding:0.5rem 0;
            border-bottom:1px solid var(--de-gray-100);
        }

        .feature-item:last-child{
            border-bottom:none;
        }

        .feature-icon{
            width:44px;
            height:44px;
            background:rgba(247,164,0,0.1);
            border-radius:20px;
            display:flex;
            align-items:center;
            justify-content:center;
            font-size:1.3rem;
            color:var(--de-primary);
        }

        .feature-text h4{
            font-size:1rem;
            font-weight:700;
            color:var(--de-gray-800);
        }

        .feature-text p{
            font-size:0.75rem;
            color:var(--de-gray-600);
            margin-top:2px;
        }

        /* RIGHT PANEL */
        .de-form-panel{
            padding:3rem 2.5rem;
            background:var(--de-white);
        }

        .form-logo{
            text-align:center;
            margin-bottom:1.5rem;
        }

        .form-header{
            text-align:center;
            margin-bottom:2.5rem;
        }

        .form-header .pill{
            background:rgba(247,164,0,0.1);
            color:var(--de-primary-dark);
            display:inline-block;
            padding:0.3rem 1rem;
            border-radius:50px;
            font-size:0.7rem;
            font-weight:700;
            margin-bottom:1rem;
        }

        .form-header h2{
            font-size:1.8rem;
            color:var(--de-gray-800);
            font-weight:700;
        }

        .form-header p{
            color:var(--de-gray-600);
            font-size:0.9rem;
        }

        .form-group{
            margin-bottom:1.5rem;
        }

        .form-group label{
            font-weight:500;
            color:var(--de-gray-700);
            font-size:0.85rem;
            margin-bottom:0.5rem;
            display:block;
        }

        .input-icon-wrapper{
            position:relative;
        }

        .input-icon-wrapper i:first-child{
            position:absolute;
            left:16px;
            top:50%;
            transform:translateY(-50%);
            color:var(--de-primary);
            font-size:1rem;
        }

        .de-input{
            width:100%;
            padding:14px 16px 14px 45px;
            border:1.5px solid var(--de-gray-200);
            border-radius:20px;
            font-size:0.9rem;
            transition:all 0.2s;
            background:var(--de-white);
            font-family:'Inter',sans-serif;
        }

        .de-input:focus{
            outline:none;
            border-color:var(--de-primary);
            box-shadow:0 0 0 3px rgba(247,164,0,0.15);
        }

        .toggle-pwd{
            position:absolute;
            right:16px;
            top:50%;
            transform:translateY(-50%);
            cursor:pointer;
            color:#94a3b8;
        }

        .btn-de-primary{
            width:100%;
            background:var(--de-primary);
            border:none;
            padding:15px;
            border-radius:40px;
            color:white;
            font-weight:700;
            font-size:1rem;
            cursor:pointer;
            transition:all 0.2s;
            box-shadow:0 4px 12px rgba(247,164,0,0.3);
            margin-top:0.5rem;
        }

        .btn-de-primary:hover{
            background:var(--de-primary-dark);
            transform:translateY(-2px);
            box-shadow:0 8px 20px rgba(247,164,0,0.35);
        }

        .install-float{
            position:fixed;
            bottom:20px;
            right:20px;
            background:var(--de-primary);
            color:white;
            border:none;
            border-radius:50px;
            padding:12px 24px;
            font-weight:600;
            display:none;
            align-items:center;
            gap:10px;
            cursor:pointer;
            z-index:1000;
            font-family:'Inter',sans-serif;
            box-shadow:0 4px 12px rgba(0,0,0,0.2);
        }

        @media (max-width:1000px){

            .de-card{
                grid-template-columns:1fr;
                border-radius:32px;
            }

            .de-brand-panel{
                display:none;
            }

            .de-form-panel{
                padding:2rem;
            }
        }

        @media (max-width:480px){

            .de-form-panel{
                padding:1.5rem;
            }

            .form-header h2{
                font-size:1.5rem;
            }
        }

    </style>
</head>

<body>

<div class="de-bg"></div>
<div class="dot-pattern"></div>

<div class="login-wrapper">

    <div class="de-card">

        <!-- LEFT -->
        <div class="de-brand-panel">

            <div class="de-logo-area">

                <div class="de-badge">
                    <i class="fas fa-building"></i>
                    <span>DIRECT ENTREPRISE</span>
                </div>

                <div class="de-logo-main">
                    <h1>YNOV<span>Direct</span></h1>
                    <p>Plateforme de pilotage des souscriptions</p>
                </div>

            </div>

            <div class="features-widget">

                <h3>
                    <i class="fas fa-star-of-life" style="font-size:0.7rem;"></i>
                    CAPACITÉS PLATEFORME
                </h3>

                <div class="feature-list-vertical">

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-chart-line"></i>
                        </div>

                        <div class="feature-text">
                            <h4>Suivi en temps réel des adhésions</h4>
                            <p>Tableau de bord dynamique, évolution minute par minute</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-user-friends"></i>
                        </div>

                        <div class="feature-text">
                            <h4>Gestion Agents & Agents relais</h4>
                            <p>Attribution des rôles, permissions et suivi d'activité</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-share-alt"></i>
                        </div>

                        <div class="feature-text">
                            <h4>Partage de lien de souscription</h4>
                            <p>Générez et distribuez des liens trackés par campagne</p>
                        </div>
                    </div>

                    <div class="feature-item">
                        <div class="feature-icon">
                            <i class="fas fa-brain"></i>
                        </div>

                        <div class="feature-text">
                            <h4>Interface décisionnelle intuitive</h4>
                            <p>KPIs, alertes et recommandations pour piloter vos campagnes</p>
                        </div>
                    </div>

                </div>

            </div>

            <p style="font-size:0.7rem;color:#94a3b8;text-align:center;margin-top:1rem;">
                <i class="fas fa-shield-alt"></i>
                Accès réservé – Gestion centralisée par l'administrateur
            </p>

        </div>

        <!-- RIGHT -->
        <div class="de-form-panel">

            <div class="form-logo">
                <img src="{{asset('assets/root/images/logo_yako.jpg')}}"
                     alt="logo ynov"
                     style="width:200px;">
            </div>

            <div class="form-header">
                <div class="pill">ESPACE SÉCURISÉ</div>
                <h2>Accès Direct Entreprise</h2>
                <p>Connectez-vous avec vos identifiants</p>
            </div>

            <!-- FORM -->
            <form id="loginForm"
                action="{{ route('login.submit')}}"
                method="POST"
                class="submitForm">

                @csrf

                <div class="form-group">

                    <label>Adresse email ou Code Agent</label>

                    <div class="input-icon-wrapper">

                        <i class="fas fa-envelope"></i>

                        <input
                            type="email"
                            class="de-input"
                            id="login"
                            name="login"
                            placeholder="email ou code agent"
                            value="{{ old('login') }}"
                            required
                        >

                    </div>

                    @error('login')
                    <div style="color:#dc2626;font-size:0.8rem;margin-top:6px;">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                </div>

                <div class="form-group">

                    <label>Mot de passe</label>

                    <div class="input-icon-wrapper">

                        <i class="fas fa-lock"></i>

                        <input
                            type="password"
                            class="de-input"
                            id="password"
                            name="password"
                            placeholder="Votre mot de passe"
                            value="{{ old('password')}}"
                            required
                        >

                        <i class="fas fa-eye toggle-pwd" data-target="password"></i>

                    </div>

                    @error('password')
                    <div style="color:#dc2626;font-size:0.8rem;margin-top:6px;">
                        <i class="fas fa-exclamation-circle"></i>
                        Email ou mot de passe incorrect
                    </div>
                    @enderror

                </div>

                <!-- OPTIONS -->
                <div style="
                    display:flex;
                    justify-content:space-between;
                    align-items:center;
                    margin-top:-5px;
                    margin-bottom:20px;
                    flex-wrap:wrap;
                    gap:10px;
                ">

                    <!-- Remember me -->
                    <div style="
                        display:flex;
                        align-items:center;
                        gap:8px;
                    ">

                        <input
                            type="checkbox"
                            id="rememberMe"
                            name="remember"
                            style="
                                width:16px;
                                height:16px;
                                accent-color:#f7a400;
                                cursor:pointer;
                            "
                        >

                        <label for="rememberMe"
                            style="
                                    margin:0;
                                    font-size:0.85rem;
                                    color:#475569;
                                    cursor:pointer;
                            ">
                            Se souvenir de moi
                        </label>

                    </div>

                    <!-- Forgot password -->
                    <a href="{{ route('password.request') }}"
                    style="
                            font-size:0.85rem;
                            color:#f7a400;
                            text-decoration:none;
                            font-weight:600;
                    ">

                        Mot de passe oublié ?

                    </a>

                </div>

                <!-- BUTTON -->
                <button type="submit"
                        class="btn-de-primary"
                        id="bntLogin">

                    Accéder au pilotage

                </button>

            </form>

            <p style="font-size:0.7rem;text-align:center;color:#94a3b8;margin-top:1.5rem;">
                Les comptes sont créés par l'administrateur.
                Contactez votre référent pour toute demande.
            </p>

        </div>

    </div>

</div>

<!-- PWA INSTALL -->
<button type="button"
        id="installBtn"
        class="install-float">

    <i class="fas fa-download"></i>
    Installer l'application

</button>

<!-- JS -->
<script>

    // ========================
    // TOGGLE PASSWORD
    // ========================
    document.querySelectorAll('.toggle-pwd').forEach(toggle => {

        toggle.addEventListener('click', function () {

            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);

            if(input.type === 'password'){

                input.type = 'text';

                this.classList.remove('fa-eye');
                this.classList.add('fa-eye-slash');

            }else{

                input.type = 'password';

                this.classList.remove('fa-eye-slash');
                this.classList.add('fa-eye');
            }

        });

    });

    // ========================
    // LOGIN BUTTON LOADING
    // ========================
    document.getElementById('loginForm').addEventListener('submit', function () {

        const btn = document.getElementById('bntLogin');

        btn.disabled = true;

        btn.innerHTML =
            'Connexion en cours... ' +
            '<i class="fas fa-spinner fa-spin"></i>';

    });

</script>

<!-- ALERTS -->
<script>

document.addEventListener("DOMContentLoaded", function () {

    @if(session('error'))

        Swal.fire({
            icon:'error',
            title:'Erreur',
            text:"{{ session('error') }}",
            timer:2000,
            showConfirmButton:false
        });

    @endif


    @if(session('lockout'))

        let seconds = {{ session('seconds') }};

        const btn = document.getElementById('bntLogin');

        btn.disabled = true;

        Swal.fire({
            icon:'warning',
            title:'Compte temporairement bloqué',
            html:`Réessayez dans <b>${seconds}</b> secondes`,
            allowOutsideClick:false,
            showConfirmButton:false
        });

        const timer = setInterval(() => {

            seconds--;

            if(seconds <= 0){

                clearInterval(timer);

                Swal.close();

                btn.disabled = false;

                btn.innerHTML = 'Accéder au pilotage';

                return;
            }

            Swal.update({
                html:`Réessayez dans <b>${seconds}</b> secondes`
            });

        },1000);

    @endif

});

</script>

<!-- PWA -->
<script>

    let deferredPrompt;

    window.addEventListener('beforeinstallprompt', (e) => {

        e.preventDefault();

        deferredPrompt = e;

        document.getElementById('installBtn').style.display = 'flex';

    });

    document.getElementById('installBtn').addEventListener('click', async () => {

        if(deferredPrompt){

            deferredPrompt.prompt();

            const { outcome } = await deferredPrompt.userChoice;

            console.log(outcome);

            deferredPrompt = null;

            document.getElementById('installBtn').style.display = 'none';

        }else{

            Swal.fire({
                icon:'info',
                title:'Installation',
                text:'Utilisez "Ajouter à l’écran d’accueil"'
            });

        }

    });

</script>

</body>
</html>