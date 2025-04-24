<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
    die(affichage_erreur404());

class ModeleNavBar extends Database
{

    public function recupererPhoto()
    {
        try {

            $sql = 'Select * from utilisateur WHERE identifiant=:identifiant';
            $statement = $this->getConnection()->prepare($sql);
            $statement->execute(array(':identifiant' => $_SESSION['identifiant']));
            $resultat = $statement->fetch();
            return $resultat;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }


    /**
     * fonction recupere l'id de la dernier fiche créer
     */
    function recupererDerniereFicheUser()
    {

        try {
            $sql1 = "select idFiche from fiche join utilisateur using (idUser) where identifiant = :identifiant  ORDER BY `fiche`.`dateEcriture` DESC LIMIT 0, 1";
            $statement1 = $this->getConnection()->prepare($sql1);
            $statement1->execute(array(':identifiant' => $_SESSION['identifiant']));
            $result = $statement1->fetch(); //on  retourne tous les exos
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}
?>