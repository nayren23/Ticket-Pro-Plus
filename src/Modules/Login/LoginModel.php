<?php

namespace TicketProPlus\App\Modules\Login;


use PDO, PDOException, TicketProPlus\App\Core;

class LoginModel extends Core\GenericModel
{

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
                    var_dump($_SESSION['user']);
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
