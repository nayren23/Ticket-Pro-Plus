<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
	die(affichage_erreur404());

//fichier APPELLER DANS cont_connexio, modele_connexion

    //fonction qui creer un token unique pour un formulaire par ex
     function creation_token() {
        $bytes = random_bytes(20);//on genere un nombre random
        $_SESSION['token'] = bin2hex($bytes);//Convertit le nb random en représentation hexadécimale
        $_SESSION['token_date'] = time();// Retourne l'horodatage UNIX actuel
    }

     function verification_token() {
        return strcmp($_POST['token'], $_SESSION['token']) == 0 && time() - $_SESSION['token_date'] < 300;//10 minutes
    }
?>