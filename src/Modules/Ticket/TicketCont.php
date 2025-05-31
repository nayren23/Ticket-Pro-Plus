<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();


class TicketCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new TicketModel();
        $this->view = new TicketView();
    }

    /**
     * Ajoute un nouveau ticket.
     *
     * @throws \Exception si 'TicketModel::addTicket()' échoue.
     *
     * @return void redirige vers le formulaire d'ajout de ticket avec un toast de succès si le
     * ticket est créé, ou un toast d'erreur si une exception est levée.
     */
    public function addTicket()
    {
        try {
            if ($this->model->addTicket()) {
                $_SESSION['toast'] = [
                    'type' => Core\ToastType::SUCCESS->value,
                    'message' => 'Ticket successfully created!'
                ];
            };
        } catch (\Exception $e) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => $e->getMessage()
            ];
        }
        header('Location: ?module=ticket&action=showAddTicketForm');
    }

    /**
     * Orchestre à la vue d'afficher le formulaire d'ajout d'un ticket.
     *
     * @return void
     */
    public function showAddTicketForm()
    {
        $clients = $this->model->getAllClients();
        $projects = $this->model->getAllProjects();
        $developers = $this->model->getAllDevelopers();
        $this->view->showTicketForm(null, $clients, $projects, $developers);
    }

    /**
     * Orchestre à la vue d'afficher la liste des tickets.
     *
     * @return void
     */
    public function manageTicket()
    {
        $totalTickets = $this->model->getTotalTickets();
        $ticketsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalTickets / $ticketsPerPage);
        $offset = ($currentPage - 1) * $ticketsPerPage;
        $order = $_GET['order'];
        $tickets = $this->model->getTicketsWithPagination($offset, $ticketsPerPage, $order);
        $this->view->manageTicket($tickets, $currentPage, $totalPages, $totalTickets, $order);
    }

    /**
     * Orchestre au model de supprimer un ticket.
     *
     * @throws \Exception si 'TicketModel::deleteTicket()' échoue.
     *
     * @return void renvoie un code HTTP 200 si le ticket est supprimé, ou un code 500 
     * avec un message d'erreur en JSON si une exception est levée.
     */
    public function deleteTicket()
    {
        try {
            $ticketId = $_POST['id'];
            $this->model->deleteTicket($ticketId);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Orchestre à la vue d'afficher le formulaire de modification d'un ticket.
     * 
     * @return void affiche le formulaire de modification d'un ticket si l'ID du ticket est fourni,
     *               avec un toast de succès si le ticket est modifié, ou un toast d'erreur si
     *               une exception est levée.
     */
    public function editTicket()
    {
        if (isset($_GET['id'])) {
            $ticketId = $_GET['id'];

            $ticket = $this->model->getTicketById($ticketId);
            $clients = $this->model->getAllClients();
            $projects = $this->model->getAllProjects();
            $developers = $this->model->getAllDevelopers();

            if ($ticket) {
                $this->view->showTicketForm($ticket, $clients, $projects, $developers); // Pass the project data to the view($client);
            } else {
                echo "Ticket not found.";
            }
        } else {
            echo "Ticket ID not provided.";
        }
    }

    /**
     * Modifie un ticket existant.
     * 
     * @throws \Exception si $this->model->updateTicket()' échoue.
     * 
     * @return void redirige vers la page de gestion des tickets en cas de succès, ou affiche un toast
     *               d'erreur en cas d'échec.
     */
    public function updateTicket()
    {
        $ticketId = $_POST['id'];
        $description = $_POST['description'];
        $dueDateRaw = $_POST['due_date'];
        $dateTime = \DateTime::createFromFormat('m/d/Y', $dueDateRaw);
        $dueDate = $dateTime->format('Y-m-d') . ' 00:00:00';
        $clientId = empty($_POST['clientId']) ? null : $_POST['clientId'];
        $projectId = $_POST['projectId'];
        $statusId = $_POST['statusId'];
        $timeClosed = ($statusId == 4) ? date('Y-m-d H:i:s') : null;
        $timeModified = date('Y-m-d H:i:s');
        $priorityId = $_POST['priorityId'];
        $developerId = empty($_POST['developerId']) ? null : $_POST['developerId'];
        $oldStatusValue = $_POST['oldStatusValue'];


        $result = $this->model->updateTicket($ticketId, $description, $dueDate, $clientId, $projectId, $statusId, $timeClosed, $timeModified, $priorityId, $developerId, $oldStatusValue);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Ticket updated successfully'
            ];
        }

        header('Location: index.php?module=ticket&action=manageTicket');
    }

    /**
     * Affiche la liste des tickets affectés à l'utilisateur courant.
     *
     * @return void affiche la liste des tickets affectés à l'utilisateur courant, en
     *               paginant les résultats.
     */
    public function viewMyTickets()
    {
        $userId = $_SESSION['user']['u_id'];

        $totalTickets = $this->model->getTotalTicketsByUserId($userId);
        $ticketsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalTickets / $ticketsPerPage);
        $offset = ($currentPage - 1) * $ticketsPerPage;
        $tickets = $this->model->getTicketsByUserId($userId, $offset, $ticketsPerPage);

        $this->view->viewMyTickets($tickets, $currentPage, $totalPages, $totalTickets);
    }

    /**
     * Affiche le formulaire de mise à jour d'un ticket.
     *
     * @return void affiche le formulaire de mise à jour d'un ticket, en
     *               sélectionnant les champs de formulaire en fonction de l'utilisateur
     *               courant.
     */
    public function showUpdateForm()
    {
        $ticketId = $_GET['id'];
        $userId = $_SESSION['user']['u_id'];
        $this->view->showUpdateForm($userId, $ticketId);
    }

    /**
     * Ajoute une mise à jour à un ticket.
     *
     * @return void redirige vers la page affichant les tickets de l'utilisateur
     *               après l'ajout de la mise à jour.
     */

    public function addUpdate()
    {
        $ticketId = $_POST['ticketId'];
        $userId = $_POST['userId'];
        $description = $_POST['description'];
        $result = $this->model->addUpdate($ticketId, $userId, $description);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Update added successfully'
            ];
        }

        header('Location: index.php?module=ticket&action=viewMyTickets');
    }

    /**
     * Affiche les mises à jour d'un ticket spécifique avec pagination.
     *
     * @return void affiche les mises à jour du ticket, en paginant les résultats par 10 mises à jour par page.
     */

    public function viewUpdates()
    {
        $ticketId = $_GET['ticketId'];
        $totalUpdates = $this->model->getTotalUpdates($ticketId);
        $updatesPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalUpdates / $updatesPerPage);
        $offset = ($currentPage - 1) * $updatesPerPage;

        $updates = $this->model->getUpdatesWithPagination($offset, $updatesPerPage, $ticketId);
        $this->view->viewUpdates($updates, $currentPage, $totalPages, $totalUpdates);
    }

    public function viewTicket()
    {
        if (isset($_GET['id'])) {
            $ticketId = $_GET['id'];

            $ticket = $this->model->getTicketById($ticketId);

            if ($ticket) {
                $this->view->viewTicket($ticket);
            } else {
                echo "Ticket not found.";
            }
        } else {
            echo "Ticket ID not provided.";
        }
    }
}
