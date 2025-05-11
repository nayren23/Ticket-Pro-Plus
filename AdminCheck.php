<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class AdminCheck extends Database
{

    public function isAdmin()
    {
        if (isset($_SESSION["login"])) {
            try {
                $sql = 'Select * from utilisateur WHERE (identifiant=:identifiant)';
                $statement = $this->getConnection()->prepare($sql);
                $statement->execute(array(':identifiant' => $_SESSION["login"]));
                $result = $statement->fetch();
                if ($result) {
                    if ($result['idGroupes'] == 2) {
                        return true;
                    }
                } else {
                    return false;
                }
            } catch (PDOException $e) {
                echo $e->getMessage() . $e->getCode();
            }
        }
    }
}
