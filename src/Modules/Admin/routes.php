<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

$controller = new AdminCont();

$action = $_GET['action'] ?? 'stats'; #TODO à changer

switch ($action) {
    case 'stats':
        Authorization::requireRole([Role::ADMIN, Role::DEVELOPER, Role::REPORTER]);
        $controller->stats();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
