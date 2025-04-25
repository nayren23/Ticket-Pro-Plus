<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class GenericController
{

    protected $view;
    protected $model;
    protected $action;


    public function getViewController()
    {
        return $this->view;
    }

    public function getModelController()
    {
        return $this->model;
    }


    public function getActionController()
    {
        return $this->action;
    }
}
