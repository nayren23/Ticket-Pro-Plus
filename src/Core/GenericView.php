<?php

namespace TicketProPlus\App\Core;

class GenericView
{

    public function  __construct()
    {
        ob_start();
    }

    public function showTampon()
    {
        return ob_get_clean();
    }
}
