<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "AccountView.php";
require_once "AccountModel.php";
require_once("./Common/CommonLib/TokenManager.php");
require_once("./Common/CommonLib/ImgManagers.php");

class AccountCont extends GenericController
{
    public function __construct()
    {
        $this->view = new AccountView;
        $this->model = new AccountModel;
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'affichageInfoCompte');
    }

    //execution qui est appelle dans le AccountMod
    public function exec() {}

    /////////////////////////////// Informations Compte//////////////////////////////////////

    public function affichageInformationsCompte()
    {
        $identifiant = $this->model->getUsers()["identifiant"];
        $motDePasse = $this->model->getUsers()["motDePasse"];
        $adresseMail = $this->model->getUsers()["adresseMail"];
        $this->view->affichageInfoCompte($identifiant, $motDePasse, $adresseMail);
    }

    ///////////////////////////////Identifiant//////////////////////////////////////

    public function affichageFormulaireModificationIdentifiant()
    {
        createToken();
        $this->view->form_modification_compte_identifiant();
    }

    public function changementIdentifiant()
    {
        return $this->model->changerIdentifiant();
    }
    ///////////////////////////////MotDePasse//////////////////////////////////////

    public function affichageFormulaireModificationMotDePasse()
    {
        createToken();
        $this->view->form_modification_compte_mot_de_passe();
    }

    public function changementMotDePasse()
    {
        return $this->model->changerMotDePasse();
    }
    ///////////////////////////////Adresse Mail//////////////////////////////////////
    public function changementAdresseMail()
    {
        return $this->model->changerAdresseMail();
    }

    public function affichageFormulaireModificationEmail()
    {
        createToken();
        $this->view->form_modification_compte_adressemail();
    }

    ///////////////////////////////Photo de Profile//////////////////////////////////////

    public function affichageChangementPhotoDeProfile()
    {
        $image = $this->model->getUsers()["cheminImage"];
        createToken();
        $this->view->modifiactionPhotoDeProfile($image);
    }

    public function affichageFormSuppresionPhotoDeProfile()
    {
        $image = $this->model->getUsers()["cheminImage"];
        $this->view->formSuppresionPhotoDeProfile($image);
    }
    //ici en fonction de ce que nous renvoie  recupererImage() on traite si c'est une erreur ou pas 
    public function changementPhotoDeProfile()
    {
        $image = getImg();

        switch ($image) {

            case 1; // erreur lors du transfert
                header('Location: ./index.php?module=compte&action=affichageInfoCompte&ErreurTansfert=true;'); //redirection vers la page  affichageInfoCompte
                break;

            case 2;  //taille trop grande
                header('Location: ./index.php?module=compte&action=affichageInfoCompte&ImageTropGrande=true;'); //redirection vers la page  affichageInfoCompte
                break;

            case 3; //fichier pas une image
                header('Location: ./index.php?module=compte&action=affichageInfoCompte&PasImage=true;'); //redirection vers la page  affichageInfoCompte
                break;

            default:
                $this->model->changementPhoto($image);
                header('Location: ./index.php?module=compte&action=affichageInfoCompte&changementPhoto=true;'); //redirection vers la page affichageInfoCompte

        }
    }

    public function suppresionPhotoDeProfile()
    {
        return $this->model->suppresionPhotoDeProfile();
    }
    //////////////////////////Affichage des Toast pour les Informations générales //////////////////////////////////////

    public function affichageChangementImageRate()
    {
        $this->view->affichageChangementImageRate();
    }

    public function affichageChangementIdentifiantReussit()
    {
        $this->view->affichageChangementIdentifiant();
    }
    public function affichageChangementIdentifiantFaux()
    {
        $this->view->affichageChangementIdentifiantFaux();
    }

    public function affichageChangementAdresseMailReussit()
    {
        $this->view->affichageChangementAdresseMailReussit();
    }

    public function affichageChangementAdresseMailFaux()
    {
        $this->view->affichageChangementAdresseMailFaux();
    }

    public function affichageChangementMDP()
    {
        $this->view->affichageChangementMDP();
    }

    public function affichageChangementPhoto()
    {
        $this->view->affichageChangementPhoto();
    }

    public function affichageImageTropGrande()
    {
        $this->view->affichageImageTropGrande();
    }

    public function affichageErreurTansfertImage()
    {
        $this->view->affichageErreurTansfertImage();
    }

    public function affichagesuppresionPhotoDeProfileErreur()
    {
        $this->view->affichagesuppresionPhotoDeProfileErreur();
    }

    public function affichagesuppresionPhotoDeProfileReussit()
    {
        $this->view->affichagesuppresionPhotoDeProfileReussit();
    }
}
