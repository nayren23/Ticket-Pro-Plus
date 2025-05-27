<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core;

class ClientModel extends Core\GenericModel
{
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
}
