<?php

namespace TicketProPlus\App\Core;

use TicketProPlus\App\Config, PDOException;

class GenericModel extends Config\Database
{

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
