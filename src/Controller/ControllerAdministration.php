<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

class ControllerAdministration
{
    private $module;
    public $resultat;
    public function __construct()
    {
        $this->module = isset($_GET['module']) ? $_GET['module'] : 'gestionUseur';
        $this->exec();
    }

    public function exec()
    {
        switch ($this->module) {

            case "administration":
                require_once "Admin/AdminMod/AdminLoginMod/AdminLoginMod.php"; // pour les Faille include 
                $this->module = new AdminLoginMod();
                $this->resultat = $this->module->getController()->getViewController()->affichageTampon(); //affichage du tampon
                break;

            case "gestionUseur":
                if (isset($_SESSION["identifiant"])) {  //page accessible uniquement si on est connecter
                    require_once "Admin/AdminMod/UserManagerMod/UserManagerMod.php"; // pour les Faille include 
                    $this->module = new UserManagerMod();
                } else {
                    echo "connecte toi d'abord";
                }
                break;

            default:
                die(showError404Admin());
        }
        if (isset($_SESSION["identifiant"])) {  //page accessible uniquement si on est connecter
            $this->resultat = $this->module->getController()->getViewController()->affichageTampon(); //affichage du tampon
        }
    }
}
