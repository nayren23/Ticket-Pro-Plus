<?php

require_once "StatisticalInfoCont.php";
require_once("./Common/CommonLib/Error404.php");

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

class StatisticalInfoConp
{
    private $Controller;
    public function __construct()
    {
        $this->Controller = new StatisticalInfoCont();
        $this->Controller->exec();
    }

    public function getController()
    {
        return $this->Controller;
    }
}