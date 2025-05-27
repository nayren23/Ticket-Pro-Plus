<?php

namespace TicketProPlus\App\Modules\Client;

use PDO, PDOException, TicketProPlus\App\Core;

class ClientModel extends Core\GenericModel
{
    /**
     * Ajoute le nouveau client dans la database.
     *
     * @throws \Exception si firstname ou lastname sont vides.
     *
     * @return bool renvoie true si l'ajout est effectué sinon false.
     */
    public function addClient()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $firstname = $_POST['firstname'] ?? '';
            $lastname = $_POST['lastname'] ?? '';
            if (empty($firstname) || empty($lastname)) {
                throw new \Exception('Firstname and lastname are required.');
            }
            $sql = "INSERT INTO tp_client (c_firstname, c_lastname) VALUES (:firstname, :lastname)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
            ]);
            return true;
        }
        return false;
    }

    /**
     * Supprime un client par son ID.
     *
     * @param int $clientId l'ID du client à supprimer.
     *
     * @return bool renvoie true si la suppression est effectuée, false sinon.
     */
    public function deleteClient(int $clientId): bool
    {
        $sql = "DELETE FROM tp_client WHERE c_id = :client_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute(['client_id' => $clientId]);
    }

    /**
     * Retourne le nombre total de clients.
     *
     * @return int le nombre total de clients.
     */
    public function getTotalClients(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_client";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Retourne un tableau de clients paginé.
     *
     * @param int $offset Le numéro du premier client à retourner.
     * @param int $limit Le nombre maximum de clients à retourner.
     *
     * @return array Un tableau de clients, chaque client étant un tableau associatif
     *               contenant les clés 'firstname' et 'lastname'.
     */
    public function getClientsWithPagination(int $offset, int $limit): array
    {
        $sql = "SELECT c.*
                FROM tp_client c
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
