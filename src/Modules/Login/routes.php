<?php

namespace TicketProPlus\App\Modules\Login;

$controller = new LoginCont();

$action = $_GET['action'] ?? 'showLoginForm';

switch ($action) {
    case 'showLoginForm':
        $controller->showLoginForm();
        break;

    case 'authenticate':
        $controller->authenticate();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found";
        break;
}
