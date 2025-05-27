<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new TicketCont();

$action = $_GET['action'];

switch ($action) {
    case 'showTicket':
        //Authorization::requireRole([Role::ADMIN, Role::DEVELOPER, Role::REPORTER]);
        $controller->showTicketPage();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}

?>