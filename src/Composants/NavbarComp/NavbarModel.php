<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class NavbarModel extends Database
{

    public function getPicture()
    {
        try {
            $sql = 'Select * from utilisateur WHERE identifiant=:identifiant';
            $statement = $this->getConnection()->prepare($sql);
            $statement->execute(array(':identifiant' => $_SESSION['identifiant']));
            $resultat = $statement->fetch();
            return $resultat["cheminImage"];
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}
