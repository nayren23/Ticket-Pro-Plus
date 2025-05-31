<?php

namespace TicketProPlus\App\Modules\Login;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();
class LoginView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    /**
     * Fonction pour afficher le foirmulaire de connexion
     */
    public function loginForm()
    {
?>
        <title>Login | Ticket Pro +</title>
        <?php
        if (!isset($_SESSION["login"])) {
        ?>
            <div class="min-h-screen  flex items-center justify-center">
                <div class="p-8 rounded-md shadow-md w-full max-w-md">
                    <form class="max-w-sm mx-auto" action="index.php?module=login&action=authenticate" method="POST">

                        <p class="text-lg font-medium text-gray-900 dark:text-white">Please Enter your Account details</p>
                        <br>

                        <div class="mb-5">
                            <label for="login" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                Login</label>
                            <input type="text" id="login" name="login"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="John" required />
                        </div>
                        <div class="mb-5">
                            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Your
                                password</label>
                            <input type="password" id="password" name="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                required />
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </form>
                </div>
            </div>
<?php
        }
    }
}
?>