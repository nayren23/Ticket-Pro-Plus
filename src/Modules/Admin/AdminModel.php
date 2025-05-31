<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core\Database\Database;
use PDO, PDOException, TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();

class AdminModel extends Core\GenericModel
{

    public function getTicketCountsByDeveloper(): array
    {
        $query = "SELECT
            u.u_login AS developer,
            COUNT(tw.u_id) AS ticket_count
        FROM tp_work tw
        JOIN tp_ticket t ON tw.t_id = t.t_id
        JOIN tp_user u ON tw.u_id = u.u_id
        JOIN tp_role r ON u.r_id = r.r_id
        WHERE r.r_name = 'Developer'
        GROUP BY u.u_login
        ORDER BY ticket_count DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalTicketCounts(): array
    {
        $query = "SELECT
            COUNT(CASE WHEN s.s_name = 'New' THEN 1 END) AS created_count,
            COUNT(CASE WHEN s.s_name = 'InProgress' THEN 1 END) AS in_progress_count,
            COUNT(CASE WHEN s.s_name = 'Resolved' THEN 1 END) AS resolved_count,
            COUNT(CASE WHEN s.s_name = 'Closed' THEN 1 END) AS closed,
            COUNT(t.t_id) AS total_count
        FROM tp_ticket t
        JOIN tp_status s ON t.s_id = s.s_id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAverageResolutionTime(): array
    {
        $query = "SELECT
            AVG(UNIX_TIMESTAMP(t_timestamp_closed) - UNIX_TIMESTAMP(t_creation)) AS average_resolution
        FROM tp_ticket
        WHERE t_timestamp_closed IS NOT NULL AND t_creation IS NOT NULL";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['average_resolution'] !== null) {
            $result = $this->formatResolutionTime($result['average_resolution']);
        } else {
            $result = ['N/A', ''];
        }
        return $result;
    }

    private function formatResolutionTime(int $totalSeconds): array
    {
        $days = floor($totalSeconds / (3600 * 24));
        $hours = floor(($totalSeconds % (3600 * 24)) / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);

        if ($days > 0) {
            return [$days, 'days'];
        } elseif ($hours > 0) {
            return [$hours, 'hours'];
        } elseif ($minutes > 0) {
            return [$minutes, 'minutes'];
        } else {
            return ['Less than a minute'];
        }
    }

    public function getTicketCountsByPeriod(string $period = "today"): array
    {
        $query = "SELECT
            COUNT(CASE WHEN s.s_name = 'New' THEN 1 END) AS created_count,
            COUNT(CASE WHEN s.s_name = 'InProgress' THEN 1 END) AS in_progress_count,
            COUNT(CASE WHEN s.s_name = 'Resolved' THEN 1 END) AS resolved_count,
            COUNT(CASE WHEN s.s_name = 'Closed' THEN 1 END) AS closed_count
        FROM tp_ticket t
        JOIN tp_status s ON t.s_id = s.s_id
        WHERE 1=1 "; // Ajout d'une condition toujours vraie pour faciliter l'ajout de clauses WHERE

        switch ($period) {
            case 'today':
                $query .= "AND DATE(t_creation) = CURDATE()";
                break;
            case 'week':
                $query .= "AND YEARWEEK(t_creation, 1) = YEARWEEK(CURDATE(), 1)";
                break;
            case 'month':
                $query .= "AND YEAR(t_creation) = YEAR(CURDATE()) AND MONTH(t_creation) = MONTH(CURDATE())";
                break;
            case 'year':
                $query .= "AND YEAR(t_creation) = YEAR(CURDATE())";
                break;
            default:
                return []; // Ou une autre valeur par défaut si la période n'est pas reconnue
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
