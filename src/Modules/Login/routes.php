<?php

namespace TicketProPlus\App\Modules\Login;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new LoginCont();

$action = $_GET['action'] ?? 'showLoginForm';

switch ($action) {
    case 'showLoginForm':
        if (!isset($_SESSION['user']['r_id']))
            $isLogged = false;
        else
            $isLogged = true;
        Authorization::requireRole([Role::VISITOR], null, $isLogged);
        $controller->showLoginForm();
        break;

    case 'authenticate':
        $controller->authenticate();
        break;

    case 'logout':
        Authorization::requireRole([Role::ADMIN, Role::DEVELOPER, Role::REPORTER]);
        $controller->logout();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
