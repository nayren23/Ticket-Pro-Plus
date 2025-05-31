<?php

namespace TicketProPlus\App\Modules\Client;

use TicketProPlus\App\Core;

class ClientView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche la page de gestion des clients
     *
     * @param array $clients Un tableau contenant les informations des clients
     * @param int $currentPage La page actuellement affichée
     * @param int $totalPages Le nombre total de pages
     * @param int $totalClients Le nombre total de clients
     *
     * @return void
     */
    public function manageClient($clients, $currentPage, $totalPages, $totalClients)
    {
?>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($clients as $client) {
                    ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <img class="w-10 h-10 rounded-full" src="public/assets/images/uploads/user.png" alt="Image">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">
                                        <?= $client["c_firstname"] . " " . $client["c_lastname"]  ?>
                                    </div>
                                </div>
                            </th>

                            <td class="px-6 py-4">
                                <div class="text-base font-semibold">
                                    <?= $client["c_email"] ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=client&action=showEditClientForm&id=<?= htmlspecialchars($client['c_id']); ?>"
                                        type="button"
                                        data-modal-target="editClientModal"
                                        data-modal-show="editClientModal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">Edit client</a>
                                </div>
                                <div>
                                    <a data-client-id="<?= htmlspecialchars($client['c_id']); ?>" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                                        Delete client
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=project&action=manageProject&clientId=<?= htmlspecialchars($client['c_id']); ?>"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">
                                        View projects
                                    </a>
                                </div>
                                <div>
                                    <a href="?module=client&action=addProject&clientId=<?= htmlspecialchars($client['c_id']); ?>"
                                        class="font-medium text-green-600 dark:text-blue-500 hover:underline block mb-2">
                                        Add project
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
            <nav class="flex items-center justify-between pt-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing <span class="font-semibold text-gray-900 dark:text-white"><?= count($clients) ?></span> of <span class="font-semibold text-gray-900 dark:text-white"><?= $totalClients ?></span>
                </span>
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="?module=client&action=manageClient&page=<?= max(1, $currentPage - 1) ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li>
                            <a href="?module=client&action=manageClient&page=<?= $i ?>" class="<?= $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?> flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 dark:border-gray-700"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <a href="?module=client&action=manageClient&page=<?= min($totalPages, $currentPage + 1) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                    </li>
                </ul>
            </nav>
            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                <div class="relative p-4 w-full max-w-md max-h-full">
                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">
                        <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popup-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                        <div class="p-4 md:p-5 text-center">
                            <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this client ?</h3>
                            <button data-client-id="<?php echo htmlspecialchars($client['c_id']); ?>" data-modal-hide="popup-modal" type="button" class="delete-client-link text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <?php
    }


    /**
     * Affiche le formulaire pour ajouter ou modifier un client.
     * 
     * @param array $clientToEdit le client à modifier, null si c'est un ajout.
     * @param array $projects la liste des projets pour le champ de formulaire associé.
     * 
     * @return void
     */
    public function showClientForm($clientToEdit = null, $projects = null)
    {
        $title = ($clientToEdit === null) ? 'Add Client | Ticket Pro +' : 'Edit Client | Ticket Pro +';
        $heading = ($clientToEdit === null) ? 'Add a client' : 'Edit Client';
        $action = ($clientToEdit === null) ? 'index.php?module=client&action=addClient' : 'index.php?module=client&action=updateClient';
        $firstnameValue = htmlspecialchars($clientToEdit['c_firstname'] ?? '');
        $lastnameValue = htmlspecialchars($clientToEdit['c_lastname'] ?? '');
        $emailValue = htmlspecialchars($clientToEdit['c_email'] ?? '');
    ?>
        <title><?= $title ?></title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" action="<?= $action ?>" method="POST">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>
                    <?php if ($clientToEdit !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($clientToEdit['c_id']) ?>">
                    <?php endif; ?>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="firstname" id="firstname"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer <?= isset($projects) ? 'cursor-not-allowed' : '' ?>"
                            placeholder=" " value="<?= $firstnameValue ?>" <?= isset($projects) ? 'readonly' : '' ?> required />
                        <label for="firstname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="lastname" id="lastname"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer <?= isset($projects) ? 'cursor-not-allowed' : '' ?>"
                            placeholder=" " value="<?= $lastnameValue ?>" <?= isset($projects) ? 'readonly' : '' ?> required />
                        <label for="lastname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer <?= isset($projects) ? 'cursor-not-allowed' : '' ?>"
                            placeholder=" " value="<?= $emailValue ?>" <?= isset($projects) ? 'readonly' : '' ?> required />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                    </div>

                    <?php if (isset($projects) && is_array($projects)): ?>
                        <div class="mb-5">
                            <label for="projectSelect" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                Associate to a project
                            </label>
                            <select id="projectSelect" name="projectId"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">Choose a project</option>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?= htmlspecialchars($project['p_id']) ?>">
                                        <?= htmlspecialchars($project['p_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    <?php endif; ?>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <?= ($clientToEdit === null) ? 'Submit' : 'Save Changes' ?>
                    </button>
                </form>
            </div>
        </div>
    <?php
    }

    public function viewClient($client)
    {
        $title = 'View a client | Ticket Pro +';
        $heading = 'View a client';
        $firstnameValue = htmlspecialchars($client['c_firstname']);
        $lastnameValue = htmlspecialchars($client['c_lastname']);
        $emailValue = htmlspecialchars($client['c_email']);
    ?>
        <title><?= $title ?></title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="firstname" id="firstname"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $firstnameValue ?>" disabled required />
                        <label for="firstname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First name</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="lastname" id="lastname"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $lastnameValue ?>" disabled required />
                        <label for="lastname"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last name</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <input type="email" name="email" id="email"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $emailValue ?>" disabled required />
                        <label for="email"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                            address</label>
                    </div>

                    <td class="px-6 py-4">
                        <div>
                            <a href="?module=project&action=manageProject&clientId=<?= htmlspecialchars($client['c_id']); ?>"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">
                                View projects
                            </a>
                        </div>
                    </td>

                </form>
            </div>
        </div>
<?php
    }
}
?>