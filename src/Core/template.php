<?php

use TicketProPlus\App\Core;
use TicketProPlus\App\Composants\NavbarComp;
use TicketProPlus\App\Core\Auth\Role;
use TicketProPlus\App\Core\Auth\Authorization;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- FlowBite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/zxcvbn/4.4.2/zxcvbn.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Chart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>
    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- Sweetalert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- CSS only -->
    <link href="./public/assets/css/main.css" rel="stylesheet" />
    <link href="./public/assets/css/404.css" rel="stylesheet" />
    <link href="./public/assets/css/403.css" rel="stylesheet" />
    <link rel=" icon" href="./public/assets/images/Ticket_Pro_favicon.png" type="image/x-icon">

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />

    <!-- Script only -->
    <title>Ticket-Pro-Plus</title>
</head>

<body>

    <?php


    if (Authorization::hasRole([Role::ADMIN, Role::DEVELOPER, Role::REPORTER])) {
        $navbar = new NavbarComp\NavbarCont();
        $navbar->displayNavbar();
    }
    $router = new Core\Router();

    ?>


    <script src="./src/Modules/User/UserScript.js"></script>
    <script src="./src/Modules/Client/ClientScript.js"></script>
    <script src="./src/Modules/Project/ProjectScript.js"></script>
    <script src="./public/assets/js/passwordValidation.js"></script>

    <script src="./src/Core/utils.js"></script>


</body>

</html>