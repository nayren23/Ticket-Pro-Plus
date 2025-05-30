<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new AdminCont();

$action = $_GET['action'] ?? 'stats'; #TODO à changer

switch ($action) {
    case 'stats':
        Authorization::requireRole([Role::ADMIN]);
        $controller->stats();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
