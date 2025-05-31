<?php

namespace TicketProPlus\App\Modules\Search;

use PDO, PDOException, TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

    
class SearchModel extends Core\GenericModel
{

    // Exemple dans AdminModel.php (vous pourriez avoir des modèles dédiés)
    public function searchClients(string $searchTerm): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM tp_client WHERE c_firstname LIKE :term1 OR c_lastname LIKE :term2 OR c_email LIKE :term3");
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindValue(':term1', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term2', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term3', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchLogins(string $searchTerm): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM tp_user WHERE u_login LIKE :term1 OR u_email LIKE :term2");
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindValue(':term1', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term2', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchProjects(string $searchTerm): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM tp_project WHERE p_name LIKE :term1 OR p_description LIKE :term2");
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindValue(':term1', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term2', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchTickets(string $searchTerm): array
    {
        $stmt = $this->conn->prepare("SELECT t.*, c.c_firstname, c.c_lastname
                                   FROM tp_ticket t
                                   LEFT JOIN tp_client c ON t.c_id = c.c_id
                                   WHERE t.t_description LIKE :term1
                                      OR t.t_creation LIKE :term2
                                      OR t.t_due_date LIKE :term3
                                      OR t.t_timestamp_modification LIKE :term4
                                      OR t.t_timestamp_closed LIKE :term5
                                      OR c.c_firstname LIKE :term6
                                      OR c.c_lastname LIKE :term7");
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindValue(':term1', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term2', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term3', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term4', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term5', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term6', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term7', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchUsers(string $searchTerm): array
    {
        $stmt = $this->conn->prepare("SELECT * FROM tp_user WHERE u_firstname LIKE :term1 OR u_lastname LIKE :term2 OR u_email LIKE :term3 OR u_login LIKE :term4");
        $searchTermWithWildcards = '%' . $searchTerm . '%';
        $stmt->bindValue(':term1', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term2', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term3', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->bindValue(':term4', $searchTermWithWildcards, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
