<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();
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
            if ($this->model->addClient()) {
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
     * Orchestre à la vue d'afficher le formulaire de modification d'un client.
     *
     * @return void affiche le formulaire de modification d'un client si l'ID du client est fourni,
     *               avec un toast de succès si le client est modifié, ou un toast d'erreur si
     *               une exception est levée.
     */
    public function editClient()
    {
        if (isset($_GET['id'])) {
            $clientId = $_GET['id'];

            $client = $this->model->getClientById($clientId);

            if ($client) {
                $this->view->showClientForm($client);
            } else {
                echo "Client not found.";
            }
        } else {
            echo "Client ID not provided.";
        }
    }

    /**
     * Orchestre à la vue d'afficher le formulaire d'ajout de projet pour un client.
     *
     * @return void affiche le formulaire d'ajout de projet pour le client dont l'ID est fourni,
     *               avec un toast de succès si le projet est créé, ou un toast d'erreur si
     *               une exception est levée.
     */
    public function addProject()
    {
        if (isset($_GET['clientId'])) {
            $clientId = $_GET['clientId'];

            $client = $this->model->getClientById($clientId);

            if ($client) {
                $this->view->showClientForm($client, $this->model->getAllProjectsNoClient());
            } else {
                echo "Client not found.";
            }
        } else {
            echo "Client ID not provided.";
        }
    }

    /**
     * Met à jour le client correspondant à l'ID donné avec les informations fournies.
     *
     * @return void redirige vers la page de gestion des clients avec un toast de succès si le
     * client est mis à jour, ou un toast d'erreur si une exception est levée.
     */
    public function updateClient()
    {
        $clientId = $_POST['id'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $projectId = !empty($_POST['projectId']) ? $_POST['projectId'] : null;

        $result = $this->model->updateClient($clientId, $firstname, $lastname, $email, $projectId);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Client updated successfully'
            ];
        }

        header('Location: index.php?module=client&action=manageClient');
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

    public function viewClient()
    {
        if (isset($_GET['id'])) {
            $clientId = $_GET['id'];

            $client = $this->model->getClientById($clientId);

            if ($client) {
                $this->view->viewClient($client);
            } else {
                echo "Client not found.";
            }
        } else {
            echo "Client ID not provided.";
        }
    }
}
