@extends('layouts.main')

@section('content')

<style>
    * { box-sizing: border-box; }

    .sim-wrap {
        padding: 1rem;
        max-width: 1100px;
        margin: 0 auto;
    }

    .sim-title {
        font-size: 15px;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        letter-spacing: .05em;
        margin-bottom: 1.25rem;
    }

    /* Layout principal */
    .sim-grid {
        display: grid;
        grid-template-columns: 1fr 310px;
        gap: 1rem;
        align-items: start;
    }

    @media (max-width: 768px) {
        .sim-grid { grid-template-columns: 1fr; }
    }

    /* Panneau formules */
    .formules-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 1.25rem;
    }

    /* Grille des 3 cartes */
    .cards-row {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: .75rem;
    }

    @media (max-width: 560px) {
        .cards-row { grid-template-columns: 1fr; }
    }

    /* Carte formule */
    .formula-card {
        border: 1.5px solid #e5e7eb;
        border-radius: 12px;
        cursor: pointer;
        overflow: hidden;
        transition: transform .2s, box-shadow .2s;
    }

    .formula-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 18px rgba(0,0,0,.08);
    }

    /* Actif — couleur selon formule */
    .formula-card.active.std  { border: 2px solid #185FA5; }
    .formula-card.active.ser  { border: 2px solid #BA7517; }
    .formula-card.active.prem { border: 2px solid #3B6D11; }

    .formula-header {
        padding: 10px 8px;
        color: #fff;
        font-weight: 600;
        text-align: center;
        font-size: 12px;
        letter-spacing: .04em;
    }

    .formula-header.std  { background: #185FA5; }
    .formula-header.ser  { background: #BA7517; }
    .formula-header.prem { background: #3B6D11; }

    .formula-body { padding: 12px; }

    .formula-price {
        text-align: center;
        font-size: 13px;
        font-weight: 600;
        margin-bottom: 10px;
    }

    .formula-price.std  { color: #185FA5; }
    .formula-price.ser  { color: #BA7517; }
    .formula-price.prem { color: #3B6D11; }

    .capital-line {
        display: flex;
        justify-content: space-between;
        font-size: 11px;
        padding: 4px 0;
        border-bottom: 1px dashed #e5e7eb;
        color: #6b7280;
    }

    .capital-line:last-child { border-bottom: none; }
    .capital-line strong { color: #111827; font-weight: 500; }

    /* Déclaration de santé */
    .pathologie-box {
        background: #f8f9fa;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 1rem;
        margin-top: 1rem;
    }

    .pathologie-box h2 {
        font-size: 13px;
        font-weight: 600;
        margin-bottom: .6rem;
    }

    .alert-surprime {
        background: #e0f0ff;
        color: #0c4a7c;
        font-size: 11px;
        padding: 7px 10px;
        border-radius: 8px;
        margin-bottom: .75rem;
    }

    .bonne-sante-label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        margin-bottom: .75rem;
    }

    .patho-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: .2rem;
    }

    .pathologie-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        font-size: 12px;
        padding: 6px 8px;
        border-bottom: 1px dashed #e5e7eb;
    }

    .pathologie-item:last-child { border-bottom: none; }

    /* Panneau résultat */
    .result-panel {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        position: sticky;
        top: 1rem;
    }

    .result-header {
        background: #185FA5;
        color: #fff;
        padding: 10px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
        transition: background .3s;
    }

    .result-body { padding: 1rem; }

    .result-table {
        width: 100%;
        font-size: 12px;
        border-collapse: collapse;
        margin-bottom: .75rem;
    }

    .result-table td { padding: 6px 4px; color: #6b7280; }
    .result-table td:last-child { text-align: right; color: #111827; font-weight: 600; }
    .result-table tr { border-bottom: 1px solid #f3f4f6; }
    .result-table tr:last-child { border-bottom: none; }

    .patho-badges {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        margin-bottom: .75rem;
        min-height: 4px;
    }

    .badge-patho {
        background: #faeeda;
        color: #633806;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 6px;
        font-weight: 500;
    }

    .total-box {
        background: #185FA5;
        color: #fff;
        font-size: 16px;
        font-weight: 600;
        padding: 12px;
        border-radius: 10px;
        text-align: center;
        margin-bottom: .75rem;
        transition: background .3s;
    }

    .btn-souscrire {
        width: 100%;
        padding: 9px;
        border: none;
        border-radius: 8px;
        background: #3B6D11;
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s;
    }

    .btn-souscrire:hover { background: #27500A; }
</style>

<div class="sim-wrap py-3">

    <p class="sim-title">Simulateur Assurance Funérailles</p>

    <div class="sim-grid">

        <!-- FORMULES -->
        <div class="formules-panel">

            <div class="cards-row">

                <!-- STANDARD (bleu) -->
                <div class="formula-card std active"
                     data-formule="STANDARD"
                     data-prime="54945">
                    <div class="formula-header std">Formule Standard</div>
                    <div class="formula-body">
                        <div class="formula-price std">54 945 FCFA</div>
                        <div class="capital-line"><span>Adhérent</span><strong>1 000 000</strong></div>
                        <div class="capital-line"><span>Conjoint(e)</span><strong>1 000 000</strong></div>
                        <div class="capital-line"><span>Enfants (4)</span><strong>500 000</strong></div>
                        <div class="capital-line"><span>Ascendants (2)</span><strong>1 000 000</strong></div>
                    </div>
                </div>

                <!-- SERENITE (orange) -->
                <div class="formula-card ser"
                     data-formule="SERENITE"
                     data-prime="109890">
                    <div class="formula-header ser">Formule Sérénité</div>
                    <div class="formula-body">
                        <div class="formula-price ser">109 890 FCFA</div>
                        <div class="capital-line"><span>Adhérent</span><strong>2 000 000</strong></div>
                        <div class="capital-line"><span>Conjoint(e)</span><strong>2 000 000</strong></div>
                        <div class="capital-line"><span>Enfants (4)</span><strong>1 000 000</strong></div>
                        <div class="capital-line"><span>Ascendants (2)</span><strong>2 000 000</strong></div>
                    </div>
                </div>

                <!-- PREMIUM (vert) -->
                <div class="formula-card prem"
                     data-formule="PREMIUM"
                     data-prime="219780">
                    <div class="formula-header prem">Formule Premium</div>
                    <div class="formula-body">
                        <div class="formula-price prem">219 780 FCFA</div>
                        <div class="capital-line"><span>Adhérent</span><strong>4 000 000</strong></div>
                        <div class="capital-line"><span>Conjoint(e)</span><strong>4 000 000</strong></div>
                        <div class="capital-line"><span>Enfants (4)</span><strong>2 000 000</strong></div>
                        <div class="capital-line"><span>Ascendants (2)</span><strong>4 000 000</strong></div>
                    </div>
                </div>

            </div>

            <!-- DECLARATION -->
            <div class="pathologie-box">

                <h2>Déclaration de santé « Assuré »</h2>

                <div class="alert-surprime">
                    Chaque pathologie cochée ajoute une surprime de
                    <strong>5 500 FCFA</strong>
                </div>

                <label class="bonne-sante-label">
                    <input type="checkbox" id="bonneSante" checked>
                    L'assuré déclare être en bonne santé
                </label>

                <div class="patho-grid">
                    <div class="pathologie-item">
                        <span>Diabète</span>
                        <input type="checkbox" class="pathologie" value="Diabète">
                    </div>
                    <div class="pathologie-item">
                        <span>AVC</span>
                        <input type="checkbox" class="pathologie" value="AVC">
                    </div>
                    <div class="pathologie-item">
                        <span>Cancer</span>
                        <input type="checkbox" class="pathologie" value="Cancer">
                    </div>
                    <div class="pathologie-item">
                        <span>Hypertension</span>
                        <input type="checkbox" class="pathologie" value="Hypertension">
                    </div>
                    <div class="pathologie-item">
                        <span>Insuffisance Rénale</span>
                        <input type="checkbox" class="pathologie" value="Insuffisance Rénale">
                    </div>
                </div>

            </div>

        </div>

        <!-- RESULTAT -->
        <div class="result-panel">

            <div class="result-header" id="resHeader">
                Résultat Simulation
            </div>

            <div class="result-body">

                <table class="result-table">
                    <tr>
                        <td>Formule</td>
                        <td><strong id="resultFormule">STANDARD</strong></td>
                    </tr>
                    <tr>
                        <td>Prime annuelle</td>
                        <td><strong id="primeBase">54 945</strong> FCFA</td>
                    </tr>
                    <tr>
                        <td>Surprime pathologies</td>
                        <td><strong id="primePathologie">0</strong> FCFA</td>
                    </tr>
                </table>

                <div id="listePathologies" class="patho-badges"></div>

                <div class="total-box" id="totalBox">
                    TOTAL : <span id="primeTotale">54 945</span> FCFA
                </div>

                <button class="btn-souscrire" id="start-btn">Souscrire</button>

            </div>

        </div>

    </div>

</div>

<script>
    const COLORS = {
        std:  '#185FA5',
        ser:  '#BA7517',
        prem: '#3B6D11'
    };

    let formuleSelectionnee = { nom: 'STANDARD', prime: 54945, cls: 'std' };
    const surprimePathologie = 5500;

    const formuleCards = document.querySelectorAll('.formula-card');
    const pathologies  = document.querySelectorAll('.pathologie');

    formuleCards.forEach(card => {
        card.addEventListener('click', function () {
            formuleCards.forEach(c => c.classList.remove('active'));
            this.classList.add('active');
            formuleSelectionnee.nom   = this.dataset.formule;
            formuleSelectionnee.prime = parseInt(this.dataset.prime);
            formuleSelectionnee.cls   = ['std','ser','prem'].find(c => this.classList.contains(c));
            calculerPrime();
        });
    });

    pathologies.forEach(p => {
        p.addEventListener('change', function () {
            if (this.checked) document.getElementById('bonneSante').checked = false;
            calculerPrime();
        });
    });

    document.getElementById('bonneSante').addEventListener('change', function () {
        if (this.checked) {
            pathologies.forEach(p => p.checked = false);
            calculerPrime();
        }
    });

    function fmt(n) {
        return n.toLocaleString('fr-FR');
    }

    function calculerPrime() {
        let totalPathologie = 0;
        let liste = [];

        pathologies.forEach(p => {
            if (p.checked) { totalPathologie += surprimePathologie; liste.push(p.value); }
        });

        const total = formuleSelectionnee.prime + totalPathologie;
        const col   = COLORS[formuleSelectionnee.cls];

        document.getElementById('resultFormule').textContent   = formuleSelectionnee.nom;
        document.getElementById('primeBase').textContent       = fmt(formuleSelectionnee.prime);
        document.getElementById('primePathologie').textContent = fmt(totalPathologie);
        document.getElementById('primeTotale').textContent     = fmt(total);
        document.getElementById('resHeader').style.background  = col;
        document.getElementById('totalBox').style.background   = col;

        document.getElementById('listePathologies').innerHTML =
            liste.map(i => `<span class="badge-patho">${i}</span>`).join('');

        sessionStorage.setItem('simulationData', JSON.stringify({
            formule: formuleSelectionnee.nom,
            primeBase: formuleSelectionnee.prime,
            surprimePathologies: totalPathologie,
            totalPrime: total,
            pathologies: liste
        }));

        document.getElementById('start-btn').addEventListener('click', function () {

            const data = sessionStorage.getItem('simulationData');

            console.log(data);

            this.innerHTML = '<i class="bx bx-loader-alt bx-spin"></i> Chargement...';
            this.disabled = true;

            if (data) {

                setTimeout(() => {
                    window.location.href = '/production/create/add/LFFUN';
                }, 300);

            } else {

                this.innerHTML = 'Souscrire';
                this.disabled = false;

            }

        });
    }

    calculerPrime();
</script>

@endsection
