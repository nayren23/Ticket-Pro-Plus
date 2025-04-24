<?php

require_once("./Common/Bibliotheque_Communes/errreur404.php");
if (constant("a2z") != "rya")
    die(affichage_erreur404_admin());

require_once("./connexion.php");


class Modele_comp_side_Bar_Menu extends Connexion
{

    // fonction génerique pour récupérer toutes les infosd'un user dans un seul tableau 
    public function recuperationIdUser()
    {
        try {

            $sql = 'Select idUser from utilisateur WHERE identifiant=:identifiant';
            $statement = self::$bdd->prepare($sql);
            $statement->execute(array(':identifiant' => $_SESSION['identifiant']));
            $resultat = $statement->fetch();
            return $resultat;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}
?>