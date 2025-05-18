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
                'message' => 'User successfully created!'
            ];
        } catch (\Exception $e) {
            // En cas d'erreur, stocker le message en session et rediriger
            $_SESSION['toast'] = [
                'type' => Core\ToastType::error->value,
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
        $userId = $_POST['id'];
        if ($this->model->deleteUser($userId)) {
            // La suppression a réussi
            echo json_encode(['success' => true]);
        } else {
            // La suppression a échoué (l'utilisateur n'existe pas, erreur de base de données, etc.)
            echo json_encode(['success' => false, 'error' => 'Failed to delete user.']);
        }
    }
}
