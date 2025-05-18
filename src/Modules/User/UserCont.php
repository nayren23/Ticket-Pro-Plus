<?php

namespace TicketProPlus\App\Modules\User;

use TicketProPlus\App\Core;



class UserCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new UserView;
    }

    public function showAddUserForm()
    {
        $this->view->addUserForm();
    }

    public function addUser()
    {
        try {
            $this->model->addUser();
            // En cas de succès, stocker un message en session et rediriger
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'User successfully created !'
            ];
        } catch (\Exception $e) {
            // En cas d'erreur, stocker le message en session et rediriger
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => $e->getMessage()
            ];
        }
        header('Location: ?module=user&action=showAddUserForm'); // Redirigez vers le formulaire ou une page d'erreur
    }

    public function manageUser()
    {
        $users = $this->model->getAllUserManage();
        $this->view->manageUser($users);
    }

    public function deleteUser()
    {
        try {
            $userId = $_POST['id'];
            $this->model->deleteUser($userId);
            http_response_code(200); // OK
        } catch (\Exception $e) {
            http_response_code(500); // Internal Server Error
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
