<?php 
    //Compte le nombre de fois qu'un plat apparaît dans le panier
    function ComptePanier($liste,$nom){
        if(isset($liste)){
            $cpt = 0;
            for($i=0;$i<count($liste);$i++){
                if($liste[$i][0] == $nom){
                    $cpt++;
                }
            }
            return $cpt;
        }
    }

    //Supprime une occurence d'un plat du panier en cherchant par nom et par prix
    function SupprPanier(&$liste,$nom,$prix){
        if(in_array(array($nom,$prix),$liste)){
            $i=0;
            while($liste[$i] != array($nom,$prix)){
                $i++;
            }
            unset($liste[$i]);
        }
        $liste = array_values($liste);
    }

    //Retourne la liste des plats sans doublons avec leur nom et prix
    function listeUnique($liste){
        $unique = [];
        foreach($liste as $plat){
            if(!isset($unique[$plat[0]])){
                $unique[$plat[0]] = array("nom" => $plat[0], "prix" => $plat[1]);
            }
        }
        return $unique;
    }
    //Calcule et retourne le prix total de tous les articles du panier
    function total($liste){
        $cpt = 0;
        if(isset($liste)){
            foreach($liste as $plat){
                $cpt += (float)$plat[1];
            }
        }
        return $cpt;
    }
    //Lit un fichier JSON et la retourne sous forme de tableau
    function lireJson($chemin){
        if(!file_exists($chemin)){
            return [];
        }

        $contenu = file_get_contents($chemin);
        if($contenu === false || trim($contenu) === ''){
            return [];
        }

        $donnees = json_decode($contenu, true);
        return is_array($donnees) ? $donnees : [];
    }
    //Enregistre un tableau en JSON
    function ecrireJson($chemin, $donnees){
        $json = json_encode($donnees, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return file_put_contents($chemin, $json);
    }
    //Génère un identifiant de transaction aléatoire

    function genererTransaction() {
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $transaction = '';
    for ($i = 0; $i < 15; $i++) {
        $transaction .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $transaction;
}
    //Retourne la clé API CYBank associée au vendeur donné
    function getAPIKey($vendeur){
	if(in_array($vendeur, array('MI-1_A', 'MI-1_B', 'MI-1_C', 'MI-1_D', 'MI-1_E', 'MI-1_F', 'MI-1_G', 'MI-1_H', 'MI-1_I', 'MI-1_J', 'MI-2_A', 'MI-2_B', 'MI-2_C', 'MI-2_D', 'MI-2_E', 'MI-2_F', 'MI-2_G', 'MI-2_H', 'MI-2_I', 'MI-2_J', 'MI-3_A', 'MI-3_B', 'MI-3_C', 'MI-3_D', 'MI-3_E', 'MI-3_F', 'MI-3_G', 'MI-3_H', 'MI-3_I', 'MI-3_J', 'MI-4_A', 'MI-4_B', 'MI-4_C', 'MI-4_D', 'MI-4_E', 'MI-4_F', 'MI-4_G', 'MI-4_H', 'MI-4_I', 'MI-4_J', 'MI-5_A', 'MI-5_B', 'MI-5_C', 'MI-5_D', 'MI-5_E', 'MI-5_F', 'MI-5_G', 'MI-5_H', 'MI-5_I', 'MI-5_J', 'MEF-1_A', 'MEF-1_B', 'MEF-1_C', 'MEF-1_D', 'MEF-1_E', 'MEF-1_F', 'MEF-1_G', 'MEF-1_H', 'MEF-1_I', 'MEF-1_J', 'MEF-2_A', 'MEF-2_B', 'MEF-2_C', 'MEF-2_D', 'MEF-2_E', 'MEF-2_F', 'MEF-2_G', 'MEF-2_H', 'MEF-2_I', 'MEF-2_J', 'MIM_A', 'MIM_B', 'MIM_C', 'MIM_D', 'MIM_E', 'MIM_F', 'MIM_G', 'MIM_H', 'MIM_I', 'MIM_J', 'SUPMECA_A', 'SUPMECA_B', 'SUPMECA_C', 'SUPMECA_D', 'SUPMECA_E', 'SUPMECA_F', 'SUPMECA_G', 'SUPMECA_H', 'SUPMECA_I', 'SUPMECA_J', 'TEST'))) {
		return substr(md5($vendeur), 1, 15);
	}
	return "zzzz";
	}
	//Convertit le tableau du panier en liste d'articles avec quantités et sous totaux
    function convertirPanierEnArticles($panier){
        $articles = [];
        foreach($panier as $plat){
            $nom = $plat[0];
            $prix = (float)$plat[1];
            if(!isset($articles[$nom])){
                $articles[$nom] = [
                    'nom' => $nom,
                    'prix_unitaire' => $prix,
                    'quantite' => 0,
                    'sous_total' => 0
                ];
            }
            $articles[$nom]['quantite']++;
            $articles[$nom]['sous_total'] = round($articles[$nom]['quantite'] * $prix, 2);
        }
        return array_values($articles);
    }

    //Retourne le statut initial d'une commande selon son moment de préparation
    function formaterStatutCommande($commande){
        if(isset($commande['moment_preparation']) && $commande['moment_preparation'] === 'plus_tard'){
            return 'à attendre';
        }
        return 'à préparer';
    }

    function echapper($valeur){
        return htmlspecialchars((string)($valeur ?? ''), ENT_QUOTES, 'UTF-8');
    }

    //Nettoie une entrée utilisateur en supprimant les espaces, caractères dangereux et en limitant la longueur
    function nettoyerEntree($valeur, $longueurMax = 255){
        $valeur = trim((string)$valeur);
        $valeur = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', $valeur);
        if (function_exists('mb_strlen') && mb_strlen($valeur) > $longueurMax){
            $valeur = mb_substr($valeur, 0, $longueurMax);
        } elseif (strlen($valeur) > $longueurMax){
            $valeur = substr($valeur, 0, $longueurMax);
        }
        return $valeur;
    }

    //Configure le cookie de session avec des options de sécurité avant de démarrer la session
    function securiserCookieSession(){
        if (session_status() === PHP_SESSION_ACTIVE){
            return; 
        }
        $https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');
        session_set_cookie_params([
            'lifetime' => 0,
            'path'     => '/',
            'httponly' => true,   
            'secure'   => $https, 
            'samesite' => 'Lax'   
        ]);
    }

    //Vérifie que la requête POST provient bien du site
    function requeteInterne(){
        if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST'){
            return true;
        }
        $hote = $_SERVER['HTTP_HOST'] ?? '';
        $origine = $_SERVER['HTTP_ORIGIN'] ?? '';
        if ($origine !== ''){
            return parse_url($origine, PHP_URL_HOST) === parse_url('http://' . $hote, PHP_URL_HOST);
        }
        $referer = $_SERVER['HTTP_REFERER'] ?? '';
        if ($referer !== ''){
            return parse_url($referer, PHP_URL_HOST) === parse_url('http://' . $hote, PHP_URL_HOST);
        }
        return true;
    }
?>