<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core;


class TicketCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new TicketModel();
        $this->view = new TicketView();
    }

    public function showTicketPage()
    {
        $this->view->showTicketPage();
    }

}
