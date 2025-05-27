<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core;

class ClientView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function manageClient()
    {
        echo "Manage Client Page";
    }

    public function showClientForm($clientToEdit = null)
    {
        $title = ($clientToEdit === null) ? 'Add Client | Ticket Pro +' : 'Edit Client | Ticket Pro +';
        $heading = ($clientToEdit === null) ? 'Add a client' : 'Edit Client';
        $action = ($clientToEdit === null) ? 'index.php?module=client&action=addClient' : 'index.php?module=client&action=updateClient';
        $firstnameValue = htmlspecialchars($clientToEdit['firstname'] ?? '');
        $lastnameValue = htmlspecialchars($clientToEdit['lastname'] ?? '');
?>
        <title><?= $title ?></title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" action="<?= $action ?>" method="POST">
                    <h2 class="text-4xl font-extrabold dark:text-white mb-6"><?= $heading ?></h2>
                    <?php if ($clientToEdit !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($clientToEdit['id']) ?>">
                    <?php endif; ?>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="firstname" id="firstname"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $firstnameValue ?>" required />
                        <label for="firstname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="lastname" id="lastname"
                            class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $lastnameValue ?>" required />
                        <label for="lastname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <?= ($clientToEdit === null) ? 'Submit' : 'Save Changes' ?>
                    </button>
                </form>
            </div>
        </div>
<?php
    }



}
?>