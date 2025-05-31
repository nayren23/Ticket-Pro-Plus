<?php

namespace TicketProPlus\App\Modules\Project;

use TicketProPlus\App\Core;

class ProjectView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    /**
     * Affiche la page de gestion des projets
     * 
     * @param array $projects    Les projets à afficher
     * @param int   $currentPage La page actuelle
     * @param int   $totalPages  Le nombre total de pages
     * @param int   $totalProjects    Le nombre total de projets
     */
    public function manageProject($projects, $currentPage, $totalPages, $totalProjects)
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
                            Creation Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Closed
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
                    foreach ($projects as $project) {
                    ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                <?= $project["p_name"] ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= date('Y-m-d H:i:s', strtotime($project["p_creation"])) ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= date('Y-m-d H:i:s', strtotime($project["p_due_date"])) ?>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div
                                        class="h-2.5 w-2.5 rounded-full <?= $project["p_closed"] === 1 ? "bg-green-500" : "bg-red-500"  ?> me-2">
                                    </div>
                                    <?= $project["p_closed"] === 1 ? "Yes" : "No" ?>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=project&action=showEditProjectForm&id=<?= htmlspecialchars($project['p_id']); ?>"
                                        type="button"
                                        data-modal-target="editProjectModal"
                                        data-modal-show="editProjectModal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">Edit project</a>
                                </div>
                                <div>
                                    <a data-project-id="<?= htmlspecialchars($project['p_id']); ?>" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                                        Delete project
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=project&action=showProjectDetails&projectId=<?= htmlspecialchars($project['p_id']); ?>"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">
                                        View details
                                    </a>
                                </div>
                                <div>
                                    <a href="?module=project&action=addClient&projectId=<?= htmlspecialchars($project['p_id']); ?>"
                                        class="font-medium text-green-600 dark:text-blue-500 hover:underline block mb-2">
                                        Add client
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
                    Showing <span class="font-semibold text-gray-900 dark:text-white"><?= count($projects) ?></span> of <span class="font-semibold text-gray-900 dark:text-white"><?= $totalProjects ?></span>
                </span>
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="?module=project&action=manageProject&page=<?= max(1, $currentPage - 1) ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li>
                            <a href="?module=project&action=manageProject&page=<?= $i ?>" class="<?= $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?> flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 dark:border-gray-700"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <a href="?module=project&action=manageProject&page=<?= min($totalPages, $currentPage + 1) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
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
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this project ?</h3>
                            <button data-project-id="<?php echo htmlspecialchars($project['p_id']); ?>" data-modal-hide="popup-modal" type="button" class="delete-project-link text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
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
     * Affiche le formulaire pour ajouter ou modifier un projet.
     * 
     * @param array $projectToEdit le projet à modifier, null si c'est un ajout.
     * @param array $clients la liste des clients pour le champ de formulaire associé.
     * 
     * @return void
     */
    public function showProjectForm($projectToEdit = null, $clients)
    {
        $title = ($projectToEdit === null) ? 'Add Project | Ticket Pro +' : 'Edit Project | Ticket Pro +';
        $heading = ($projectToEdit === null) ? 'Add a project' : 'Edit Project';
        $action = ($projectToEdit === null) ? 'index.php?module=project&action=addProject' : 'index.php?module=project&action=updateProject';
        $nameValue = htmlspecialchars($projectToEdit['p_name'] ?? '');
        $descriptionValue = htmlspecialchars($projectToEdit['p_description'] ?? '');
        $dueDateValue = htmlspecialchars($projectToEdit['p_due_date'] ?? '');
        if ($dueDateValue) {
            $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $dueDateValue);
            if ($dateObj) {
                $dueDateValue = $dateObj->format('m/d/Y');
            }
        }
        $closedValue = htmlspecialchars($projectToEdit['p_closed'] ?? '');
        $clientId = htmlspecialchars($projectToEdit['c_id'] ?? '');

    ?>
        <title> <?= $title ?> </title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" action="<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <?php if ($projectToEdit !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($projectToEdit['p_id']) ?>">
                    <?php endif; ?>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="name" id="name"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer <?= isset($projectToEdit) && isset($clients) ? 'cursor-not-allowed' : '' ?>"
                            placeholder=" " value="<?= $nameValue ?>" <?= isset($projectToEdit) && isset($clients) ? 'readonly' : '' ?> required />
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 <?= isset($projectToEdit) && isset($clients) ? 'cursor-not-allowed' : '' ?>"
                            placeholder="Leave a description of the project" <?= isset($projectToEdit) && isset($clients) ? 'readonly' : '' ?>><?= $descriptionValue ?></textarea>
                    </div>


                    <div class="flex items-end gap-4 mb-5">
                        <div class="relative max-w-xs w-2/3 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <label class="block mb-1">Due date</label>
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 <?= isset($projectToEdit) && isset($clients) ? 'cursor-not-allowed' : '' ?>"
                                placeholder="Select date" value="<?= $dueDateValue ?>" name="due_date" <?= isset($projectToEdit) && isset($clients) ? 'disabled' : '' ?> required>
                        </div>

                        <label class="inline-flex items-center mb-2 cursor-pointer w-auto flex justify-end">
                            <span class="ms-3 text-sm font-medium text-gray-500 dark:text-gray-400 ml-10 mr-1">Close the project ?</span>
                            <input type="checkbox" name="closed" value="1" class="sr-only peer <?= isset($projectToEdit) && isset($clients) ? 'cursor-not-allowed' : '' ?>"
                                <?= ($closedValue === "1") ? 'checked' : '' ?> <?= isset($projectToEdit) && isset($clients) ? 'disabled' : '' ?>>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600 <?= isset($projectToEdit) && isset($clients) ? 'cursor-not-allowed' : '' ?>"></div>
                        </label>
                    </div>

                    <div class="max-w-md mx-auto mb-5" <?= $clients === null ? 'hidden' : '' ?>>
                        <label for="clientId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Associate a client</label>
                        <select id="clientId" name="clientId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="<?= isset($clients) ? null : $clientId ?>">No client associated</option>
                            <?php if ($clients !== null): ?>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= htmlspecialchars($client['c_id']) ?>" <?= ($clientId == $client['c_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($client['c_firstname'] . ' ' . $client['c_lastname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <?= ($projectToEdit === null) ? 'Submit' : 'Save Changes' ?>
                    </button>
                </form>
            </div>
        </div>
    <?php
    }

    /**
     * Affiche les détails d'un projet.
     *
     * @param array $project le projet dont on veut afficher les détails.
     *
     * @return void
     */

    public function showProjectDetails($project)
    {
        $title = 'Project\'s details | Ticket Pro +';
        $heading = 'Project\'s details';
        $nameValue = htmlspecialchars($project['p_name']);
        $descriptionValue = htmlspecialchars($project['p_description'] ?? '');
        $dueDateValue = htmlspecialchars($project['p_due_date']);
        if ($dueDateValue) {
            $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $dueDateValue);
            if ($dateObj) {
                $dueDateValue = $dateObj->format('m/d/Y');
            }
        }
        $closedValue = htmlspecialchars($project['p_closed']);
        $clientFirstName = htmlspecialchars($project['c_firstname'] ?? '');
        $clientLastName = htmlspecialchars($project['c_lastname'] ?? '');

    ?>
        <title> <?= $title ?> </title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" enctype="multipart/form-data">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <div class="relative z-0 w-full mb-5 group">
                        <input type="text" name="name" id="name"
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer cursor-not-allowed"
                            placeholder=" " value="<?= $nameValue ?>" disabled>
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                            placeholder="Leave a description of the project" disabled><?= $descriptionValue ?></textarea>
                    </div>


                    <div class="flex items-end gap-4 mb-5">
                        <div class="relative max-w-xs w-2/3 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <label class="block mb-1">Due date</label>
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed"
                                placeholder="Select date" value="<?= $dueDateValue ?>" name="due_date" disabled>
                        </div>

                        <label class="inline-flex items-center mb-2 cursor-pointer w-auto flex justify-end">
                            <span class="ms-3 text-sm font-medium text-gray-500 dark:text-gray-400 ml-10 mr-1">Close the project ?</span>
                            <input type="checkbox" name="closed" value="1" class="sr-only peer cursor-not-allowed"
                                <?= ($closedValue === "1") ? 'checked' : '' ?> disabled>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600 cursor-not-allowed"></div>
                        </label>
                    </div>

                    <label for="clientId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Associate a client</label>
                    <select id="clientId" name="clientId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" disabled>
                        <option value="" selected>
                            <?= htmlspecialchars($clientFirstName . ' ' . $clientLastName) ?>
                        </option>
                    </select>

                </form>
            </div>
        </div>
<?php
    }
}
?>