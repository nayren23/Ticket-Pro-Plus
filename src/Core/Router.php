<?php

namespace TicketProPlus\App\Core;

class Router
{
    private $controller;
    private $action;

    public function __construct()
    {
        $this->controller = isset($_GET['module']) ? $_GET['module'] : 'login'; // module par défaut
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'index'; // action par défaut

        $this->loadModule();
    }

    public function loadModule()
    {
        $modulePath = __DIR__ . '/../Modules/' . ucfirst($this->controller) . '/routes.php';

        // Vérifie si le module existe, sinon erreur
        if (file_exists($modulePath)) {
            require_once $modulePath;
        } else {
            echo "Module introuvable.";
        }
    }
}
