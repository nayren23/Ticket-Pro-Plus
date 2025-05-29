<?php

namespace TicketProPlus\App\Modules\Project;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new ProjectCont();

$action = $_GET['action'];

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

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}

?>