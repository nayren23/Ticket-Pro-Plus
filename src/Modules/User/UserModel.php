<?php

namespace TicketProPlus\App\Modules\User;

require __DIR__ . '/../../../vendor/autoload.php'; // Chemin relatif vers l'autoloader de Composer

use PDO, PDOException, TicketProPlus\App\Core;
use ZxcvbnPhp\Zxcvbn;

class UserModel extends Core\GenericModel
{
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $login = $this->sanitize($_POST['login']);
            $firstname = $this->sanitize($_POST['firstname']);
            $lastname = $this->sanitize($_POST['lastname']);
            $email = $this->sanitize($_POST['email']);
            $phone = isset($_POST['phone']) ? $this->sanitize($_POST['phone']) : null;
            $gender = isset($_POST['gender']) ? (int)$_POST['gender'] : 2;
            $description = isset($_POST['description']) ? $this->sanitize($_POST['description']) : null;
            $role_id = isset($_POST['role']) ? (int)$_POST['role'] : 1;

            if ($this->checkLogin($login)) {
                throw new \Exception('Invalid login.');
            }

            if ($this->checkEmail($email)) {
                throw new \Exception('Invalid email.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email format.');
            }

            $now = date('Y-m-d H:i:s');

            $sql = "INSERT INTO tp_user (u_login, u_firstname, u_lastname, u_email, u_timestamp_creation, u_timestamp_modification, u_gender, u_phone_number, u_status, u_description, r_id) 
                VALUES (:login, :firstname, :lastname, :email, :created, :modified, :gender, :phone, 1, :description, :role_id)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':login' => $login,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':created' => $now,
                ':modified' => $now,
                ':gender' => $gender,
                ':phone' => $phone,
                ':description' => $description,
                ':role_id' => $role_id
            ]);

            $userId = $this->conn->lastInsertId();
            if ((!empty($_FILES['file_input']['name']))) {
                $this->uploadProfilePicture($userId);
            }
        }
    }

    public function checkLogin($login)
    {
        $sql = "SELECT u_login from tp_user WHERE u_login =:u_login";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['u_login' => htmlspecialchars($login)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmail($email)
    {
        $sql = "SELECT u_email from tp_user WHERE u_email =:u_email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['u_email' => htmlspecialchars($email)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUserManage()
    {
        $sql = "SELECT u_id, u_login, u_firstname, u_lastname, u_email, u_profile_picture, u_email_verified, u_status, r_name from tp_user u join tp_role r on u.r_id = r.r_id; ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser(int $userId): bool
    {
        $currentUserId = $_SESSION['user']['u_id'] ?? null;
        echo "userId : " . $userId . " " . "currentUserId: " . $currentUserId;
        if ($userId == $currentUserId) {
            throw new \Exception('You cannot delete your own account!');
        }
        $sql = "DELETE FROM tp_user WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['user_id' => $userId]);
    }

    public function getUserById(int $userId): ?array
    {
        $sql = "SELECT u_id, u_login, u_firstname, u_lastname, u_email, u_phone_number, u_gender, u_description, r_id
                FROM tp_user
                WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    private function uploadProfilePicture(int $userId)
    {
        $uploader = new Core\FileUploader('assets/images/uploads/profile_pictures');

        $sql = "SELECT u_profile_picture
                FROM tp_user
                WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && $result['u_profile_picture']) {
            $oldPicturePath = $result['u_profile_picture'];
            $uploader->deleteFile($oldPicturePath);
        }

        $profilePicturePath = $uploader->upload($_FILES['file_input'], $userId ?? uniqid('user_'));
        $sql = "UPDATE tp_user SET u_profile_picture = :picture WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ':user_id' => $userId,
            ':picture' => $profilePicturePath
        ]);
    }

    public function isEmailUniqueForUpdate(int $userId, string $email): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM tp_user WHERE u_email = :email AND u_id != :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] === 0;
    }

    public function updateUser(int $userId, string $login, string $firstname, string $lastname, string $email, ?string $phone, ?string $description, int $roleId, int $gender): bool
    {
        if (!$this->isEmailUniqueForUpdate($userId, $email)) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'This email address is already in use by another user.'
            ];
            return false;
        }

        if ((!empty($_FILES['file_input']['name']))) {
            $this->uploadProfilePicture($userId);
        }

        $now = date('Y-m-d H:i:s');
        $sql = "UPDATE tp_user
                SET u_login = :login,
                    u_firstname = :firstname,
                    u_lastname = :lastname,
                    u_email = :email,
                    u_phone_number = :phone,
                    u_gender = :gender,
                    u_description = :description,
                    r_id = :role_id,
                    u_timestamp_modification = :modified
                WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':user_id' => $userId,
            ':login' => $login,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':phone' => $phone,
            ':gender' => $gender,
            ':description' => $description,
            ':role_id' => $roleId,
            ':modified' => $now,
        ]);

        if (!$result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Error updating user information.'
            ];
            return false;
        }
        return true;
    }

    public function getTotalUsers(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_user";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function getUsersWithPagination(int $offset, int $limit): array
    {
        $sql = "SELECT u.*, r.r_name
            FROM tp_user u
            LEFT JOIN tp_role r ON u.r_id = r.r_id
            LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sanitize($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    public function updatePassword(int $userId)
    {
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation côté serveur (important !)
        if (empty($password) || empty($confirmPassword)) {
            $_SESSION['toast'] = ['type' => Core\ToastType::ERROR->value, 'message' => 'Please complete all password fields.'];
            return;
        }

        if ($password !== $confirmPassword) {
            $_SESSION['toast'] = ['type' => Core\ToastType::ERROR->value, 'message' => 'The passwords do not match.'];
            return;
        }

        // Validation de la force du mot de passe côté serveur
        $strengthMeter = new Zxcvbn();
        $weak = $strengthMeter->passwordStrength($password);
        if ($weak["score"] < 3) {
            $_SESSION['toast'] = ['type' => Core\ToastType::WARNING->value, 'message' => 'The password is considered weak. Please choose a stronger one.'];
            return false;
        }

        // Hashe mot de passe avant enregistrement
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE tp_user SET u_password = :u_password WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':user_id' => $userId,
            ':u_password' => $hashedPassword
        ]);
        return $result;
    }
}
