<?php

namespace TicketProPlus\App\Modules\Search;

use TicketProPlus\App\Core;

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die();


class SearchView extends Core\GenericView
{

    public function  __construct()
    {
        parent::__construct();
    }

    public function renderSearchResults(array $results, string $searchTerm)
    {
?>
        <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-4 text-center mb-12">
            Search results for "<span class="font-bold text-blue-600 dark:text-blue-500"><?php echo htmlspecialchars($searchTerm); ?></span>"
        </h1>
        <div class="container mx-auto mt-8">

            <?php if (empty($results)): ?>
                <div class="p-4 mb-4 text-sm text-gray-800 rounded-lg bg-gray-50 dark:bg-gray-800 dark:text-gray-300" role="alert">
                    <span class="font-medium">No results found.</span> Please try another search term.
                </div>
            <?php else: ?>
                <?php if (isset($results['clients'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Clients</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (empty($results['clients'])): ?>
                                <li class="py-3 text-gray-700 dark:text-gray-400">No customers found for this term.</li>
                            <?php else: ?>
                                <?php foreach ($results['clients'] as $client): ?>
                                    <li class="py-3">
                                        <a href="index.php?module=client&action=viewClient&id=<?php echo $client['c_id']; ?>" class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    <?php echo htmlspecialchars($client['c_firstname'] . ' ' . $client['c_lastname']); ?>
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    <?php echo htmlspecialchars($client['c_email']); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($results['logins'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Users (Logins)</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (empty($results['logins'])): ?>
                                <li class="py-3 text-gray-700 dark:text-gray-400">No users found for this term.</li>
                            <?php else: ?>
                                <?php foreach ($results['logins'] as $login): ?>
                                    <a href="index.php?module=user&action=viewUser&id=<?php echo $login['u_id']; ?>" class="flex items-center space-x-4">
                                        <li class="py-3">
                                            <div class="flex items-center space-x-4">
                                                <div class="flex-shrink-0">
                                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                                    </svg>
                                                </div>
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        <?php echo htmlspecialchars($login['u_login']); ?>
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        <?php echo htmlspecialchars($login['u_email']); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </li>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($results['projets'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Projects</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (empty($results['projets'])): ?>
                                <li class="py-3 text-gray-700 dark:text-gray-400">No projects found for this term.</li>
                            <?php else: ?>
                                <?php foreach ($results['projets'] as $projet): ?>
                                    <li class="py-3">
                                        <a href="index.php?module=project&action=showProjectDetails&projectId=<?php echo $projet['p_id']; ?>" class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M2 5a2 2 0 012-2h8a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm9.027 4.61a3 3 0 11-6.054 0 3 3 0 016.054 0zM12 13a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    <?php echo htmlspecialchars($projet['p_name']); ?>
                                                </p>
                                                <?php if (!empty($projet['p_description'])): ?>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        <?php echo htmlspecialchars($projet['p_description']); ?>
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($results['tickets'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Tickets</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (empty($results['tickets'])): ?>
                                <li class="py-3 text-gray-700 dark:text-gray-400">No tickets found for this term.</li>
                            <?php else: ?>
                                <?php foreach ($results['tickets'] as $ticket): ?>
                                    <li class="py-3">
                                        <a href="index.php?module=ticket&action=viewTicket&id=<?php echo $ticket['t_id']; ?>" class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h8a2 2 0 012 2v12a1 1 0 110 2h-3a1 1 0 01-1-1v-2a1 1 0 00-1-1H9a1 1 0 00-1 1v2a1 1 0 01-1 1H4a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    <?php echo htmlspecialchars(substr($ticket['t_description'], 0, 50)); ?>
                                                    <?php if (strlen($ticket['t_description']) > 50): ?>...<?php endif; ?>
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    N° <?php echo htmlspecialchars($ticket['t_id']); ?> - Client: <?php echo htmlspecialchars($ticket['c_firstname'] . ' ' . $ticket['c_lastname']); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <?php if (isset($results['users'])): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Users</h2>
                        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                            <?php if (empty($results['users'])): ?>
                                <li class="py-3 text-gray-700 dark:text-gray-400">No users found for this term.</li>
                            <?php else: ?>
                                <?php foreach ($results['users'] as $user): ?>
                                    <li class="py-3">
                                        <a href="index.php?module=user&action=viewUser&id=<?php echo $user['u_id']; ?>" class="flex items-center space-x-4">
                                            <div class="flex-shrink-0">
                                                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                    <?php echo htmlspecialchars($user['u_firstname'] . ' ' . $user['u_lastname']); ?>
                                                </p>
                                                <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                    (<?php echo htmlspecialchars($user['u_login']); ?>) - <?php echo htmlspecialchars($user['u_email']); ?>
                                                </p>
                                            </div>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
<?php
    }
}
