<?php

namespace TicketProPlus\App\Modules\Project;

use PDO, PDOException, TicketProPlus\App\Core;

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
            $dueDate = $dateTime->format('Y-m-d') .' 00:00:00';
            $closed = isset($_POST['closed']) ? true : false;
            $clientId = $this->sanitize($_POST['clientId']);

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

}
