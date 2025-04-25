<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

require_once "AdminLoginView.php";
require_once "./Common/GenericClass/GenericLoginModel.php";
require_once("./Common/CommonLib/TokenManager.php");

class AdminLoginCont extends GenericController
{
    public function __construct()
    {
        $this->view = new AdminLoginView;
        $this->model = new GenericLoginModel();
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'connexion');
    }

    //execution qui est appelle dans le AdminLoginMod
    public function exec()
    {
        switch ($this->action) {

            ////////////////////////////////////////////////// CONNEXION ///////////////////////////////////////////////////////
            case 'connexion':
                $this->afficherFormulaireConnexion_administration();
                break;

            case 'connexionidentifiant':
                if ($this->insereDonneConnexion()) {
                    header('Location: ./index.php?module=gestionUseur&action=gestionUseur&page=1&connexionReussit=true'); //redirection vers la page 
                } else {
                    header('Location: ./index.php?module=administration&action=connexion&errorConnexion=true'); //redirection vers la page 
                }
                break;

            ////////////////////////////////////////////////// DECONNEXION ///////////////////////////////////////////////////////
            case 'deconnexion':
                if ($this->deconnexion()) {
                    header('Location: ./index.php?module=administration&DeconnexionReussite=true');
                } else {
                    header('Location: ./index.php?module=administration&action=connexion&erroDeconnexion=true');
                }
                break;
            default:
                die(showError404Admin());
        }
    }

    ////////////////////////////////////////////////// CONNEXION ///////////////////////////////////////////////////////

    public function afficherFormulaireConnexion_administration()
    {
        createToken();
        $this->view->form_connexion_administration();
    }

    public function insereDonneConnexion()
    {
        return  $this->model->verificationConnexion(2);
    }

    ////////////////////////////////////////////////// DECONNEXION ///////////////////////////////////////////////////////

    public function affichageDeco()
    {
        $this->view->deconnexion();
    }

    public function deconnexion()
    {
        return  $this->model->deconnexionM();
    }
}
