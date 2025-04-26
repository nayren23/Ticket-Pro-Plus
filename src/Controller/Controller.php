<?php
require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class Controller
{
    private $module;
    public $resultat;
    public function __construct()
    {
        $this->module = isset($_GET['module']) ? $_GET['module'] : 'login';
        $this->exec();
    }

    public function exec()
    {
        require_once("./Common/GenericClass/UserExist.php");
        $userExist = new UserExist();
        $userExist->doUserExist();

        switch ($this->module) {

            case "login":
                require_once "modules/LoginMod/LoginMod.php"; // pour les Faille include 
                $this->module = new LoginMod();
                $this->resultat = $this->module->getController()->getViewController()->showTampon(); //affichage du tampon
                break;
            case "compte":
                if (isset($_SESSION["login"])) {  //page accessible uniquement si on est connecter
                    require_once "modules/AccountMod/AccountMod.php"; // pour les Faille include 
                    $this->module = new AccountMod();
                } else {
                    echo "connecte toi d'abord";
                }
                break;


            case "administration":
                require_once "Admin/AdminMod/AdminLoginMod/AdminLoginMod.php"; // pour les Faille include 
                $this->module = new AdminLoginMod();
                $this->resultat = $this->module->getController()->getViewController()->showTampon(); //affichage du tampon
                break;

            default:
                die(showError404()); //on peut changer l'affichage ici
        }
        if (isset($_SESSION["login"])) {  //page accessible uniquement si on est connecter
            $this->resultat = $this->module->getController()->getViewController()->showTampon(); //affichage du tampon
        }
    }
}