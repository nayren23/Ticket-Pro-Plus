<?php

namespace TicketProPlus\App\Composants\NavbarComp;

use TicketProPlus\App\Core;
use TicketProPlus\App\Modules\User\UserModel;

class NavbarCont extends Core\GenericController
{

    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        //  $this->model = new UserModel();
        $this->view = new NavbarView;
    }

    public function displayNavbar()
    {
        $userId = $_SESSION['user']['u_id'];
        $user = $this->userModel->getUserById($userId);
        $this->view->display($user);
    }
}
