<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core;

class AdminCont extends Core\GenericController
{
    public function __construct()
    {
        $this->model = new AdminModel();
        $this->view = new AdminView();
    }

    public function stats()
    {
        $this->view->search();
        $developerTickets = $this->model->getTicketCountsByDeveloper();
        $totalTicketStat = $this->model->getTotalTicketCounts();
        $averageResolutionTime = $this->model->getAverageResolutionTime();
        $periodCountsArray = [
            [
                'period' => 'today',
                'data' => $this->model->getTicketCountsByPeriod('today'),
                'displayText' => 'Today',
            ],
            [
                'period' => 'week',
                'data' => $this->model->getTicketCountsByPeriod('week'),
                'displayText' => 'This week',
            ],
            [
                'period' => 'month',
                'data' => $this->model->getTicketCountsByPeriod('month'),
                'displayText' => 'This month',
            ],
            [
                'period' => 'year',
                'data' => $this->model->getTicketCountsByPeriod('year'),
                'displayText' => 'This year',
            ],
        ];

        $this->view->renderStatisticsDashboard($developerTickets, $totalTicketStat, $averageResolutionTime, $periodCountsArray);
    }

    public function globalSearch()
    {
        $searchTerm = $_GET['query'] ?? ''; // Récupérer le terme de recherche depuis la requête GET

        if (!empty($searchTerm)) {
            $results = [];

            // Rechercher dans le module Client
            $clientResults = $this->model->searchClients($searchTerm);
            if (!empty($clientResults)) {
                $results['clients'] = $clientResults;
            }

            // Rechercher dans le module Login (si vous avez une fonction de recherche spécifique)
            $loginResults = $this->model->searchLogins($searchTerm);
            if (!empty($loginResults)) {
                $results['logins'] = $loginResults;
            }

            // Rechercher dans le module Projet
            $projectResults = $this->model->searchProjects($searchTerm);
            if (!empty($projectResults)) {
                $results['projets'] = $projectResults;
            }

            // Rechercher dans le module Ticket
            $ticketResults = $this->model->searchTickets($searchTerm);
            if (!empty($ticketResults)) {
                $results['tickets'] = $ticketResults;
            }

            // Rechercher dans le module User
            $userResults = $this->model->searchUsers($searchTerm);
            if (!empty($userResults)) {
                $results['users'] = $userResults;
            }

            // Passer les résultats à la vue
            $this->view->renderSearchResults($results, $searchTerm);
        } else {
            // Si aucun terme de recherche n'est fourni, afficher une page de recherche vide ou un message.
            $this->view->renderSearchForm();
        }
    }
}
