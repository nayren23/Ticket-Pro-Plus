<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class GenericLoginModel extends Database
{
    public function verificationConnexion($idGroupe)
    {
        //Verification de si on est deja connecte
        echo 'tets';
        if (!isset($_POST['token']) || !checkToken())
            return 1; // faire une pop up et verification dans le  controlleur
        else {
            echo 'etienne';
            try { //On cherche si l'id existe déjà
                $sql = 'Select * from tp_user WHERE (u_login=:identifiant)';
                $statement = $this->conn->prepare($sql);
                $statement->execute(array(':identifiant' => htmlspecialchars($_POST['login'])));
                $result = $statement->fetch();
                if ($result) { //si l'id est correct alors on verifie le mdp
                    if (password_verify(htmlspecialchars($_POST['password']), $result['u_password']) && $result['r_id'] == $idGroupe) {
                        $_SESSION["login"] = $result['identifiant'];
                        echo "ici";
                        return true; // connexion reussie au site
                    }
                } else {
                    return false; //pas de compte
                }
            } catch (PDOException $e) {
                echo $e->getMessage() . $e->getCode();
            }
        }
    }

    public function deconnexionM()
    {
        if (isset($_SESSION["login"])) {
            unset($_SESSION["login"]);
            session_destroy();
            return true;
        } else {
            return false; //Vous devez d abord vous connecté pour faire cette action !!!
        }
    }

    // fonction génerique pour récupérer toutes les infos d'un user dans un seul tableau 
    public function getUser()
    {
        try {
            $sql = 'Select * from utilisateur WHERE identifiant=:identifiant';
            $statement = $this->conn->prepare($sql);
            $statement->execute(array(':identifiant' => $_SESSION["login"]));
            $resultat = $statement->fetch();
            return $resultat;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}