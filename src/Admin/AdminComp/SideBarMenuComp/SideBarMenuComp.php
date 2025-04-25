<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

require_once "SideBarMenuCont.php";


class SideBarMenuComp
{
    private $Controller;
    public function __construct()
    {
        $this->Controller = new SideBarMenuCont();
        $this->Controller->exec();
    }

    public function getController()
    {
        return $this->Controller;
    }
}
