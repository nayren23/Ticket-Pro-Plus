<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "NavbarView.php";
require_once "NavbarModel.php";

class NavbarCont
{
    private $action;
    private $view;
    private $model;

    public function __construct()
    {
        $this->view = new NavbarView();
        $this->model = new NavbarModel();
    }

    public function exec()
    {
        $image = $this->model->getPicture();
        $this->view->navBar($image);
    }
}