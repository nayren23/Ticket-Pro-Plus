<?php

namespace TicketProPlus\App\Modules\User;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

$controller = new UserCont();

$action = $_GET['action'] ?? 'showAddUserForm'; #TODO à changer

switch ($action) {
    case 'showAddUserForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->showAddUserForm();
        break;

    case 'addUser':
        Authorization::requireRole([Role::ADMIN]);
        $controller->addUser();
        break;

    case 'manageUser':
        Authorization::requireRole([Role::ADMIN]);
        $controller->manageUser();
        break;

    case 'deleteUser':
        Authorization::requireRole([Role::ADMIN]);
        $userIdToDelete = $_POST['id'];
        $controller->deleteUser($userIdToDelete);
        break;

    case 'showEditUserForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->editUser();
        break;

    case 'updateUser':
        Authorization::requireRole([Role::ADMIN]);
        $controller->updateUser();
        break;
    case 'editPasswordForm':
        $controller->showEditPasswordForm();
        break;

    case 'updatePassword':
        $controller->updatePassword();
        break;

    default:
        http_response_code(404);
        echo "404 - Page not found module User";
        break;
}
