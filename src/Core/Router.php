<?php

namespace TicketProPlus\App\Core;

use TicketProPlus\App\Core;

class Router
{
    private $controller;
    private $action;
    private $view;

    public function __construct()
    {
        $this->controller = isset($_GET['module']) ? $_GET['module'] : 'login'; // module par défaut
        $this->action = isset($_GET['action']) ? $_GET['action'] : 'index'; // action par défaut
        $this->view = new GenericView();
        $this->loadModule();
    }

    public function loadModule()
    {
        $this->displayCurrentToast();
        if (isset($_SESSION['toast'])) {
            $toast = $_SESSION['toast'];
            $this->view->displayToast($toast['type'], $toast['message']);
            unset($_SESSION['toast']); // Supprimer le message de la session après l'affichage
        }

        $modulePath = __DIR__ . '/../Modules/' . ucfirst($this->controller) . '/routes.php';

        // Vérifie si le module existe, sinon erreur
        if (file_exists($modulePath)) {
            require_once $modulePath;
        } else {
            echo "Module introuvable."; #TODO, changer par page 404
        }
    }

    public function displayCurrentToast()
    {
        if (isset($_SESSION['toast'])) {
            $toast = $_SESSION['toast'];
            $this->view->displayToast($toast['type'], $toast['message']);
            unset($_SESSION['toast']); // Supprimer le message de la session après l'affichage
        }
    }
}
