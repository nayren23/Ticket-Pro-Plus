<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
	die(affichage_erreur404());

require_once "vue_navbar.php";
require_once "modele_navbar.php";

class Cont_navbar
{
    private $action;
    private $vue;
    private $modele;

    public function __construct()
    {
        $this->vue = new Vue_navbar;
        $this->modele = new ModeleNavBar;
    }

    public function exec()
    {
        $image = $this->recuperationPhoto()["cheminImage"];
        if($this->recupererDerniereFicheUser() == null ){
            $idFiche = 0;
        }
        else{
            $idFiche = $this->recupererDerniereFicheUser()["idFiche"];
        }
        $this->affichageHabillage($image,$idFiche);
    }

    public function affichageHabillage($image,$idFiche)
    {
        $this->vue->navBarHabillage($image,$idFiche);
    }

    public function recuperationPhoto()
    {
        return $this->modele->recupererPhoto();
    }

    public function recupererDerniereFicheUser(){
       return $this->modele->recupererDerniereFicheUser();
    }
}
?>