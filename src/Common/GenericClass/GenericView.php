<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class GenericView
{

    public function  __construct()
    {
        ob_start();
    }

    public function showTampon()
    {
        return ob_get_clean();
    }
}