<?php

namespace TicketProPlus\App\Modules\User;

$controller = new UserCont();

$action = $_GET['action'] ?? 'showAddUserForm'; #TODO à changer

switch ($action) {
    case 'showAddUserForm':
        $controller->showAddUserForm();
        break;

    case 'addUser':
        $controller->addUser();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found module User";
        break;
}