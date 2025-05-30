<?php

namespace TicketProPlus\App\Modules\User;

use TicketProPlus\App\Core;

class UserCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new UserModel();
        $this->view = new UserView();
    }

    public function showAddUserForm()
    {
        $this->view->showUserForm();
    }

    public function addUser()
    {
        try {
            if($this->model->addUser()){
                $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'User successfully created !'
                ];
            }
        } catch (\Exception $e) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => $e->getMessage()
            ];
        }
        header('Location: ?module=user&action=showAddUserForm');
    }


    public function manageUser()
    {
        $totalUsers = $this->model->getTotalUsers();
        $usersPerPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $totalPages = ceil($totalUsers / $usersPerPage);
        $offset = ($currentPage - 1) * $usersPerPage;

        $users = $this->model->getUsersWithPagination($offset, $usersPerPage);
        $this->view->manageUser($users, $currentPage, $totalPages, $totalUsers);
    }

    public function deleteUser()
    {
        try {
            $userId = $_POST['id'];
            $this->model->deleteUser($userId);
            http_response_code(200);
        } catch (\Exception $e) {
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function editUser()
    {
        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            $user = $this->model->getUserById($userId);

            if ($user) {
                $this->view->showUserForm($user);
            } else {
                echo "User not found.";
            }
        } else {
            echo "User ID not provided.";
        }
    }

    public function updateUser()
    {
        $userId = $_POST['id'];
        $login = $_POST['login'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $description = $_POST['description'];
        $role = $_POST['role'];
        $gender = $_POST['gender'];

        $result = $this->model->updateUser($userId, $login, $firstname, $lastname, $email, $phone, $description, $role, $gender);

        if ($result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'User updated successfully'
            ];
        }

        header('Location: index.php?module=user&action=manageUser');
    }

    public function showEditPasswordForm()
    {

        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            if ($userId) {
                $this->view->updatePasswordForm($userId);
            } else {
                echo "User not found.";
            }
        } else {
            echo "User ID not provided.";
        }
    }

    public function updatePassword()
    {

        if (isset($_GET['id'])) {
            $userId = $_GET['id'];

            if ($userId) {
                if ($this->model->updatePassword($userId)) {
                    $_SESSION['toast'] = ['type' => Core\ToastType::SUCCESS->value, 'message' => 'Password successfully updated.'];
                }
            } else {
                echo "User not found.";
            }
        } else {
            echo "User ID not provided.";
        }
        header('Location: index.php?module=user&action=manageUser');
    }
}
