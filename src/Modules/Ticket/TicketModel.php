<?php

namespace TicketProPlus\App\Modules\Ticket;

use PDO, PDOException, TicketProPlus\App\Core;

class TicketModel extends Core\GenericModel
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
     * Renvoie un tableau associatif contenant les informations de tous les projets.
     *
     * @return array Un tableau associatif contenant les clés 'p_id', 'p_name', 'p_description',
     *               'p_creation', 'p_due_date', 'p_closed', 'c_id' correspondant à chaque projet.
     */
    public function getAllProjects()
    {
        $sql = "SELECT * FROM tp_project";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAllDevelopers()
    {
        $sql = "SELECT u_id, u_firstname, u_lastname FROM tp_user WHERE r_id = '2'";
        $stmt = $this->conn->prepare($sql); 
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ajoute un nouveau ticket.
     *
     * @throws \Exception si 'tp_ticket'::addTicket()' échoue.
     *
     * @return bool renvoie true si le ticket est créé, false sinon.
     */
    public function addTicket()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $description = $this->sanitize($_POST['description']);
            $creationDate = date('Y-m-d H:i:s');
            $dueDateRaw = $this->sanitize($_POST['due_date']);
            $dateTime = \DateTime::createFromFormat('m/d/Y', $dueDateRaw);
            $dueDate = $dateTime->format('Y-m-d') .' 00:00:00';
            $clientId = empty($_POST['clientId']) ? null : $this->sanitize($_POST['clientId']);
            $projectId = $this->sanitize($_POST['projectId']);
            $statusId = $this->sanitize($_POST['statusId']);
            $timeClosed = ($statusId == 4) ? date('Y-m-d H:i:s') : null;
            $priorityId = $this->sanitize($_POST['priorityId']);
            $developerId = empty($_POST['developerId']) ? null : $this->sanitize($_POST['developerId']);

            if (empty($description)) {
                throw new \Exception('Description is required.');
            }
            
            $sql = "INSERT INTO tp_ticket (t_description, t_creation, t_due_date, t_timestamp_modification, t_timestamp_closed, c_id, pty_id, s_id, p_id, u_id) VALUES (:description, :creation, :due_date, :timeModification, :timeClosed, :client_id, :priority_id, :status_id, :project_id, :developer_id)";
            $statement = $this->conn->prepare($sql);

            $statement->execute([
                ':description' => $description,
                ':creation' => $creationDate,
                ':due_date' => $dueDate,
                ':timeModification' => $creationDate,
                ':timeClosed' => $timeClosed,
                ':client_id' => $clientId,
                ':priority_id' => $priorityId,
                ':status_id' => $statusId,
                ':project_id' => $projectId,
                ':developer_id' => $developerId
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

    /**
     * Renvoie le nombre total de tickets.
     *
     * @return int le nombre total de tickets.
     */
    public function getTotalTickets(): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_ticket";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    /**
     * Renvoie un tableau de tickets paginé.
     *
     * @param int $offset Le numéro du premier ticket à retourner.
     * @param int $limit Le nombre maximum de tickets à retourner.
     *
     * @return array Un tableau de tickets, chaque ticket étant un tableau associatif
     *               contenant les clés 't_id', 't_description', 't_creation', 't_due_date',
     *               't_timestamp_modification', 't_timestamp_closed', 'c_id', 'c_firstname',
     *               'c_lastname', 'pty_id', 'pty_name', 'p_id', 'p_name', 's_id', 's_name'.
     */
    public function getTicketsWithPagination(int $offset, int $limit): array
    {
        $sql = "SELECT t.*, c.c_firstname, c.c_lastname, pty.pty_name, p.p_name, s.s_name, u.u_firstname, u.u_lastname
                FROM tp_ticket t
                LEFT JOIN tp_client c ON t.c_id = c.c_id
                LEFT JOIN tp_project p ON t.p_id = p.p_id
                LEFT JOIN tp_status s ON t.s_id = s.s_id
                LEFT JOIN tp_priority pty ON t.pty_id = pty.pty_id
                LEFT JOIN tp_user u ON t.u_id = u.u_id
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Supprime un ticket par son ID.
     *
     * @param int $ticketId l'ID du ticket à supprimer.
     *
     * @return bool renvoie true si la suppression est effectuée, false sinon.
     */
    public function deleteTicket(int $ticketId): bool
    {
        $sql = "DELETE FROM tp_ticket WHERE t_id = :ticket_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':ticket_id' => $ticketId]);
    }

    /**
     * Retourne le ticket correspondant à l'ID donné, ou null si le ticket n'existe pas.
     *
     * @param int $ticketId l'ID du ticket à chercher.
     *
     * @return array|null Un tableau associatif contenant les clés 't_id', 't_description', 't_creation', 't_due_date',
     *                    't_timestamp_modification', 't_timestamp_closed', 'c_id', 'c_firstname', 'c_lastname', 'pty_id',
     *                    'pty_name', 'p_id', 'p_name', 's_id', 's_name', 'u_id', 'u_firstname', 'u_lastname'
     *                    correspondant au ticket demandé, ou null si le ticket n'existe pas.
     */
    public function getTicketById(int $ticketId): ?array
    {
        $sql = "SELECT t.*, c.c_firstname, c.c_lastname, p.p_name, u.u_firstname, u.u_lastname 
        FROM tp_ticket t 
        LEFT JOIN tp_client c ON t.c_id = c.c_id 
        LEFT JOIN tp_project p ON t.p_id = p.p_id
        LEFT JOIN tp_user u ON t.u_id = u.u_id
        WHERE t.t_id = :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ticket_id' => $ticketId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
    * Met à jour un ticket existant avec les détails fournis.
    *
    * @param int $ticketId L'ID du ticket à mettre à jour.
    * @param string $description La description mise à jour du ticket.
    * @param string $dueDate La nouvelle date d'échéance du ticket.
    * @param int|null $clientId L'ID du client associé au ticket, ou null.
    * @param int $projectId L'ID du projet lié au ticket.
    * @param int $statusId L'ID du statut actuel du ticket.
    * @param string|null $timeClosed La date et l'heure de clôture du ticket, ou null.
    * @param string $timeModified La date et l'heure de la dernière modification du ticket.
    * @param int $priorityId L'ID de la priorité assignée au ticket.
    * @param int|null $developerId L'ID du développeur assigné au ticket, ou null.
    *
    * @return bool Renvoie true si la mise à jour est réussie, false sinon.
    */
    public function updateTicket($ticketId, $description, $dueDate, $clientId, $projectId, $statusId, $timeClosed, $timeModified, $priorityId, $developerId, $oldStatusValue) : bool
    {
        if($oldStatusValue != $statusId){
            $this->sendMailNotification($clientId, $statusId, $ticketId);
        }

        $sql = "UPDATE tp_ticket
                SET t_description = :description, 
                    t_due_date = :due_date, 
                    c_id = :client_id, 
                    p_id = :project_id, 
                    s_id = :status_id, 
                    t_timestamp_closed = :time_closed, 
                    t_timestamp_modification = :time_modified, 
                    pty_id = :priority_id, 
                    u_id = :developer_id
                WHERE t_id = :ticket_id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            ':description' => $description,
            ':due_date' => $dueDate,
            ':client_id' => $clientId,
            ':project_id' => $projectId,
            ':status_id' => $statusId,
            ':time_closed' => $timeClosed,
            ':time_modified' => $timeModified,
            ':priority_id' => $priorityId,
            ':developer_id' => $developerId,
            ':ticket_id' => $ticketId
        ]);
        

        if (!$result) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Error updating ticket information.'
            ];
            return false;
        }
        return true;
    }

    /**
     * Renvoie un tableau de tickets paginé, appartenant à l'utilisateur donné.
     *
     * @param int $userId l'ID de l'utilisateur.
     * @param int $offset Le numéro du premier ticket à retourner.
     * @param int $limit Le nombre maximum de tickets à retourner.
     *
     * @return array Un tableau de tickets, chaque ticket étant un tableau associatif
     *               contenant les clés 't_id', 't_description', 't_creation', 't_due_date',
     *               't_timestamp_modification', 't_timestamp_closed', 'c_id', 'c_firstname',
     *               'c_lastname', 'pty_id', 'pty_name', 'p_id', 'p_name', 's_id', 's_name',
     *               'u_id', 'u_firstname', 'u_lastname'.
     */
    public function getTicketsByUserId($userId, int $offset, int $limit) : array 
    {
        $sql = "SELECT t.*, c.c_firstname, c.c_lastname, pty.pty_name, p.p_name, s.s_name, u.u_firstname, u.u_lastname
                FROM tp_ticket t
                LEFT JOIN tp_client c ON t.c_id = c.c_id
                LEFT JOIN tp_project p ON t.p_id = p.p_id
                LEFT JOIN tp_status s ON t.s_id = s.s_id
                LEFT JOIN tp_priority pty ON t.pty_id = pty.pty_id
                LEFT JOIN tp_user u ON t.u_id = u.u_id
                WHERE t.u_id = :user_id
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Renvoie le nombre total de tickets appartenant à l'utilisateur donné.
     *
     * @param int $userId l'ID de l'utilisateur.
     *
     * @return int le nombre total de tickets.
     */
    public function getTotalTicketsByUserId($userId): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_ticket WHERE u_id = :user_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':user_id' => $userId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }
    
    /**
     * Ajoute un commentaire à un ticket.
     *
     * @param int $ticketId L'ID du ticket.
     * @param int $userId L'ID de l'utilisateur qui écrit le commentaire.
     * @param string $description Le commentaire à ajouter.
     *
     * @return bool Renvoie true si le commentaire est ajouté, false sinon.
     */
    public function addUpdate($ticketId, $userId, $description)
    {
        $sql = "INSERT INTO tp_work (u_id, t_id, w_commentary, w_timestamp_modification) VALUES (:user_id, :ticket_id, :content, :time)";
        $time = date('Y-m-d H:i:s');
        $content = $this->sanitize($description);
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            ':user_id' => $userId,
            ':ticket_id' => $ticketId,
            ':content' => $content,
            ':time' => $time
        ]);
    
        // Met à jour le champ t_timestamp_modification du ticket
        if ($result) {
            $updateSql = "UPDATE tp_ticket SET t_timestamp_modification = :time WHERE t_id = :ticket_id";
            $updateStmt = $this->conn->prepare($updateSql);
            $updateStmt->execute([
                ':time' => $time,
                ':ticket_id' => $ticketId
            ]);
        }
    
        return $result;
    }

    /**
     * Renvoie le nombre total de mises à jour d'un ticket.
     *
     * @param int $ticketId l'ID du ticket.
     *
     * @return int le nombre total de mises à jour.
     */
    public function getTotalUpdates(int $ticketId): int
    {
        $sql = "SELECT COUNT(*) AS total FROM tp_work WHERE t_id = :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':ticket_id' => $ticketId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'] ?? 0;
    }

    /**
     * Renvoie les mises à jour d'un ticket, paginées.
     *
     * @param int $offset Le numéro du premier commentaire à retourner.
     * @param int $limit Le nombre maximum de commentaires à retourner.
     * @param int $ticketId L'ID du ticket.
     *
     * @return array Un tableau de mises à jour, chaque mise à jour étant un tableau associatif
     *               contenant les clés 'w_id', 'u_id', 't_id', 'w_commentary', 'w_timestamp_modification',
     *               'u_firstname', 'u_lastname'.
     */
    public function getUpdatesWithPagination(int $offset, int $limit, int $ticketId): array
    {
        $sql = "SELECT w.*, u.u_firstname, u.u_lastname
                FROM tp_work w
                LEFT JOIN tp_user u ON w.u_id = u.u_id
                WHERE w.t_id = :ticket_id
                LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':ticket_id', $ticketId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sendMailNotification($clientId, $statusId, $ticketId)
    {
        $sql = "SELECT c.c_email, c.c_firstname, c.c_lastname, s.s_name
                FROM tp_client c
                JOIN tp_ticket t ON c.c_id = t.c_id
                JOIN tp_status s ON t.s_id = s.s_id
                WHERE c.c_id = :client_id AND t.t_id = :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':client_id' => $clientId, ':ticket_id' => $ticketId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            $toEmail = $result['c_email'];
            $toName = $result['c_firstname'];
            $toName .= ' ' . $result['c_lastname'];
            $statusName = $result['s_name'];

            // Envoi de l'email
            $mailer = new \TicketProPlus\App\Core\Mail\Mailer();
            $subject = 'Your ticket status has been updated';
            $bodyHtml = '<p>Hello ' . $toName . ',</p><p>Your ticket status has been updated to <strong>' . $statusName . '</strong>.</p>';
            $bodyText = 'Hello ' . $toName . ', Your ticket status has been updated to ' . $statusName . '.';
            $mailer->send($toEmail, $toName, $subject, $bodyHtml, $bodyText);
        }
    }
}

    