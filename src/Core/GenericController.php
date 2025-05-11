<?php

namespace TicketProPlus\App\Core;

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
