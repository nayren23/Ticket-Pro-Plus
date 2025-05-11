<?php

namespace TicketProPlus\App\Core;

use TicketProPlus\App\Config, PDOException;

class GenericModel extends Config\Database
{

    public function logout()
    {
        if (isset($_SESSION["u_login"])) {
            unset($_SESSION["u_login"]);
            session_destroy();
            return true;
        } else {
            return false; //Vous devez d abord vous connecté pour faire cette action !!!
        }
    }

    /**
     *Fonction génerique pour récupérer toutes les infos d'un user dans un seul tableau
     */
    public function getUser()
    {
        try {
            $sql = 'Select * from tp_user WHERE u_login =:u_login';
            $statement = $this->conn->prepare($sql);
            $statement->execute(array(':u_login' => $_SESSION["u_login"]));
            $resultat = $statement->fetch();
            return $resultat;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}
