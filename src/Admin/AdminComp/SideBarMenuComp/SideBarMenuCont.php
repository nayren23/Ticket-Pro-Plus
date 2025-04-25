<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

require_once "SideBarMenuView.php";
require_once "SideBarMenuCompModel.php";

class SideBarMenuCont extends GenericController
{

    public function __construct()
    {
        $this->view = new SideBarMenuView();
        $this->model = new SideBarMenuCompModel();
    }

    public function exec()
    {
        $this->affichageHabillage();
    }

    public function affichageHabillage()
    {
        $idUseur = $this->model->recuperationIdUser();
        $this->view->side_Bar_Menu($idUseur);
    }
}
