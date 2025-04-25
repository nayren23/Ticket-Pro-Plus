<?php

require_once "./Common/GenericClass/GenericView.php";
require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());


class NavbarLoginView extends GenericView
{
    public function  __construct()
    {
        parent::__construct();
    }

    function navBar()
    {
?>

<nav class="border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <!-- Logo -->
        <a href="index.php?module=principale" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="./public/assets/Ticket-Pro-logo.png" class="h-8" alt="Site Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Ticket Pro +</span>
        </a>


        <!-- Burger menu -->
        <button data-collapse-toggle="navbar-solid-bg" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-solid-bg" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <!-- Menu -->
        <div class="hidden w-full md:block md:w-auto" id="navbar-solid-bg">
            <ul
                class="flex flex-col font-medium mt-4 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-transparent dark:bg-gray-800 md:dark:bg-transparent dark:border-gray-700">
                <li><a href="#"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Home</a>

                </li>
                <li><a href="#"
                        class="block py-2 px-3 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 dark:text-white dark:hover:bg-gray-700 md:dark:hover:bg-transparent">Contact</a>
                </li>
            </ul>
        </div>

        <!-- Boutons de connexion/inscription -->
        <div class="flex space-x-2 mt-4 md:mt-0">
            <?php
                    $action = $_GET['action'] ?? null;
                    $estConnecte = isset($_SESSION['identifiant']);

                    if (!$estConnecte && $action !== "inscription") {
                        echo '<button onclick="window.location.href = \'index.php?module=connexion&action=inscription\'" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Sign In</button>';
                    }

                    if (!$estConnecte && $action !== "connexion") {
                        echo '<button onclick="window.location.href = \'index.php?module=connexion&action=connexion\'" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Log in</button>';
                    }

                    // Bouton admin toujours visible
                    echo '<button onclick="window.location.href = \'index.php?module=administration\'" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200 font-medium rounded-lg text-sm px-4 py-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Administration</button>';
                    ?>
        </div>
    </div>

</nav>
<?php
    }
}
?>