    //Fonction qui bloque ou débloque un utilisateur en envoyant la nouvelle valeur au serveur
    const toggleBloquer = async (btn) => {
        const userId  = btn.dataset.userId;
        const estBloque = btn.dataset.bloque === '1';   // état actuel
        const nouvelEtat = estBloque ? 0 : 1;           // on inverse

        btn.disabled = true;

        try {
            const formData = new FormData();
            formData.append('user-id', userId);
            formData.append('bloque', nouvelEtat);

            const response = await fetch('Admin.php', {
                method: 'POST',
                body: formData
            });

            if (!response.ok) throw new Error(`Erreur HTTP : ${response.status}`);

            const text = await response.text();
            const data = JSON.parse(text.match(/\{.*\}/s)[0]);

            if (data.success) {
                btn.dataset.bloque = data.bloque ? '1' : '0';
                btn.textContent    = data.bloque ? '🔓 Débloquer' : '🔒 Bloquer';
            }
        } catch (err) {
            console.error('Erreur blocage :', err);
        } finally {
            btn.disabled = false;
        }
    };

	//On écoute les clics sur le tableau pour déclencher le blocage au clic sur le bon bouton
	document.addEventListener('DOMContentLoaded', () => {
	 const maTable = document.querySelector('table');
	if (maTable) {
        maTable.addEventListener('click', (e) => {
            const btn = e.target.closest('.btn-bloque');
            if (btn) toggleBloquer(btn);
        });
    }
});
