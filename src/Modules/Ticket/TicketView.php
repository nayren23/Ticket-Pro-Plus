<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core;

class TicketView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function showTicketPage()
    {
        echo "ça marche";
    }


}
?>