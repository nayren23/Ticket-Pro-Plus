<?php

namespace TicketProPlus\App\Modules\Project;

use TicketProPlus\App\Core;

class ProjectView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function manageProject()
    {
        echo "ça marche";
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
                            class="block py-2.5 px-0 w-full text-sm text-white bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                            placeholder=" " value="<?= $nameValue ?>" required/>
                        <label for="name"
                            class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Name</label>
                    </div>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Leave a description of the project"><?= $descriptionValue ?></textarea>
                    </div>
                    

                    <div class="flex items-end gap-4 mb-5">
                        <div class="relative max-w-xs w-2/3 text-sm font-medium text-gray-500 dark:text-gray-400">
                            <label class="block mb-1">Due date</label>
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400 mt-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="datepicker-autohide" datepicker datepicker-autohide type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date" value="<?= $dueDateValue ?>" name="due_date" required>
                        </div>

                        <label class="inline-flex items-center mb-2 cursor-pointer w-auto flex justify-end">
                            <span class="ms-3 text-sm font-medium text-gray-500 dark:text-gray-400 ml-10 mr-1">Close the project ?</span>
                            <input type="checkbox" name="closed" value="1" class="sr-only peer"
                                <?= ($closedValue === 1) ? 'checked' : '' ?>>
                            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                        </label>
                    </div>

                    <div class="max-w-md mx-auto mb-5">
                        <label for="clientId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Associate a client</label>
                        <select id="clientId" name="clientId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <?php foreach ($clients as $client): ?>
                                    <option value="<?= htmlspecialchars($client['c_id']) ?>" <?= ($clientId == $client['c_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($client['c_firstname'] . ' ' . $client['c_lastname']) ?>
                                    </option>
                            <?php endforeach; ?>
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

}
?>