<?php
session_start();

use TicketProPlus\App\Config;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/../src/Config/Database.php";

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

define('SITE_ROOT', __DIR__);
define("APP_SECRET", $_ENV["APP_SECRET"]); //Définition d'une constante pour vérifier ensuite quand o*n accède au fichier qu'on soit bien passé par l'index

$conn = new Config\Database();

require_once __DIR__ .  "/../src/Core/template.php"; //affichage du site 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
