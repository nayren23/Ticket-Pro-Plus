<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core;


class ClientCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new ClientModel();
        $this->view = new ClientView();
    }

    public function manageClient()
    {
        $this->view->manageClient();
    }

    public function showAddClientForm()
    {
        $this->view->showClientForm();
    }

    public function addClient()
    {
        try {
            if($this->model->addClient()){
                $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Client successfully created!'
                ];
            };
            
        } catch (\Exception $e) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => $e->getMessage()
            ];
        }
        header('Location: ?module=client&action=showAddClientForm');
    }



}
