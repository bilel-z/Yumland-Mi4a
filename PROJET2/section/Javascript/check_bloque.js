const CHECK_INTERVAL_MS = 5000;

const checksiBloque = async () => {
    try {
	const response = await fetch('section/check_bloque.php', {
    	method: 'GET'
	});

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();

        if (data.bloque) {
            clearInterval(checkInterval); // stop polling
            window.location.href = "section/deconnexion.php"; 
        }

    } catch (err) {
        console.warn("Vérification du blocage échouée :", err);
        
    }
};

// Start polling
const checkInterval = setInterval(checksiBloque, CHECK_INTERVAL_MS);

// Also check immediately on page load
checksiBloque();