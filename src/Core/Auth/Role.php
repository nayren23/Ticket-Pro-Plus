<?php

namespace TicketProPlus\App\Core\Auth;

enum Role: int
{
    case VISITOR = 0; // Utilisateur non connecté
    case ADMIN = 1;
    case DEVELOPER = 2;
    case REPORTER = 3;
}
