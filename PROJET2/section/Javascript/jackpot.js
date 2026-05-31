const SYMBOLES = {
    panda:    '<img src="image/pandaLogo.png" style="width:80px;height:80px;object-fit:cover;border-radius:8px;">',
    nouilles: '🍜',
    crevette: '🦐',
    nems:     '🥟'
};

const KEYS = Object.keys(SYMBOLES);
const history = [];

async function spin() {
    const btn = document.getElementById('spinBtn');
    btn.disabled = true;
    //prépare chacune des cases de la machine
    const reels = [
        document.getElementById('r0'),
        document.getElementById('r1'),
        document.getElementById('r2'),
    ];
    //les fait vibrer pour le suspens
    reels.forEach(r => {
        r.classList.add('spinning');
        r.classList.remove('win');
    });

    const msg = document.getElementById('msg');
    msg.className = 'result-msg';
    msg.textContent = '...';

    try {
        //recupere les données du fichier php, lance ou affiche un message selon la date du dernier lance
        const response = await fetch('section/jackpot.php');
        if (!response.ok) throw new Error('HTTP ' + response.status);
        const text = await response.text();
        const data = JSON.parse(text.match(/\{.*\}/s)[0]);

        if (data.erreur) {
            msg.textContent = data.deja_jouer ? '⏳ Vous avez déjà joué aujourd\'hui !' : data.erreur;
            reels.forEach(r => r.classList.remove('spinning'));
            btn.disabled = false;
            return;
        }

        await new Promise(r => setTimeout(r, 600));
        //arrete la vibration et affiche les resultas 2 possibilités 
        reels.forEach((r, i) => {
            r.classList.remove('spinning');
            r.innerHTML = SYMBOLES[data.resultat[i]];
            if (data.victoire) r.classList.add('win');
        });

        if (data.victoire) {
            msg.className = 'result-msg win';
            msg.textContent = ' Skadoosh ! Un plat gratuit gagné !';
        } else {
            msg.textContent = 'Pas de chance... réessayez demain !';
        }

        history.unshift({ resultat: data.resultat, victoire: data.victoire });
        if (history.length > 5) history.pop();
        renderHistory();

    } catch (err) {
        reels.forEach(r => r.classList.remove('spinning'));
        msg.textContent = 'Erreur de connexion.';
        console.error(err);
    }

    btn.disabled = false;
}
// affiche l'historique
function renderHistory() {
    const wrap = document.getElementById('histWrap');
    const list = document.getElementById('histList');
    wrap.style.display = 'block';
    list.innerHTML = history.map(h =>
        `<div class="history-row">
            <span class="history-symbols">${h.resultat.map(s => SYMBOLES[s]).join('')}</span>
            <span class="badge ${h.victoire ? 'badge-win' : 'badge-lose'}">${h.victoire ? 'Gagné !' : 'Perdu'}</span>
        </div>`
    ).join('');
}

document.getElementById('spinBtn').addEventListener('click', spin);