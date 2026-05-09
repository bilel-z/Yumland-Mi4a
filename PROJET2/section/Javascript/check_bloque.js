const CHECK_INTERVAL_MS = 5000; // check every 5 seconds

const checkIfBlocked = async () => {
    try {
	const response = await fetch('section/check_bloque.php', {
    	method: 'GET'
	});

        if (!response.ok) throw new Error(`HTTP error: ${response.status}`);

        const data = await response.json();

        if (data.bloque) {
            clearInterval(checkInterval); // stop polling
            window.location.href = "section/deconnexion.php"; // redirect to logout
        }

    } catch (err) {
        console.warn("Vérification du blocage échouée :", err);
        // silent fail — don't disturb the user on a network hiccup
    }
};

// Start polling
const checkInterval = setInterval(checkIfBlocked, CHECK_INTERVAL_MS);

// Also check immediately on page load
checkIfBlocked();

function changerVisibilite(){
    document.body.classList.toggle("modeGras");
}

themeChargement();