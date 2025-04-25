<?php

require_once("./Common/CommonLib/Error404.php");
require_once "NavbarLoginView.php";

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class NavbarLoginCont
{
    private $view;

    public function __construct()
    {
        $this->view = new NavbarLoginView;
    }

    public function exec()
    {
        $this->navBar();
    }

    public function navBar()
    {
        $this->view->navBar();
    }
}