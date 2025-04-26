<?php

require_once("./Common/CommonLib/Error404.php");
require_once "./Common/GenericClass/GenericLoginModel.php";

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class UserExist extends GenericLoginModel
{
    public function doUserExist()
    {

        try { //On cherche si l'id existe déjà
            if (isset($_SESSION["login"])) {

                $sql = 'Select * from utilisateur WHERE (identifiant=:identifiant)';
                $statement = $this->conn->prepare($sql);
                $statement->execute(array(':identifiant' => htmlspecialchars($_SESSION["login"])));
                $result = $statement->fetch();
                if (!$result) { //si l'id est correct alors on verifie le mdp
                    $this->deconnexionM();
                    header('Location: ./index.php?module=login&action=connexion&SuppresionCompte=true');
                }
            }
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}
