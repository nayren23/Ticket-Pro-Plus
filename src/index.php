<?php

session_start();
define('SITE_ROOT', __DIR__);
define("a2z", "rya"); //définition d'une constante pour vérifier ensuite quand on accède au fichier qu'on soit bien passé par l'index

require_once "config/database.php";
require_once("./Common/Classe_Generique/vue_generique.php");
require_once("controleur/controleur.php");
require_once("controleur/controleur_administration.php");
require_once("./Common/Classe_Generique/controleur_generique.php"); //on le fait ici car il est utilisé par plusiseur controleur
require_once("./verificationAdmin.php");

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Maintenant tu peux accéder à tes variables d'environnement
$conn = new Database();


//Pour la partie Admin
$verifAdmin = new VerifAdmin();
if ($verifAdmin->verificationConnexionAdmin()) {
    $controleur = new Controleur_administration();
    require_once("./Template/template_Administrateur.php"); //affichage du site 
}
//Pour la partie Useur
else {
    $controleur = new Controleur();
    require_once("./Template/template.php"); //affichage du site 
}

?>