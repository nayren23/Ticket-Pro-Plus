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

    /**
     * Orchestre à la vue d'afficher la liste des clients
     *
     * @return void
     */
    public function manageClient()
    {
        $totalClients = $this->model->getTotalClients();
        $clientsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalClients / $clientsPerPage);
        $offset = ($currentPage - 1) * $clientsPerPage;

        $clients = $this->model->getClientsWithPagination($offset, $clientsPerPage);
        $this->view->manageClient($clients, $currentPage, $totalPages, $totalClients);
    }

    /**
     * Orchestre à la vu d'afficher le formulaire d'ajout de client.
     *
     * @return void
     */
    public function showAddClientForm()
    {
        $this->view->showClientForm();
    }

    /**
     * Ajoute un nouveau client.
     *
     * @throws \Exception si 'ClientModel::addClient()' échoue.
     *
     * @return void redirecte vers le formulaire d'ajout de client avec un toast de succès si le
     * client est créé, ou un toast d'erreur si une exception est levée.
     */ 
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

    /**
     * Orchestre au model de supprimer un client.
     *
     * @throws \Exception si 'ClientModel::deleteClient()' échoue.
     *
     * @return void renvoie un code HTTP 200 si le client est supprimé, ou un code 500 
     * avec un message d'erreur en JSON si une exception est levée.
     */
    public function deleteClient()
    {
        try {
            $clientId = $_POST['id'];
            $this->model->deleteClient($clientId);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }



}
