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

    /**
     * Orchestre au model de supprimer un projet.
     *
     * @throws \Exception si 'ProjectModel::deleteProject()' échoue.
     *
     * @return void renvoie un code HTTP 200 si le projet est supprimé, ou un code 500 
     * avec un message d'erreur en JSON si une exception est levée.
     */
    public function deleteProject()
    {
        try {
            $projectId = $_POST['id'];
            $this->model->deleteProject($projectId);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Orchestre à la vue d'afficher le formulaire de modification d'un projet.
     *
     * @return void affiche le formulaire de modification d'un projet si l'ID du projet est fourni,
     *               avec un toast de succès si le projet est modifié, ou un toast d'erreur si
     *               une exception est levée.
     */
    public function editProject()
    {
        if (isset($_GET['id'])) {
            $projectId = $_GET['id'];

            $project = $this->model->getProjectById($projectId);
            
            if ($project) {
                $this->view->showProjectForm($project, null); // Pass the project data to the view($client);
            } else {
                echo "Project not found.";
            }
        } else {
            echo "Project ID not provided.";
        }
    }

    /**
     * Met à jour un projet.
     *
     * @return void redirige vers le formulaire de gestion des projets avec un toast de succès si le
     * projet est mis à jour, ou un toast d'erreur si une exception est levée.
     */
    public function updateProject()
    {
        $projectId = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $dueDateRaw = $_POST['due_date'];
        $dateTime = \DateTime::createFromFormat('m/d/Y', $dueDateRaw);
        $dueDate = $dateTime->format('Y-m-d') .' 00:00:00';
        $closed = $_POST['closed'] ?? 0;
        $clientId = empty($_POST['clientId']) ? null : $_POST['clientId'];
        
        $result = $this->model->updateProject($projectId, $name, $description, $dueDate, $closed, $clientId);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Project updated successfully'
            ];
        }

        header('Location: index.php?module=project&action=manageProject');
    }

/**
 * Orchestre à la vue d'afficher le formulaire de projet avec la liste des clients.
 *
 * @return void affiche le formulaire de projet avec la liste des clients si l'ID du projet est fourni,
 *               avec un message d'erreur si le projet n'est pas trouvé ou si l'ID n'est pas fourni.
 */

    public function addClient()
    {
         if (isset($_GET['projectId'])) {
            $projectId = $_GET['projectId'];

            $project = $this->model->getProjectById($projectId);
            $clients = $this->model->getAllClients();
            
            if ($project) {
                $this->view->showProjectForm($project, $clients);
            } else {
                echo "Project not found.";
            }
        } else {
            echo "Project ID not provided.";
        }
    }

    /**
     * Orchestre à la vue d'afficher les détails d'un projet.
     *
     * @return void affiche les détails du projet correspondant à l'ID donné si l'ID est fourni,
     *               avec un message d'erreur si le projet n'est pas trouvé ou si l'ID n'est pas fourni.
     */ 
    public function showProjectDetails()
    {
        if (isset($_GET['projectId'])) {
            $projectId = $_GET['projectId'];
            $project = $this->model->getProjectById($projectId);
            $this->view->showProjectDetails($project);
        } else {
            echo "Project ID not provided.";
        }
    }


}
