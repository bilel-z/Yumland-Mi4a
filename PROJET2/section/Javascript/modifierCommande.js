function calculerTotal(articles) {
    let total = 0;
    for (let i = 0; i < articles.length; i++) {
        total += articles[i].sous_total;
    }
    return Math.round(total * 100) / 100;
}

function getArticles() {
    const lignes = document.querySelectorAll('#articlesList .article-ligne');
    const articles = [];
    lignes.forEach(function(ligne) {
        const qte = parseInt(ligne.querySelector('.article-qte').textContent);
        if (qte > 0) {
            const nom  = ligne.dataset.nom;
            const prix = parseFloat(ligne.dataset.prix);
            articles.push({
                nom: nom,
                prix_unitaire: prix,
                quantite: qte,
                sous_total: Math.round(prix * qte * 100) / 100
            });
        }
    });
    return articles;
}

function recalculerTotal() {
    const articles = getArticles();
    const nouveauTotal = calculerTotal(articles);
    const diff = Math.round((nouveauTotal - ancienTotal) * 100) / 100;

    document.getElementById('nouveauTotal').textContent =
        nouveauTotal.toFixed(2).replace('.', ',') + ' €';

    const msgEl = document.getElementById('messageDiff');
    if (diff > 0) {
        msgEl.textContent = 'Supplément à payer : ' + diff.toFixed(2).replace('.', ',') + ' €';
        msgEl.style.color = '#ef2711';
    } else if (diff < 0) {
        msgEl.textContent = 'Votre commande est moins chère de ' + Math.abs(diff).toFixed(2).replace('.', ',') + ' € (pas de remboursement).';
        msgEl.style.color = '#f39c12';
    } else {
        msgEl.textContent = 'Aucun changement de prix.';
        msgEl.style.color = '#2ecc71';
    }
}

function augmenterQte(btn) {
    const qteEl = btn.previousElementSibling;
    qteEl.textContent = parseInt(qteEl.textContent) + 1;
    recalculerTotal();
}

function diminuerQte(btn) {
    const qteEl = btn.nextElementSibling;
    const qte   = parseInt(qteEl.textContent);
    if (qte > 1) {
        qteEl.textContent = qte - 1;
    } else {
        btn.closest('.article-ligne').remove();
    }
    recalculerTotal();
}

function supprimerArticle(btn) {
    btn.closest('.article-ligne').remove();
    recalculerTotal();
}

function trouverArticleExistant(liste, nom) {
    const lignes = liste.querySelectorAll('.article-ligne');
    for (let i = 0; i < lignes.length; i++) {
        if (lignes[i].dataset.nom === nom) {
            return lignes[i];
        }
    }
    return null;
}

function ajouterPlat(nom, prix) {
    const liste = document.getElementById('articlesList');
    const existant = trouverArticleExistant(liste, nom);

    if (existant) {
        const qteEl = existant.querySelector('.article-qte');
        qteEl.textContent = parseInt(qteEl.textContent) + 1;
    } else {
        const div = document.createElement('div');
        div.className = 'article-ligne';
        div.dataset.nom  = nom;
        div.dataset.prix = prix;
        div.innerHTML =
            '<span class="article-nom">'  + nom + '</span>' +
            '<span class="article-prix">' + prix.toFixed(2).replace('.', ',') + ' €</span>' +
            '<button class="btn-qte" onclick="diminuerQte(this)">−</button>' +
            '<span class="article-qte">1</span>' +
            '<button class="btn-qte" onclick="augmenterQte(this)">+</button>' +
            '<button class="btn-suppr" onclick="supprimerArticle(this)">Supprimer</button>';
        liste.appendChild(div);
    }
    recalculerTotal();
}

function soumettreFormulaireCybank(cybank) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'https://www.plateforme-smc.fr/cybank/index.php';
    for (const key in cybank) {
        const input = document.createElement('input');
        input.type  = 'hidden';
        input.name  = key;
        input.value = cybank[key];
        form.appendChild(input);
    }
    document.body.appendChild(form);
    form.submit();
}

function validerModification() {
    const articles = getArticles();
    if (articles.length === 0) {
        afficherMessage('Votre commande ne peut pas être vide.', 'erreur');
        return;
    }

    const nouveauTotal = calculerTotal(articles);

    fetch('section/sauvegarderModification.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ commande_id: commandeId, articles: articles, nouveau_total: nouveauTotal })
    })
    .then(function(r) { return r.json(); })
    .then(function(data) {
        if (data.succes) {
            if (data.paiement_requis && data.cybank) {
                soumettreFormulaireCybank(data.cybank);
            } else {
                afficherMessage('Commande modifiée avec succès !', 'succes');
                setTimeout(function() { window.location.href = 'Historique.php'; }, 2000);
            }
        } else {
            afficherMessage(data.erreur || 'Une erreur est survenue.', 'erreur');
        }
    })
    .catch(function() { afficherMessage('Erreur de connexion au serveur.', 'erreur'); });
}

function afficherMessage(texte, type) {
    const el  = document.getElementById('messageRetour');
    el.textContent = texte;
    el.className   = type;
}
