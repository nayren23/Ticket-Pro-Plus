<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

$controller = new ClientCont();

$action = $_GET['action'] ?? 'manageClient';

switch ($action) {
    case 'manageClient':
        Authorization::requireRole([Role::ADMIN]);
        $controller->manageClient();
        break;

    case 'addClient':
        Authorization::requireRole([Role::ADMIN]);
        $controller->addClient();
        break;

    case 'showAddClientForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->showAddClientForm();
        break;

    case 'showEditClientForm':
        Authorization::requireRole([Role::ADMIN]);
        $controller->editClient();
        break;

    case 'deleteClient':
        Authorization::requireRole([Role::ADMIN]);
        $clientIdToDelete = $_POST['id'];
        $controller->deleteClient($clientIdToDelete);
        break;

    case 'updateClient':
        Authorization::requireRole([Role::ADMIN]);
        $controller->updateClient();
        break;

    case 'addProject':
        Authorization::requireRole([Role::ADMIN]);
        $controller->addProject();
        break;

    case 'viewClient':
        Authorization::requireRole([Role::ADMIN, Role::DEVELOPER, Role::REPORTER]);
        $controller->viewClient();
        break;

    default:
        http_response_code(404);
        include __DIR__ . '/../../../public/errors/404.html';
        break;
}
