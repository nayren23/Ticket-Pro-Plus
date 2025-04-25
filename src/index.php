<?php

session_start();
require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('SITE_ROOT', __DIR__);
define("APP_SECRET", $_ENV["APP_SECRET"]); //définition d'une constante pour vérifier ensuite quand on accède au fichier qu'on soit bien passé par l'index

require_once "config/Database.php";
require_once("./Common/GenericClass/GenericView.php");
require_once("Controller/controller.php");
require_once("Controller/ControllerAdministration.php");
require_once("./Common/GenericClass/GenericController.php"); //on le fait ici car il est utilisé par plusieurs Controller
require_once("./AdminCheck.php");

$conn = new Database();

//Pour la partie Admin
$adminCheck = new AdminCheck();
if ($adminCheck->isAdmin()) {
    $Controller = new ControllerAdministration();
    require_once("./Template/TemplateAdmin.php"); //affichage du site 
}
//Pour la partie Useur
else {
    $Controller = new Controller();
    require_once("./Template/Template.php"); //affichage du site 
}
