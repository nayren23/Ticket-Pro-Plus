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
        $this->view->showUserForm();
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

    public function editUser()
    {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            $user = $this->model->getUserById($userId); // Récupérez les informations de l'utilisateur

            if ($user) {
                $this->view->showUserForm($user); // Passez les données à la vue
            } else {
                // Gérez le cas où l'utilisateur n'existe pas (redirigez, affichez un message, etc.)
                echo "User not found.";
            }
        } else {
            // Gérez le cas où l'ID n'est pas fourni
            echo "User ID not provided.";
        }
    }

    public function updateUser()
    {
        // Récupérez les données du formulaire d'édition (y compris l'ID) via $_POST
        $userId = $_POST['id'];
        $login = $_POST['login'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $description = $_POST['description'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];

        // Validez les données si nécessaire

        $result = $this->model->updateUser($userId, $login, $firstname, $lastname, $email, $phone, $description, $role, $gender);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'User updated successfully'
            ];
            // Redirigez avec un message de succès
        } else {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => "Failed to update user"
            ];
            // Redirigez avec un message d'erreur
        }

        header('Location: index.php?module=user&action=manageUser');
    }
}
