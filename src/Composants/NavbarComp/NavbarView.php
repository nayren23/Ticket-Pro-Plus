<?php

namespace TicketProPlus\App\Composants\NavbarComp;

use TicketProPlus\App\Core;

class NavbarView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function display($user)
    {

?>
        <nav class="bg-white border-gray-200 dark:bg-gray-900">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="index.php?module=admin&action=stats" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <img src="./public/assets/images/Ticket_Pro_logo.png" class="h-8" alt="Ticket Pro Plus Logo" />
                    <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Ticket-Pro-Plus</span>
                </a>
                <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                    <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full" src="public/<?= $user["u_profile_picture"] ?>" alt="user photo">
                    </button>
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white"><?= $user["u_firstname"] . " " . $user["u_lastname"] ?></span>
                            <span class="block text-sm  text-gray-500 truncate dark:text-gray-400"><?= $user["u_email"] ?></span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button">
                            <li>
                                <a href="index.php?module=login&action=logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Sign out</a>
                            </li>
                        </ul>
                    </div>
                    <button data-collapse-toggle="navbar-user" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-user" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15" />
                        </svg>
                    </button>
                </div>
                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-user">
                    <ul class="flex flex-col font-medium p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                        <li>
                            <a href="index.php?module=admin&action=stats" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" aria-current="page">Home</a>
                        </li>


                        <li>
                            <button type="button" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" id="ticket-menu-button" aria-expanded="false" data-dropdown-toggle="ticket-dropdown" data-dropdown-placement="bottom">
                                Tickets
                            </button>
                            <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="ticket-dropdown">
                                <ul class="py-2" aria-labelledby="ticket-menu-button">
                                    <?php if (isset($user['r_id']) && (($user['r_id'] == 1) || ($user['r_id'] == 3))): ?>
                                        <li>
                                            <a href="index.php?module=ticket&action=manageTicket&order=dateASC" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Manage Tickets</a>
                                        </li>
                                        <li>
                                            <a href="index.php?module=ticket&action=addTicket" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Add Tickets</a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (isset($user['r_id']) && ($user['r_id'] == 2)): ?>
                                        <li>
                                            <a href="index.php?module=ticket&action=viewMyTickets" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">View My Tickets</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </li>

                        <?php if (isset($user['r_id']) && $user['r_id'] == 1): ?>
                            <li>
                                <button type="button" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" id="users-menu-button" aria-expanded="false" data-dropdown-toggle="users-dropdown" data-dropdown-placement="bottom">
                                    Users
                                </button>
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="users-dropdown">
                                    <ul class="py-2" aria-labelledby="users-menu-button">
                                        <li>
                                            <a href="index.php?module=user&action=manageUser" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Manage Users</a>
                                        </li>
                                        <li>
                                            <a href="index.php?module=user&action=addUser" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Add Users</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <button type="button" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" id="client-menu-button" aria-expanded="false" data-dropdown-toggle="client-dropdown" data-dropdown-placement="bottom">
                                    Clients
                                </button>
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="client-dropdown">
                                    <ul class="py-2" aria-labelledby="client-menu-button">
                                        <li>
                                            <a href="index.php?module=client&action=manageClient" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Manage Clients</a>
                                        </li>
                                        <li>
                                            <a href="index.php?module=client&action=addClient" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Add Clients</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                            <li>
                                <button type="button" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700" id="project-menu-button" aria-expanded="false" data-dropdown-toggle="project-dropdown" data-dropdown-placement="bottom">
                                    Projects
                                </button>
                                <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600" id="project-dropdown">
                                    <ul class="py-2" aria-labelledby="project-menu-button">
                                        <li>
                                            <a href="index.php?module=project&action=manageProject" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Manage Projects</a>
                                        </li>
                                        <li>
                                            <a href="index.php?module=project&action=addProject" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Add Projects</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

<?php
    }
}
