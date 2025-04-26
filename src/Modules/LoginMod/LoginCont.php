<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "LoginView.php";
require_once "LoginModel.php";
require_once("./Common/CommonLib/TokenManager.php");

class LoginCont extends GenericController
{

    public function __construct()
    {
        $this->view = new LoginView();
        $this->model = new LoginModel();
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'login');
    }

    //execution qui est appelle dans le AdminLoginMod
    public function exec()
    {
        switch ($this->action) {

            ////////////////////////////////////////////////// INSCRIPTION ///////////////////////////////////////////////////////
            case 'signup':
                $this->affichageFormulaireInscription();
                break;

            case 'createAccount':
                $resultatInsereDonneInscription = $this->insereDonneInscription();
                break;

            ////////////////////////////////////////////////// CONNEXION ///////////////////////////////////////////////////////
            case 'login':
                $this->afficherFormulaireConnexion();
                break;

            case 'idCheck':
                $this->insereDonneConnexion();
                break;

            ////////////////////////////////////////////////// DECONNEXION ///////////////////////////////////////////////////////
            case 'deconnexion':
                if ($this->deconnexion()) {
                    header('Location: ./index.php?module=login&action=connexion&DeconnexionReussite=true');
                } else {
                    header('Location: ./index.php?module=login&action=connexion&erroDeconnexion=true');
                }
                break;
            default:
                die(showError404());
        }
    }

    ////////////////////////////////////////////////// INSCRIPTION ///////////////////////////////////////////////////////

    public function affichageFormulaireInscription()
    {
        createToken();
        $this->view->form_inscription();
    }

    public function insereDonneInscription()
    {
        return  $this->model->insereInscription();
    }

    ////////////////////////////////////////////////// CONNEXION ///////////////////////////////////////////////////////

    public function afficherFormulaireConnexion()
    {
        createToken();
        $this->view->form_connexion();
    }

    public function insereDonneConnexion()
    {
        return  $this->model->verificationConnexion(1);
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
