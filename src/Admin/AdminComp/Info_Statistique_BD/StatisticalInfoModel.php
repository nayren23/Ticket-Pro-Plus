<?php

require_once("./Common/CommonLib/Error404.php");

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

// pas bon require_once("./connexion.php"); //
class StatisticalInfoModel extends Database
{
    public function recuperationStatistiqueUseur()
    {
        try {
            $sql = 'SELECT COUNT(*) as userNumber FROM utilisateur WHERE idGroupes = 1 UNION ALL SELECT COUNT(*) as userNumber2 FROM utilisateur WHERE idGroupes = 2 UNION ALL SELECT COUNT(*) as totalUseur FROM utilisateur UNION ALL  SELECT COUNT(*) as nombreFiche FROM fiche  ';
            $statement = $this->conn->prepare($sql);
            $statement->execute();
            $resultat = $statement->fetchAll();
            return $resultat;
        } catch (PDOException $e) {
            echo $e->getMessage() . $e->getCode();
        }
    }
}