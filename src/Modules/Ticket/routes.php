<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new TicketCont();

$action = $_GET['action'];

switch ($action) {
    case 'addTicket':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $controller->addTicket();
        break;
    
    case 'showAddTicketForm':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $controller->showAddTicketForm();
        break;

    case 'manageTicket':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $controller->manageTicket();
        break;

    case 'deleteTicket':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $ticketIdToDelete = $_POST['id'];
        $controller->deleteTicket($ticketIdToDelete);
        break;

    case 'showEditTicketForm':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $controller->editTicket();
        break;

    case 'updateTicket':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER]);
        $controller->updateTicket();
        break;

    case 'viewMyTickets':
        Authorization::requireRole([Role::DEVELOPER]);
        $controller->viewMyTickets();
        break;
    
    case 'showUpdateForm':
        Authorization::requireRole([Role::DEVELOPER]);
        $controller->showUpdateForm();
        break;

    case 'addUpdate':
        Authorization::requireRole([Role::DEVELOPER]);
        $controller->addUpdate();
        break;

    case 'viewUpdates':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER, Role::DEVELOPER]);
        $controller->viewUpdates();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}

?>