<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "FooterCont.php";

class FooterComp
{
    private $controller;
    public function __construct()
    {
        $this->controller = new FooterCont();
        $this->controller->exec();
    }

    public function getController()
    {
        return $this->controller;
    }
}

?>