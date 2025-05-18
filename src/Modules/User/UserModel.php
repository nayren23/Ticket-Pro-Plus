<?php

namespace TicketProPlus\App\Modules\User;


use PDO, PDOException, TicketProPlus\App\Core;

class UserModel extends Core\GenericModel
{
    public function addUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $login = $this->sanitize($_POST['login']);
            $firstname = $this->sanitize($_POST['firstname']);
            $lastname = $this->sanitize($_POST['lastname']);
            $email = $this->sanitize($_POST['email']);
            $password1 = $_POST['firstpassword'];
            $password2 = $_POST['secondpassword'];
            $phone = isset($_POST['phone']) ? $this->sanitize($_POST['phone']) : null;
            $gender = isset($_POST['gender']) ? (int)$_POST['gender'] : 2;
            $description = isset($_POST['message']) ? $this->sanitize($_POST['message']) : null;
            $role_id = isset($_POST['role']) ? (int)$_POST['role'] : 1;

            if ($this->checkLogin($login)) {
                throw new \Exception('Invalid login.');
            }

            if ($this->checkEmail($email)) {
                throw new \Exception('Invalid email.');
            }

            if ($password1 !== $password2) {
                throw new \Exception('Passwords do not match.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email format.');
            }

            $hashedPassword = password_hash($password1, PASSWORD_DEFAULT);
            $now = date('Y-m-d H:i:s');

            // Upload profile picture (simplifié, sans vérif format/taille)
            $profilePicturePath = null;
            if (isset($_FILES['pfp']) && $_FILES['pfp']['error'] === 0) {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) mkdir($targetDir);
                $filename = basename($_FILES['pfp']['name']);
                $targetFile = $targetDir . uniqid() . '_' . $filename;
                if (move_uploaded_file($_FILES['pfp']['tmp_name'], $targetFile)) {
                    $profilePicturePath = $targetFile;
                }
            }

            $sql = "INSERT INTO tp_user (u_login, u_firstname, u_lastname, u_email, u_password, u_timestamp_creation, u_timestamp_modification, u_profile_picture, u_gender, u_phone_number, u_status, u_description, r_id) 
                VALUES (:login, :firstname, :lastname, :email, :password, :created, :modified, :pfp, :gender, :phone, 1, :description, :role_id)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':login' => $login,
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email,
                ':password' => $hashedPassword,
                ':created' => $now,
                ':modified' => $now,
                ':pfp' => $profilePicturePath,
                ':gender' => $gender,
                ':phone' => $phone,
                ':description' => $description,
                ':role_id' => $role_id
            ]);
        }
    }

    public function checkLogin($login)
    {
        $stmt = $this->conn->prepare("Select u_login from tp_user WHERE u_login =:u_login");
        $stmt->execute(['u_login' => htmlspecialchars($login)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkEmail($email)
    {
        $stmt = $this->conn->prepare("Select u_email from tp_user WHERE u_email =:u_email");
        $stmt->execute(['u_email' => htmlspecialchars($email)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUserManage()
    {
        $stmt = $this->conn->prepare("Select u_id, u_login, u_firstname, u_lastname, u_email, u_profile_picture, u_email_verified, u_status, r_name from tp_user u join tp_role r on u.r_id = r.r_id; ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser(int $userId): bool
    {
        $sql = "DELETE FROM tp_user WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->execute();
    }

    public function sanitize($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }
}
