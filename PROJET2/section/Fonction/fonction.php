<?php 
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

    function listeUnique($liste){
        $unique = [];
        foreach($liste as $plat){
            if(!isset($unique[$plat[0]])){
                $unique[$plat[0]] = array("nom" => $plat[0], "prix" => $plat[1]);
            }
        }
        return $unique;
    }

    function total($liste){
        if(isset($liste)){
            $cpt = 0;
            foreach($liste as $plat){
                $cpt += $plat[1];
            }
        }
        return $cpt;
    }
?>