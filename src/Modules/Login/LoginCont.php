<?php

namespace TicketProPlus\App\Modules\Login;

use TicketProPlus\App\Core;


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
            echo "Connexion Réussie";
            header('Location: /dashboard');
            exit;
        } else {
            // Afficher un message d'erreur
            $_SESSION['error'] = "Email ou mot de passe incorrect";
            header('Location: /login');
            exit;
        }
    }
}
