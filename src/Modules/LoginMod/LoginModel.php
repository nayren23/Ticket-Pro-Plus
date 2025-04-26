<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

require_once("./Common/CommonLib/TokenManager.php");
require_once("./Common/GenericClass/GenericLoginModel.php");

class LoginModel extends GenericLoginModel
{

    public function insereInscription()
    {
        if (!isset($_POST['token']) || !checkToken())
            return 1;

        elseif (strcmp($_POST['u_password'], $_POST['secondPassword']) != 0) {
            return 2;
        }

        try {
            //ici on teste si l'adresse mail est deja utilise
            $sql = 'Select * from tp_user WHERE u_email=:mail or u_login=:login';
            $statement = $this->conn->prepare($sql);
            $statement->execute(array(':mail' => htmlspecialchars($_POST['mail']), ':login' => htmlspecialchars($_POST['login'])));
            $result = $statement->fetch();
            if ($result) {
                return 3; //adresseMail deja utilisé';
            } else {
                // ici on insere les donnee dans la BDD
                $sql = 'INSERT INTO tp_user (u_email,u_login,u_password) VALUES(:mail,:login, :u_password)';
                $statement = $this->conn->prepare($sql);
                $statement->execute(array(':mail' => htmlspecialchars($_POST['mail']), ':login' => htmlspecialchars($_POST['login']), 'u_password' => password_hash(htmlspecialchars($_POST['u_password']), PASSWORD_DEFAULT))); //vois si pour le mdp on fait htmlspecialchars
                echo "insertion";
                return 4;
            }
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}