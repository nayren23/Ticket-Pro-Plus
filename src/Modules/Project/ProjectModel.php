<?php

namespace TicketProPlus\App\Modules\Project;

use PDO, PDOException, TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

class ProjectModel extends Core\GenericModel
{

    /**
     * Renvoie un tableau associatif contenant les prénom et nom de tous les clients.
     *
     * @return array Un tableau associatif contenant les clés 'c_firstname' et 'c_lastname'
     *               correspondant à chaque client.
     */
    public function getAllClients()
    {
        $sql = "SELECT c_id, c_firstname, c_lastname FROM tp_client";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau projet.
     *
     * @throws \Exception si 'p_name' est vide.
     *
     * @return bool renvoie true si le projet est créé, false sinon.
     */
    public function addProject()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $this->sanitize($_POST['name']);
            $description = isset($_POST['description']) ? $this->sanitize($_POST['description']) : null;
            $creationDate = date('Y-m-d H:i:s');
            $dueDateRaw = $this->sanitize($_POST['due_date']);
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dueDateRaw);
            $dueDate = $dateTime->format('Y-m-d') . ' 00:00:00';
            $closed = isset($_POST['closed']) ? true : false;
            $clientId = empty($_POST['clientId']) ? null : $this->sanitize($_POST['clientId']);

            if (empty($name)) {
                throw new \Exception('Name is required.');
            }

            $sql = "INSERT INTO tp_project (p_name, p_description, p_creation, p_due_date, p_closed, c_id) VALUES (:name, :description, :creation, :due_date, :closed, :client_id)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':name' => $name,
                ':description' => $description,
                ':creation' => $creationDate,
                ':due_date' => $dueDate,
                ':closed' => $closed,
                ':client_id' => $clientId
            ]);
            return true;
        }
        return false;
    }

    /**
     * Retourne le nombre total de projets.
     *
     * @return int Le nombre total de projets dans la base de données.
     */

    public function getTotalProjects(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_project";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Retourne un tableau de projets paginé.
     *
     * @param int $offset Le numéro du premier projet à retourner.
     * @param int $limit Le nombre maximum de projets à retourner.
     *
     * @return array Un tableau de projets, chaque projet étant un tableau associatif
     *               contenant les clés 'p_id', 'p_name', 'p_description', 'p_creation', 'p_due_date',
     *               'p_closed', 'c_id', 'firstname', 'lastname' et 'email'.
     */
    public function getProjectsWithPagination(int $offset, int $limit, $clientId = null): array
    {
        $sql = "SELECT p.*, c.c_firstname, c.c_lastname
            FROM tp_project p
            LEFT JOIN tp_client c ON p.c_id = c.c_id";

        $params = [];

        if (isset($clientId) && $clientId) {
            $sql .= " WHERE p.c_id = :client_id";
            $params[':client_id'] = $clientId;
        }

        $sql .= " LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);

        // Bind params
        if (isset($params[':client_id'])) {
            $stmt->bindParam(':client_id', $params[':client_id'], PDO::PARAM_INT);
        }

        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
     * Supprime un projet par son ID.
     *
     * @param int $projectId l'ID du projet à supprimer.
     *
     * @return bool renvoie true si la suppression est effectuée, false sinon.
     */
    public function deleteProject(int $projectId): bool
    {
        $sql = "DELETE FROM tp_project WHERE p_id = :project_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':project_id' => $projectId]);
    }

    /**
     * Retourne le projet correspondant à l'ID donné, ou null si le projet n'existe pas.
     *
     * @param int $projectId l'ID du projet à chercher.
     *
     * @return array|null Un tableau associatif contenant les clés 'p_id', 'p_name', 'p_description',
     *                    'p_creation', 'p_due_date', 'p_closed', 'c_id', 'firstname', 'lastname' et 'email'
     *                    correspondant au projet demandé, ou null si le projet n'existe pas.
     */
    public function getProjectById(int $projectId): ?array
    {
        $sql = "SELECT p.*, c.c_firstname, c.c_lastname FROM tp_project p LEFT JOIN tp_client c ON p.c_id = c.c_id WHERE p_id = :project_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':project_id' => $projectId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Met à jour un projet.
     *
     * @param int    $projectId      l'ID du projet à mettre à jour.
     * @param string $name           le nom du projet.
     * @param string $description    la description du projet.
     * @param string $dueDate        la date de fin du projet.
     * @param bool   $closed         si le projet est clos ou non.
     * @param int    $clientId       l'ID du client lié au projet.
     *
     * @return bool renvoie true si la mise à jour est effectuée, false sinon.
     */
    public function updateProject($projectId, $name, $description, $dueDate, $closed, $clientId): bool
    {
        if ($clientId !== null) {
            $sql = "UPDATE tp_project SET p_name = :name, p_description = :description, p_due_date = :due_date, p_closed = :closed, c_id = :client_id WHERE p_id = :project_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':due_date' => $dueDate,
                ':closed' => $closed,
                ':project_id' => $projectId,
                ':client_id' => $clientId
            ]);
        } else {
            $sql = "UPDATE tp_project SET p_name = :name, p_description = :description, p_due_date = :due_date, p_closed = :closed, c_id = NULL WHERE p_id = :project_id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':name' => $name,
                ':description' => $description,
                ':due_date' => $dueDate,
                ':closed' => $closed,
                ':project_id' => $projectId
            ]);
        }

        if (!$result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Error updating project information.'
            ];
            return false;
        }
        return true;
    }
}
