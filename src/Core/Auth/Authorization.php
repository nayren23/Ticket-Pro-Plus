<?php

namespace TicketProPlus\App\Core\Auth;

class Authorization
{
    /**
     * Vérifie si l'utilisateur connecté a l'un des rôles requis.
     *
     * @param array<Role> $requiredRoles Un tableau des rôles requis pour accéder à la ressource.
     * @return bool True si l'utilisateur a l'un des rôles requis, false sinon.
     */
    public static function hasRole(array $requiredRoles): bool
    {
        if (!isset($_SESSION['user']['r_id'])) {
            return false; // Aucun utilisateur connecté
        }

        $userRoleId = $_SESSION['user']['r_id'];

        foreach ($requiredRoles as $role) {
            if ($userRoleId === $role->value) {
                return true;
            }
        }

        return false;
    }

    /**
     * Redirige l'utilisateur vers une page d'erreur d'autorisation si aucun des rôles requis n'est respecté.
     *
     * @param array<Role> $requiredRoles Un tableau des rôles requis.
     * @param string $redirectUrl L'URL vers laquelle rediriger en cas d'échec d'autorisation.
     * Si null, une réponse 403 est envoyée.
     * @return void
     */
    public static function requireRole(array $requiredRoles, ?string $redirectUrl = null, ?bool $isLogged = null): void
    {
        if (!self::hasRole($requiredRoles) && $isLogged) {
            if ($redirectUrl) {
                header("Location: " . $redirectUrl);
                exit;
            } else {
                http_response_code(403);
                include __DIR__ . '/../../../public/errors/403.html';
                exit;
            }
        }
    }
}
