<?php

namespace TicketProPlus\App\Modules\Project;

use TicketProPlus\App\Core;


class ProjectCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new ProjectModel();
        $this->view = new ProjectView();
    }

    /**
     * Orchestre à la vue d'afficher la liste des projets
     *
     * @return void
     */
    public function manageProject($clientId = null)
    {
        $totalProjects = $this->model->getTotalProjects();
        $projectsPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalProjects / $projectsPerPage);
        $offset = ($currentPage - 1) * $projectsPerPage;

        $projects = $this->model->getProjectsWithPagination($offset, $projectsPerPage, $clientId);
        $this->view->manageProject($projects, $currentPage, $totalPages, $totalProjects);
    }

    /**
     * Ajoute un nouveau projet.
     *
     * @throws \Exception si 'ProjectModel::addProject()' échoue.
     *
     * @return void redirige vers le formulaire d'ajout de projet avec un toast de succès si le
     * projet est créé, ou un toast d'erreur si une exception est levée.
     */
    public function addProject()
    {
        try {
            if($this->model->addProject()){
                $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Project successfully created!'
                ];
            };
            
        } catch (\Exception $e) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => $e->getMessage()
            ];
        }
        header('Location: ?module=project&action=showAddProjectForm');
    }

    /**
     * Orchestre à la vue d'afficher le formulaire d'ajout d'un projet.
     *
     * @return void
     */
     public function showAddProjectForm()
    {
        $clients = $this->model->getAllClients();
        $this->view->showProjectForm(null, $clients);
    }


}
