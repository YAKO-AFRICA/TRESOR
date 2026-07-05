import { getPropositions, getDashbordData, getDdcData, getVilles, getProfessions } from './reduce.js';

function formatMoney(value){
    return Number(value ?? 0).toLocaleString('fr-FR') + ' FCFA';
}

document.addEventListener('DOMContentLoaded', async function() {
    // Si on n'est pas sur une page contenant le dashboard/tableau ou les éléments attendus,
    // ne pas exécuter le code lourd (charts, fetchs globaux) pour éviter de bloquer l'UI.
    if (!document.getElementById('chartActivite') && !document.getElementById('chartDonut') && !document.getElementById('result')) {
        return;
    }
    /* =========================
       CACHE DOM
    ==========================*/
    const el = {
        primeCumule: document.getElementById('primeCumule'),
        percent: document.getElementById('objectifPercent'),
        bar: document.getElementById('objectifBar'),
        text: document.getElementById('objectifText'),
        countSaisie: document.getElementById('countSaisie'),
        coutSaisieWeek: document.getElementById('coutSaisieWeek'),
        countTransmis: document.getElementById('countContratTransmis'),
        countTransmisActif: document.getElementById('countContratTransmisActifYear'),
        countAccepte: document.getElementById('countContratAccepteYear'),
        tauxAccept: document.getElementById('tauxAcceptPercent'),
        countRejet: document.getElementById('countRejetesYear'),
        tauxRejet: document.getElementById('tauxRejetPercent'),
        btnWeek: document.getElementById('btnWeek'),
        btnMonth: document.getElementById('btnMonth'),
        objectif: document.getElementById('objectif')
    };

    /* =========================
       CHART INIT (une seule fois)
    ==========================*/
    const ctx = document.getElementById('chartActivite');
    const chartActivite = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [],
            datasets: [
                {
                    label: 'Transmis',
                    data: [],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,.05)',
                    tension: .4,
                    fill: true
                },
                {
                    label: 'Acceptées',
                    data: [],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,.05)',
                    tension: .4,
                    fill: true
                }
            ]
        },
        options:{
            responsive:true,
            maintainAspectRatio:false,
            plugins:{legend:{display:false}}
        }
    });

    function updateChart(labels, transmis, acceptes){
        chartActivite.data.labels = labels;
        chartActivite.data.datasets[0].data = transmis;
        chartActivite.data.datasets[1].data = acceptes;
        chartActivite.update();
    }

    /* =========================
       LOAD DASHBOARD PRIORITY
    ==========================*/
    const data = await getDashbordData();
    
    console.log(data.produits);

    /* =========================
       OBJECTIF
    ==========================*/
    const objectif = 100;
    el.objectif.innerHTML = formatMoney(objectif);

    const montant = Number(data.primeMonthCumule ?? 0);
    const percent = Math.min((montant / objectif) * 100, 100);
    const reste = objectif - montant;

    el.primeCumule.innerHTML = formatMoney(data.primeYearCumule);
    el.percent.innerHTML = percent.toFixed(0) + '%';
    el.bar.style.width = percent + '%';

    el.text.innerHTML =
        `Realisé : ${formatMoney(montant)} · Reste : ${formatMoney(reste>0?reste:0)}`;

    /* =========================
       COUNT
    ==========================*/
    el.countSaisie.innerHTML = data.contratsYear ?? 0;
    el.coutSaisieWeek.innerHTML = data.contratsWeek ?? 0;
    el.countTransmis.innerHTML = data.transmisYear ?? 0;
    el.countTransmisActif.innerHTML = data.transmisActifYear ?? 0;
    el.countAccepte.innerHTML = data.accepteYear ?? 0;
    el.tauxAccept.innerHTML = data.tauxAcceptPercent ?? 0;
    el.countRejet.innerHTML = data.rejetesYear ?? 0;
    el.tauxRejet.innerHTML = data.tauxRejetPercent ?? 0;

    /* =========================
       CHART DEFAULT WEEK
    ==========================*/
    updateChart(
        data.chart.week.labels,
        data.chart.week.transmis,
        data.chart.week.acceptes
    );

    el.btnWeek.onclick = () => {
        updateChart(
            data.chart.week.labels,
            data.chart.week.transmis,
            data.chart.week.acceptes
        );
    };

    el.btnMonth.onclick = () => {
        updateChart(
            data.chart.month.labels,
            data.chart.month.transmis,
            data.chart.month.acceptes
        );
    };

    let donutChart = null;

    function initDonutChart(produits){
        const colors = ['#3b82f6','#8b5cf6','#10b981','#f59e0b','#ef4444','#ec4899'];

        const labels = produits.map(p => p.libelleproduit);
        const dataProduits = produits.map(p => Number(p.total));
        const primeProduits = produits.map(p => Number(p.primeCumule ?? 0));

        if(donutChart){
            donutChart.destroy();
        }

        donutChart = new Chart(document.getElementById('chartDonut'), {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: dataProduits,
                    backgroundColor: colors,
                    borderWidth: 0,
                    hoverOffset: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });

        // legend avec cumul des primes
        const lg = document.getElementById('donutLegend');
        lg.innerHTML = '';

        labels.forEach((label,i)=>{
            lg.innerHTML += `
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:10px;height:10px;background:${colors[i]};border-radius:50%"></div>
                        <span class="small">${label}</span>
                    </div>
                    <span class="small fw-semibold">${Number(primeProduits[i]).toLocaleString('fr-FR')} FCFA</span>
                </div>
            `;
        });
    }

    // default year
    initDonutChart(data.produits.year);

    const btns = document.querySelectorAll('.btnProd');
    const label = document.getElementById('prodTimeLabel');

    btns.forEach(btn=>{
        btn.addEventListener('click', ()=>{
            btns.forEach(b=>b.classList.remove('active'));
            btn.classList.add('active');

            if(btn.id === 'btnProdYear'){
                label.textContent = "Année en cours";
                initDonutChart(data.produits.year);
            } else {
                label.textContent = "Mois en cours";
                initDonutChart(data.produits.month);
            }
        });
    });


    /* =========================
       LOAD TABLE ASYNC (non bloquant)
    ==========================*/
    setTimeout(async () => {

        const resultBody = document.getElementById('result');
        if (!resultBody) return;

        const communeList = await getPropositions();

        resultBody.innerHTML = communeList.length
            ? communeList.map(item => `
                <tr>
                    <td>${item.IdTblBranche}</td>
                    <td>${item.CodeBranche}</td>
                    <td>${item.MonLibelle}</td>
                    <td>${item.ID_Old}</td>
                </tr>
            `).join('')
            : `<tr>
                 <td colspan="4" class="text-danger text-center">
                    Aucune donnée valide reçue
                 </td>
               </tr>`;

    }, 50); // charge après dashboard

});

    document.addEventListener('DOMContentLoaded', async function() {
            // Ne charger les listes villes/professions que si les selecteurs existent sur la page
            const villeSelect = document.getElementById('lieuresidence');
            const lieuSelect = document.getElementById('lieunaissance');
            const professionSelect = document.getElementById('profession');

            if (!villeSelect && !lieuSelect && !professionSelect) {
                return;
            }

            // Récupération des villes et professions
            try {
                const villes = await getVilles();
                const professions = await getProfessions();

                // Ajouter les villes aux deux selecteurs
                villes.forEach(ville => {
                    if (villeSelect) {
                        const optionVille = document.createElement('option');
                        optionVille.value = ville.MonLibelle;
                        optionVille.textContent = ville.MonLibelle;
                        villeSelect.appendChild(optionVille);
                    }

                    if (lieuSelect) {
                        const optionLieu = document.createElement('option');
                        optionLieu.value = ville.MonLibelle;
                        optionLieu.textContent = ville.MonLibelle;
                        lieuSelect.appendChild(optionLieu);
                    }
                });

                if (villeSelect) {
                    villeSelect.addEventListener('change', function() {
                        console.log('🔄 SELECT ville changé:', this.name, '=', this.value);
                        // Mettre à jour la session
                        updateSessionField(this.name, this.value);
                    });
                    console.log('✅ Écouteur attaché à villeSelect');
                }

                // Ajouter les professions
                if (professionSelect) {
                    professions.forEach(profession => {
                        const optionProfession = document.createElement('option');
                        optionProfession.value = profession.MonLibelle;
                        optionProfession.textContent = profession.MonLibelle;
                        professionSelect.appendChild(optionProfession);
                    });
                }

            } catch (error) {
                console.error('Erreur lors du chargement des données:', error);
            }
        
    });

    document.addEventListener('DOMContentLoaded', function() {
      

            function getSessionData() {
                const raw = sessionStorage.getItem('souscriptionData');
                let data = {};
                try {
                    data = raw ? JSON.parse(raw) : {};
                } catch (e) {
                    console.error("Erreur de parsing JSON sessionStorage:", e);
                }
                if (!data.adherentData) {
                    data.adherentData = {};
                }
                return data;
            }

            function saveSessionData(data) {
                sessionStorage.setItem('souscriptionData', JSON.stringify(data));
                console.log("✅ Données enregistrées dans la session :", data);
            }

            function updateSessionField(name, value) {
                const data = getSessionData();
                data.adherentData[name] = value;
                saveSessionData(data);
            }

            const fieldSelectors = [
                'input[name="civilite"]',
                'input[name="situation_matrimoniale"]',
                'input[name="naturepiece"]',
                'input[name="nom"]',
                'input[name="prenom"]',
                'input[name="datenaissance"]',
                'input[name="numeropiece"]',
                'input[name="email"]',
                'input[name="mobile"]',
                'input[name="mobile1"]',
                'input[name="telephone"]',
                'input[name="personneressource"]',
                'input[name="contactpersonneressource"]',
                'input[name="personneressource2"]',
                'input[name="contactpersonneressource2"]',
                'select[name="lieunaissance"]',
                'select[name="lieuresidence"]',
                'select[name="paysDeNaissance"]',
                'select[name="profession"]',
                'select[name="employeur"]',
                'input[type="file"]',
            ];

            fieldSelectors.forEach(selector => {
                document.querySelectorAll(selector).forEach(element => {
                    const type = element.type;

                    if (type === 'radio') {
                        element.addEventListener('change', function() {
                            if (this.checked) {
                                updateSessionField(this.name, this.value);
                            }
                        });
                    } 
                    else if (type === 'text' || type === 'email' || type === 'tel' || type === 'date') {
                        element.addEventListener('input', function() {
                            updateSessionField(this.name, this.value);
                        });
                    }
                    else if (type === 'select-one') {
                        element.addEventListener('change', function () {
                            console.log('SELECT', this.name, this.value);
                            updateSessionField(this.name, this.value);
                        });
                    }
                    else if (type === 'file') {
                        element.addEventListener('change', function() {
                            if (this.files.length > 0) {
                                updateSessionField(this.name, this.files[0].name);
                            }
                        });
                    }
                });
            });
        });


    // donnée pour dashboard DDC

    document.addEventListener('DOMContentLoaded', async function() {
        // Eviter d'exécuter cette requête si le dashboard n'est pas présent
        if (!document.getElementById('chartActivite') && !document.getElementById('chartDonut')) {
            return;
        }

        const getDcData = await getDdcData();
        console.log('Données DDC:');
        console.log(getDcData);
        
    });