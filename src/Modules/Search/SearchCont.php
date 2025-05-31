<?php

namespace TicketProPlus\App\Modules\Search;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

class SearchCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new SearchModel();
        $this->view = new SearchView();
    }

    public function globalSearch()
    {
        $searchTerm = $_POST['query'] ?? '';

        if (!empty($searchTerm)) {
            $results = [];

            $clientResults = $this->model->searchClients($searchTerm);
            if (!empty($clientResults))
                $results['clients'] = $clientResults;

            $loginResults = $this->model->searchLogins($searchTerm);
            if (!empty($loginResults))
                $results['logins'] = $loginResults;

            $projectResults = $this->model->searchProjects($searchTerm);
            if (!empty($projectResults))
                $results['projets'] = $projectResults;

            $ticketResults = $this->model->searchTickets($searchTerm);
            if (!empty($ticketResults))
                $results['tickets'] = $ticketResults;

            $userResults = $this->model->searchUsers($searchTerm);
            if (!empty($userResults))
                $results['users'] = $userResults;

            $this->view->renderSearchResults($results, $searchTerm);
        }
    }
}
