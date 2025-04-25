<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once "LoginCont.php";


class LoginMod
{
    private $cont;
    public function __construct()
    {
        $this->cont = new LoginCont();
        $this->cont->exec();
    }

    public function getController()
    {
        return $this->cont;
    }
}
