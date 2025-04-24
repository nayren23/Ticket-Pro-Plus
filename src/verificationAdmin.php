<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
    die(affichage_erreur404());

class VerifAdmin extends Database
{

    public function verificationConnexionAdmin()
    {
        if (isset($_SESSION['identifiant'])) {
            try {
                $sql = 'Select * from utilisateur WHERE (identifiant=:identifiant)';
                $statement = $this->getConnection()->prepare($sql);
                $statement->execute(array(':identifiant' => $_SESSION['identifiant']));
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

?>