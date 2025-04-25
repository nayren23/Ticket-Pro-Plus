<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "NavbarCont.php";


class NavbarComp
{
    private $Controller;
    public function __construct()
    {
        $this->Controller = new NavbarCont();
        $this->Controller->exec();
    }

    public function getController()
    {
        return $this->Controller;
    }
}