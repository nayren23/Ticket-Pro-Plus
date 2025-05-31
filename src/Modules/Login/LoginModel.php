<?php

namespace TicketProPlus\App\Modules\Login;


use PDO, PDOException, TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();
class LoginModel extends Core\GenericModel
{

    public function logout()
    {
        if (isset($_SESSION['user']['u_login'])) {
            unset($_SESSION['user']['r_id']);
            unset($_SESSION['user']['u_email']);
            unset($_SESSION['user']['u_id']);
            session_destroy();
            return true;
        } else {
            return false; //Vous devez d abord vous connecté pour faire cette action !!!
        }
    }

    public function authenticate()
    {

        try {
            $user = $this->getUserByLogin($_POST['login']);
            if ($user) {
                if ($this->verifyPassword($_POST['password'], $user['u_password'])) {
                    $_SESSION['user']['u_login'] = $user['u_login'];
                    $_SESSION['user']['r_id'] = $user['r_id'];
                    $_SESSION['user']['u_email'] = $user['u_email'];
                    $_SESSION['user']['u_id'] = $user['u_id'];
                    return true;
                }
            } else {
                return false; //Pas de compte
            }
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }

    public function getUserByLogin($login)
    {
        $stmt = $this->conn->prepare("Select * from tp_user WHERE u_login =:u_login");
        $stmt->execute(['u_login' => htmlspecialchars($login)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function verifyPassword($password, $hashedPassword)
    {
        return password_verify(htmlspecialchars($password), $hashedPassword);
    }
}
