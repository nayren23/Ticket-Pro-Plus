<?php

namespace TicketProPlus\App\Modules\Client;

use PDO, PDOException, TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();
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
            $firstname = $this->sanitize($_POST['firstname']);
            $lastname = $this->sanitize($_POST['lastname']);
            $email = $this->sanitize($_POST['email']);
            if (empty($firstname) || empty($lastname)) {
                throw new \Exception('Firstname and lastname are required.');
            }
            if ($this->checkEmail($email)) {
                throw new \Exception('Email already used.');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('Invalid email format.');
            }
            $sql = "INSERT INTO tp_client (c_firstname, c_lastname, c_email) VALUES (:firstname, :lastname, :email)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':firstname' => $firstname,
                ':lastname' => $lastname,
                ':email' => $email
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

    /**
     * Retourne le client correspondant à l'ID donné, ou null si le client n'existe pas.
     *
     * @param int $clientId l'ID du client à chercher.
     *
     * @return array|null Un tableau associatif contenant les clés 'id', 'firstname' et 'lastname'
     *                    correspondant au client demandé, ou null si le client n'existe pas.
     */
    public function getClientById(int $clientId): ?array
    {
        $sql = "SELECT c.* FROM tp_client c WHERE c_id = :client_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':client_id' => $clientId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    /**
     * Met à jour le client correspondant à l'ID donné.
     *
     * @param int $clientId l'ID du client à mettre à jour.
     * @param string $firstname le nouveau prénom du client.
     * @param string $lastname le nouveau nom du client.
     * @param string $email le nouveau courriel du client.
     * @param int $projectId [optional] l'ID du projet à mettre à jour avec le client.
     *
     * @return bool renvoie true si la mise à jour est effectuée, false sinon.
     */

    public function updateClient(int $clientId, string $firstname, string $lastname, string $email, int $projectId = null): bool
    {
        if (!$this->isEmailUniqueForUpdate($clientId, $email)) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'This email address is already in use by another client.'
            ];
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Invalid email format.'
            ];
            return false;
        }

        if ($projectId) {
            $sql = "UPDATE tp_project SET c_id = :client_id WHERE p_id = :project_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':client_id' => $clientId,
                ':project_id' => $projectId
            ]);
        } else {
            $sql = "UPDATE tp_client SET c_firstname = :firstname, c_lastname = :lastname, c_email = :email WHERE c_id = :client_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':client_id' => $this->sanitize($clientId),
                ':firstname' => $this->sanitize($firstname),
                ':lastname' => $this->sanitize($lastname),
                ':email' => $this->sanitize($email)
            ]);
        }

        if (!$result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Error updating client information.'
            ];
            return false;
        }
        return true;
    }

    /**
     * Nettoie les données en supprimant les balises HTML et les espaces inutiles,
     * puis encode les caractères spéciaux en entités HTML.
     *
     * @param mixed $data Les données à nettoyer.
     *
     * @return string Les données nettoyées.
     */

    public function sanitize($data)
    {
        return htmlspecialchars(strip_tags(trim($data)));
    }

    /**
     * Vérifie si l'email existe déjà dans la base de données.
     * 
     * @param string $email l'email à vérifier.
     * 
     * @return array|null Un tableau associatif contenant la clé 'c_email'
     *                    correspondant à l'email demandé, ou null si l'email n'existe pas.
     */
    public function checkEmail($email)
    {
        $sql = "SELECT c_email from tp_client WHERE c_email =:c_email";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['c_email' => htmlspecialchars($email)]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Vérifie si l'email est unique.
     *
     * @param int $clientId L'ID du client à exclure de la vérification.
     * @param string $email L'email à vérifier.
     *
     * @return bool Renvoie true si l'email est unique, false sinon.
     */

    public function isEmailUniqueForUpdate(int $clientId, string $email): bool
    {
        $sql = "SELECT COUNT(*) AS count FROM tp_client WHERE c_email = :email AND c_id != :client_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email, ':client_id' => $clientId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['count'] === 0;
    }

    /**
     * Renvoie un tableau de tous les projets qui sont affectés à aucun client.
     *
     * @return array Un tableau de projets, chaque projet étant un tableau associatif
     *               contenant les clés 'p_id' et 'p_name'.
     */
    public function getAllProjectsNoClient()
    {
        $sql = "SELECT p_id, p_name FROM tp_project WHERE c_id IS NULL";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
