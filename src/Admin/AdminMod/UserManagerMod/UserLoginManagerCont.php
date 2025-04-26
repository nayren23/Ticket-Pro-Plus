<?php

require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

require_once "UserManagerView.php";
require_once "UserManagerModel.php";
require_once("Common/CommonLib/TokenManager.php");

class UserLoginManagerCont extends GenericController
{
    public function __construct()
    {
        $this->view = new UserManagerView;
        $this->model = new UserManagerModel;
        $this->action = (isset($_GET['action']) ? $_GET['action'] : 'gestionUseur');
    }

    //execution qui est appelle dans le AdminLoginMod
    public function exec() {}



    //affichage du dashboard contenant tous les useurs
    public function showUserList()
    {
        $resultat = $this->model->getUsers();
        $nb_page = $this->model->pagination($resultat);
        if (count($resultat) == 0) {
            header('Location: ./index.php?module=gestionUseur&action=gestionUseur&page=1');
        }
        $this->view->showUserList($resultat, $nb_page);
    }



    public function deleteUser()
    {
        $adminactuel = $this->model->recuperationIdUser($_SESSION["login"]); //pour éviter qu'on puisse supprimé le compte sur lequel on est connecté
        return $this->model->deleteUser($adminactuel);
    }

    //fonction de demande de confirmation du mdp pour la suppresion
    public function showDeleteMyAccountConfirmation()
    {
        createToken();
        $this->view->confirmdeleteMyAccount();
    }

    public function confirmPasswordCheck()
    {
        return $this->model->confirmPasswordCheck();
    }

    public function showUserInfo()
    {
        $resultat = $this->model->getUserInfo();
        $this->view->showUserInfo($resultat);
    }

    public function changeUserForm()
    {
        createToken();
        $resultat = $this->model->getUserInfo();
        $this->view->changeUserForm($resultat);
    }

    public function updateUser()
    {
        return $this->model->updateUser();
    }

    public function confirmChangeUser()
    {
        createToken();
        $this->view->confirmChangeUser();
    }

    public function createAdminForm()
    {
        createToken();
        $this->view->createAdminForm();
    }

    public function confirmCreateAdmin()
    {
        createToken();
        $this->view->confirmCreateAdmin();
    }

    public  function addAdmin()
    {
        return $this->model->addAdmin();
    }
    //----------------Notification-----------------------//

}
