<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

require_once "UserLoginManagerCont.php";


class UserManagerMod
{
    private $cont;
    public function __construct()
    {
        $this->cont = new UserLoginManagerCont();
        $this->cont->exec();
    }

    public function getController()
    {
        return $this->cont;
    }
}
