<?php

namespace TicketProPlus\App\Modules\Login;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();
class LoginCont extends Core\GenericController
{

    public function __construct()
    {
        $this->model = new LoginModel();
        $this->view = new LoginView;
    }

    public function showLoginForm()
    {
        $this->view->loginForm();
    }

    public function logout()
    {
        $this->model->logout();
        header('Location: ?module=login&action=showLoginForm');
    }


    /**
     * Authentifie un utilisateur en utilisant le modèle associé.
     *
     * Cette méthode appelle la fonction `authenticate()` du modèle pour vérifier 
     * les identifiants de l'utilisateur. Si l'utilisateur est authentifié avec succès, 
     * il est redirigé vers le tableau de bord (/dashboard). Sinon, un message d'erreur 
     * est stocké en session et l'utilisateur est redirigé vers la page de connexion (/login).
     *
     * @return void
     */
    public function authenticate()
    {
        $user = $this->model->authenticate();
        if ($user) {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::SUCCESS->value,
                'message' => 'Successfully connected!'
            ];
            header('Location: ?module=admin&action=stats');
        } else {
            $_SESSION['toast'] = [
                'type' => Core\ToastType::ERROR->value,
                'message' => 'Error login!'
            ];
            header('Location: ?module=login&action=showLoginForm');
        }
    }
}
