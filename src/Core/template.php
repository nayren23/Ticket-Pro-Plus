<?php

use TicketProPlus\App\Core;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- FlowBite -->
    <script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.css" rel="stylesheet" />

    <!-- Jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- CSS only -->
    <link href="./public/assets/css/main.css" rel="stylesheet" />
    <link rel=" icon" href="ressource/images/TabA2Z.png" type="image/x-icon">

    <!-- Script only -->
    <title>TicketProPlus</title>
</head>

<body>
    <?php
    $router = new Core\Router();
    ?>
    <script src="./src/Modules/User/UserScript.js"></script>
</body>

</html>