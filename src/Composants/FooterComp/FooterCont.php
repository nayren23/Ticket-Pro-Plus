<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
	die(showError404());

require_once "FooterView.php";

class FooterCont
{
    private $view;

    public function __construct()
    {
        $this->view = new FooterView();
    }

    public function exec()
    {
        $this->footer();
    }

    public function footer()
    {
        $this->view->footer();
    }
}