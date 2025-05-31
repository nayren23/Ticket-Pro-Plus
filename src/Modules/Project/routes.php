<?php

namespace TicketProPlus\App\Modules\Project;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

$controller = new ProjectCont();

$action = $_GET['action'] ?? 'manageProject';

switch ($action) {
    case 'manageProject':
        Authorization::requireRole([Role::ADMIN]);
        isset($_GET['clientId']) ? $clientId = $_GET['clientId'] : $clientId = null;
        $controller->manageProject($clientId);
        break;

    case 'addProject':
        Authorization::requireRole([Role::ADMIN]);
        $controller->addProject();
        break;

    case 'showAddProjectForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->showAddProjectForm();
        break;

    case 'deleteProject':
        Authorization::requireRole([Role::ADMIN]);
        $projectIdToDelete = $_POST['id'];
        $controller->deleteProject($projectIdToDelete);
        break;

    case 'showEditProjectForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->editProject();
        break;

    case 'updateProject':
        Authorization::requireRole([Role::ADMIN]);
        $controller->updateProject();
        break;

    case 'addClient':
        Authorization::requireRole([Role::ADMIN]);
        $controller->addClient();
        break;

    case 'showProjectDetails':
        Authorization::requireRole([Role::ADMIN]);
        $controller->showProjectDetails();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
