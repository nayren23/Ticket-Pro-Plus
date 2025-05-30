<?php

namespace TicketProPlus\App\Modules\Ticket;

use TicketProPlus\App\Core;

class TicketView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }


    /**
     * Affiche le formulaire pour ajouter ou modifier un ticket.
     * 
     * @param array $ticketToEdit le ticket à modifier, null si c'est un ajout.
     * @param array $clients la liste des clients pour le champ de formulaire associé.
     * @param array $projects la liste des projets pour le champ de formulaire associé.
     * 
     * @return void
     */
    public function showTicketForm($ticketToEdit = null, $clients, $projects, $developers)
    {
        $title = ($ticketToEdit === null) ? 'Add Ticket | Ticket Pro +' : 'Edit Ticket | Ticket Pro +';
        $heading = ($ticketToEdit === null) ? 'Add a ticket' : 'Edit Ticket';
        $action = ($ticketToEdit === null) ? 'index.php?module=ticket&action=addTicket' : 'index.php?module=ticket&action=updateTicket';

        $descriptionValue = htmlspecialchars($ticketToEdit['t_description'] ?? '');
        $dueDateValue = htmlspecialchars($ticketToEdit['t_due_date'] ?? '');
        if ($dueDateValue) {
            $dateObj = \DateTime::createFromFormat('Y-m-d H:i:s', $dueDateValue);
            if ($dateObj) {
                $dueDateValue = $dateObj->format('m/d/Y');
            }
        }
        $clientId = htmlspecialchars($ticketToEdit['c_id'] ?? '');
        $projectId = htmlspecialchars($ticketToEdit['p_id'] ?? '');
        $statusValue = htmlspecialchars($ticketToEdit['s_id'] ?? '');
        $priorityValue = htmlspecialchars($ticketToEdit['pty_id'] ?? ''); 
        $developerId = htmlspecialchars($ticketToEdit['u_id'] ?? '');

?>
        <title> <?= $title ?> </title>
        <div class="mt-6">
            <div class="contenir">
                <form class="max-w-md mx-auto" action="<?= $action ?>" method="POST" enctype="multipart/form-data">
                    <h2 class="text-4xl font-extrabold text-white dark:text-white mb-6"><?= $heading ?></h2>

                    <?php if ($ticketToEdit !== null): ?>
                        <input type="hidden" name="id" value="<?= htmlspecialchars($ticketToEdit['t_id']) ?>">
                    <?php endif; ?>

                    <div class="relative z-0 w-full mb-5 group">
                        <label for="description" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Description</label>
                        <textarea id="description" name="description" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Leave a description of the ticket" required><?= $descriptionValue ?></textarea>
                    </div>
                    

                    <div class="max-w-md mx-auto mb-5">
                        <div class="relative max-w-md mx-auto mb-5 text-sm font-medium text-gray-500 dark:text-gray-400">
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

                    
                    <div class="max-w-md mx-auto mb-5 mt-5">
                        <label for="clientId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Associate a client</label>
                        <select id="clientId" name="clientId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">No client associated</option>
                            <?php if ($clients !== null): ?>
                                <?php foreach ($clients as $client): ?>
                                    <option value="<?= htmlspecialchars($client['c_id']) ?>" <?= ($clientId == $client['c_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($client['c_firstname'] . ' ' . $client['c_lastname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="max-w-md mx-auto mb-5">
                       <label for="projectId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Associate a project</label>
                       <select id="projectId" name="projectId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                           <?php if ($projects !== null): ?>
                               <?php foreach ($projects as $project): ?>
                                   <option value="<?= htmlspecialchars($project['p_id']) ?>" <?= ($projectId == $project['p_id']) ? 'selected' : '' ?>>
                                       <?= htmlspecialchars($project['p_name']) ?>
                                   </option>
                               <?php endforeach; ?>
                           <?php endif; ?>
                       </select>
                    </div>

                    <div class="max-w-md mx-auto mb-5">
                        <label for="developerId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Assign developer</label>
                        <select id="developerId" name="developerId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="">No developer assigned</option>
                            <?php if ($developers !== null): ?>
                                <?php foreach ($developers as $dev): ?>
                                    <option value="<?= htmlspecialchars($dev['u_id']) ?>" <?= (isset($developerId) && $developerId == $dev['u_id']) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($dev['u_firstname'] . ' ' . $dev['u_lastname']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="max-w-md mx-auto mb-5">
                        <label for="statusId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Status</label>
                        <select id="statusId" name="statusId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1" <?= ($statusValue == 1) ? 'selected' : '' ?>>New</option>
                            <option value="2" <?= ($statusValue == 2) ? 'selected' : '' ?>>In Progress</option>
                            <option value="3" <?= ($statusValue == 3) ? 'selected' : '' ?>>Resolved</option>
                            <option value="4" <?= ($statusValue == 4) ? 'selected' : '' ?>>Closed</option>
                        </select>
                    </div>

                    <div class="max-w-md mx-auto mb-5">
                        <label for="priorityId" class="block mb-2 text-sm font-medium text-gray-500 dark:text-gray-400">Priority</label>
                        <select id="priorityId" name="priorityId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="1" <?= ($priorityValue == 1) ? 'selected' : '' ?>>Low</option>
                            <option value="2" <?= ($priorityValue == 2) ? 'selected' : '' ?>>Medium</option>
                            <option value="3" <?= ($priorityValue == 3) ? 'selected' : '' ?>>High</option>
                            <option value="4" <?= ($priorityValue == 4) ? 'selected' : '' ?>>Critical</option>
                        </select>
                    </div>


                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        <?= ($ticketToEdit === null) ? 'Submit' : 'Save Changes' ?>
                    </button>
                </form>
            </div>
        </div>
    <?php
    }

    public function manageTicket($tickets, $currentPage, $totalPages, $totalTickets)
    {
    ?>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div
                class="flex items-center justify-between flex-column md:flex-row flex-wrap space-y-4 md:space-y-0 py-4 bg-white dark:bg-gray-900">
                <div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" id="table-search-tickets"
                        class="block pt-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search for tickets">
                </div>
            </div>
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Ticket ID
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Creation Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Due Date
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Last Update
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Priority
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Assigned Developer
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Associated Project
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Assigned Client
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
                    foreach ($tickets as $ticket) {
                    ?>
                        <tr
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">

                            <td class="px-6 py-4">
                                <?= $ticket["t_id"] ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= date('Y-m-d H:i:s', strtotime($ticket["t_creation"])) ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= date('Y-m-d H:i:s', strtotime($ticket["t_due_date"])) ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= date('Y-m-d H:i:s', strtotime($ticket["t_timestamp_modification"])) ?>
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center">
                                    <?php
                                        $priorityColors = [
                                            1 => 'bg-green-500',   // Low
                                            2 => 'bg-yellow-400',  // Medium
                                            3 => 'bg-orange-500',  // High
                                            4 => 'bg-red-600',     // Critical
                                        ];
                                        $color = $priorityColors[$ticket['pty_id']];
                                    ?>
                                    <div class="h-2.5 w-2.5 rounded-full <?= $color ?> me-2"></div>
                                </div>
                            </td>

                            <td class="px-6 py-4">
                                <?= $ticket["s_name"] ?>
                            </td>

                            <td class="px-6 py-4">
                                <?php
                                    $devName = trim(($ticket["u_firstname"] ?? '') . ' ' . ($ticket["u_lastname"] ?? ''));
                                    echo $devName !== '' ? htmlspecialchars($devName) : 'No Assigned Developer';
                                ?>
                            </td>

                            <td class="px-6 py-4">
                                <?= $ticket["p_name"] ?>
                            </td>

                            <td class="px-6 py-4">
                                <?php
                                    $clientName = trim(($ticket["c_firstname"] ?? '') . ' ' . ($ticket["c_lastname"] ?? ''));
                                    echo $clientName !== '' ? htmlspecialchars($clientName) : 'No Assigned Client';
                                ?>
                            </td>

                            <td class="px-6 py-4">
                                <div>
                                    <a href="?module=ticket&action=showEditTicketForm&id=<?= htmlspecialchars($ticket['t_id']); ?>"
                                        type="button"
                                        data-modal-target="editTicketModal"
                                        data-modal-show="editTicketModal"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2">Edit Ticket</a>
                                </div>
                                <div>
                                    <a data-ticket-id="<?= htmlspecialchars($ticket['t_id']); ?>" data-modal-target="popup-modal" data-modal-toggle="popup-modal" class="font-medium text-red-600 dark:text-red-500 hover:underline" type="button">
                                    Delete Ticket
                                    </a>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div>
                                    <a href="#" 
                                       class="font-medium text-blue-600 dark:text-blue-500 hover:underline block mb-2 view-description-btn"
                                       data-description="<?= htmlspecialchars($ticket['t_description']) ?>">
                                       View description
                                    </a>
                                </div>
                                <div>
                                    <a href="?module=ticket&action=viewUpdates&ticketId=<?= htmlspecialchars($ticket['t_id']); ?>"
                                        class="font-medium text-green-600 dark:text-blue-500 hover:underline block mb-2">
                                        View updates
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
                    Showing <span class="font-semibold text-gray-900 dark:text-white"><?= count($tickets) ?></span> of <span class="font-semibold text-gray-900 dark:text-white"><?= $totalTickets ?></span>
                </span>
                <ul class="inline-flex -space-x-px text-sm">
                    <li>
                        <a href="?module=ticket&action=manageTicket&page=<?= max(1, $currentPage - 1) ?>" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                    </li>
                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                        <li>
                            <a href="?module=ticket&action=manageTicket&page=<?= $i ?>" class="<?= $i === $currentPage ? 'bg-blue-500 text-white' : 'bg-white text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white' ?> flex items-center justify-center px-3 h-8 leading-tight border border-gray-300 dark:border-gray-700"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                    <li>
                        <a href="?module=ticket&action=manageTicket&page=<?= min($totalPages, $currentPage + 1) ?>" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
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
                            <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this ticket ?</h3>
                            <button data-ticket-id="<?php echo htmlspecialchars($ticket['t_id']); ?>" data-modal-hide="popup-modal" type="button" class="delete-ticket-link text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                Yes, I'm sure
                            </button>
                            <button data-modal-hide="popup-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div id="description-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center backdrop-blur-sm">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6 max-w-lg w-full">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 dark:text-gray-100">Ticket Description</h3>
                    <div id="description-modal-content" class="mb-4 text-gray-700 dark:text-gray-200"></div>
                    <button id="close-description-modal" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Close</button>
                </div>
            </div>
        </div>


    <?php
    }

}
?>
