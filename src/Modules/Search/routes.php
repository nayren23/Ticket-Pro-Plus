<?php

namespace TicketProPlus\App\Modules\Search;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

$controller = new SearchCont();

$action = $_GET['action'] ?? 'search';

switch ($action) {
    case 'search':
        Authorization::requireRole([Role::ADMIN, Role::REPORTER, Role::DEVELOPER]);
        $controller->globalSearch();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
