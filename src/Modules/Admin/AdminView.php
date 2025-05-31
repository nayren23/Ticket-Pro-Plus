<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core;

class AdminView extends Core\GenericView
{

    public function __construct()
    {
        parent::__construct();
    }

    public function search()
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
                        placeholder="Search ...">
                </div>
            </div>


        <?php
        $this->renderSearchForm();
    }

    public function renderStatisticsDashboard($developerTickets, $totalTicketStat, $averageResolutionTime, $periodCountsArray)
    {
        ?>
            <div class="w-full bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <h2 class="text-center w-full text-4xl font-extrabold dark:text-white mb-6"> Statistics </h2>
                <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                    <?php $this->displayOverallTicketStatistics($totalTicketStat, $averageResolutionTime) ?>
                    <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-2 dark:text-white sm:p-8">
                        <div class="flex flex-col items-center justify-center">
                            <?php $this->createDeveloperPieChart($developerTickets); ?>
                        </div>
                        <div class="flex flex-col items-center justify-center">
                            <?php $this->createRicketCountsByPeriod($periodCountsArray); ?>
                        </div>
                    </dl>
                </div>
            </div>
        <?php
    }

    private function displayOverallTicketStatistics($totalTicketStat, $averageResolutionTime)
    {
        ?>
            <div class="p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800">
                <dl class="grid max-w-screen-xl grid-cols-2 gap-8 p-4 mx-auto text-gray-900 sm:grid-cols-3 xl:grid-cols-6 dark:text-white sm:p-8">
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $totalTicketStat["created_count"] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Number of new tickets created</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $totalTicketStat["in_progress_count"] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Number of tickets in progress</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $totalTicketStat["resolved_count"] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Number of tickets resolved</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $totalTicketStat["closed"] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Number of tickets closed</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $totalTicketStat["total_count"] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400">Number of tickets in total</dd>
                    </div>
                    <div class="flex flex-col items-center justify-center">
                        <dt class="mb-2 text-3xl font-extrabold"><?= $averageResolutionTime[0] . " " . $averageResolutionTime[1] ?></dt>
                        <dd class="text-gray-500 dark:text-gray-400"> Average ticket resolution time</dd>
                    </div>
                </dl>
            </div>
        <?php
    }

    private function createDeveloperPieChart($developerTickets)
    {
        ?>

            <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between items-start w-full">
                    <div class="flex-col items-center">
                        <div class="flex items-center mb-1">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white me-1">
                                Ticket distribution by Developer</h5>
                        </div>
                    </div>
                </div>
                <div class="py-6" id="developer-pie-chart"></div>
            </div>

            <script>
                const developerTicketsData = <?= json_encode($developerTickets) ?>;

                const getDeveloperPieChartOptions = () => {
                    const labels = developerTicketsData.map(item => item.developer);
                    const seriesData = developerTicketsData.map(item => item.ticket_count);
                    const colors = ['#1C64F2', '#16BDCA', '#9061F9', '#FDBA8C', '#3B82F6', '#8B5CF6', '#10B981', '#EF4444']; // Ajoutez plus de couleurs si nécessaire

                    return {
                        series: seriesData,
                        colors: colors,
                        chart: {
                            height: 420,
                            width: "100%",
                            type: "pie",
                        },
                        stroke: {
                            colors: ["white"],
                            lineCap: "",
                        },
                        plotOptions: {
                            pie: {
                                labels: {
                                    show: true,
                                },
                                size: "100%",
                                dataLabels: {
                                    offset: -25
                                }
                            },
                        },
                        labels: labels,
                        dataLabels: {
                            enabled: true,
                            style: {
                                fontFamily: "Inter, sans-serif",
                            },
                        },
                        legend: {
                            position: "bottom",
                            fontFamily: "Inter, sans-serif",
                        },
                        yaxis: {
                            labels: {
                                formatter: function(value) {
                                    return value
                                },
                            },
                        },
                        xaxis: {
                            labels: {
                                formatter: function(value) {
                                    return value
                                },
                            },
                            axisTicks: {
                                show: false,
                            },
                            axisBorder: {
                                show: false,
                            },
                        },
                    };
                }

                if (document.getElementById("developer-pie-chart") && typeof ApexCharts !== 'undefined') {
                    const chart = new ApexCharts(document.getElementById("developer-pie-chart"), getDeveloperPieChartOptions());
                    chart.render();
                }
            </script>
        <?php
    }


    private function createRicketCountsByPeriod($periodCountsArray)
    {
        ?>
            <div class="max-w-sm w-full bg-white rounded-lg shadow-sm dark:bg-gray-800 p-4 md:p-6">
                <div class="flex justify-between mb-3">
                    <div class="flex items-center">
                        <div class="flex justify-center items-center">
                            <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">
                                Ticket status</h5>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-gray-700 p-3 rounded-lg">
                    <div class="grid grid-cols-4 gap-3 mb-2">
                        <dl class="bg-orange-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                            <dt class="w-8 h-8 rounded-full bg-orange-100 dark:bg-gray-500 text-orange-600 dark:text-orange-300 text-sm font-medium flex items-center justify-center mb-1" id="todo-count">0</dt>
                            <dd class="text-orange-600 dark:text-orange-300 text-sm font-medium">New</dd>
                        </dl>
                        <dl class="bg-teal-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                            <dt class="w-8 h-8 rounded-full bg-teal-100 dark:bg-gray-500 text-teal-600 dark:text-teal-300 text-sm font-medium flex items-center justify-center mb-1" id="inprogress-count">0</dt>
                            <dd class="text-teal-600 dark:text-teal-300 text-sm font-medium">InProgress</dd>
                        </dl>
                        <dl class="bg-blue-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                            <dt class="w-8 h-8 rounded-full bg-blue-100 dark:bg-gray-500 text-blue-600 dark:text-blue-300 text-sm font-medium flex items-center justify-center mb-1" id="done-count">0</dt>
                            <dd class="text-blue-600 dark:text-blue-300 text-sm font-medium">Resolved</dd>
                        </dl>
                        <dl class="bg-purple-50 dark:bg-gray-600 rounded-lg flex flex-col items-center justify-center h-[78px]">
                            <dt class="w-8 h-8 rounded-full bg-purple-100 dark:bg-gray-500 text-purple-600 dark:text-purple-300 text-sm font-medium flex items-center justify-center mb-1" id="closed-count">0</dt>
                            <dd class="text-purple-600 dark:text-purple-300 text-sm font-medium">Closed</dd>
                        </dl>
                    </div>
                </div>

                <div class="py-6" id="radial-chart"></div>

                <div class="grid grid-cols-1 items-center border-gray-200 border-t dark:border-gray-700 justify-between">
                    <div class="flex justify-between items-center pt-5">
                        <button
                            id="dropdownPeriodButton"
                            data-dropdown-toggle="lastDaysdropdown"
                            data-dropdown-placement="bottom"
                            class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 text-center inline-flex items-center dark:hover:text-white"
                            type="button">
                            Today
                            <svg class="w-2.5 m-2.5 ms-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <div id="lastDaysdropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownPeriodButton">
                                <?php foreach ($periodCountsArray as $periodInfo): ?>
                                    <li>
                                        <a href="#" data-period="<?= $periodInfo['period'] ?>" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"><?= $periodInfo['displayText'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>

            <script>
                const periodCountsData = <?= json_encode(array_column($periodCountsArray, 'data', 'period')) ?>;
                const periodDisplayText = <?= json_encode(array_column($periodCountsArray, 'displayText', 'period')) ?>;

                let currentPeriod = 'today';

                const updateRadialChart = (period) => {
                    currentPeriod = period;
                    const data = periodCountsData[period] || {
                        created_count: 0,
                        in_progress_count: 0,
                        resolved_count: 0,
                        closed_count: 0
                    };

                    // Mettre à jour les compteurs statiques
                    document.getElementById('todo-count').textContent = data.created_count; // On utilise 'created_count' pour 'To do'
                    document.getElementById('inprogress-count').textContent = data.in_progress_count;
                    document.getElementById('done-count').textContent = data.resolved_count;
                    document.getElementById('closed-count').textContent = data.closed_count;

                    const chartOptions = {
                        series: [
                            data.resolved_count, // Done
                            data.in_progress_count, // In progress
                            data.created_count, // To do
                            data.closed_count,
                        ],
                        colors: ["#1C64F2", "#16BDCA", "#FDBA8C", "#dab2ff"],
                        chart: {
                            height: "350px",
                            width: "100%",
                            type: "radialBar",
                            sparkline: {
                                enabled: true,
                            },
                        },
                        plotOptions: {
                            radialBar: {
                                track: {
                                    background: '#E5E7EB',
                                },
                                dataLabels: {
                                    show: false,
                                },
                                hollow: {
                                    margin: 0,
                                    size: "32%",
                                }
                            },
                        },
                        grid: {
                            show: false,
                            strokeDashArray: 4,
                            padding: {
                                left: 2,
                                right: 2,
                                top: -23,
                                bottom: -20,
                            },
                        },
                        labels: ["Resolved", "In Progress", "New", "Closed"],
                        legend: {
                            show: true,
                            position: "bottom",
                            fontFamily: "Inter, sans-serif",
                        },
                        tooltip: {
                            enabled: true,
                            y: {
                                formatter: function(val) {
                                    return val
                                }
                            }
                        },
                        yaxis: {
                            show: false,
                            labels: {
                                formatter: function(value) {
                                    return value
                                }
                            }
                        }
                    };

                    const radialChartElement = document.querySelector("#radial-chart");
                    if (radialChartElement && typeof ApexCharts !== 'undefined') {
                        // Détruire l'ancien graphique avant d'en créer un nouveau
                        if (radialChartElement.apexChart) {
                            radialChartElement.apexChart.destroy();
                        }
                        const chart = new ApexCharts(radialChartElement, chartOptions);
                        chart.render();
                        radialChartElement.apexChart = chart; // Sauvegarder l'instance du graphique
                    }
                };

                // Initialisation du graphique pour la période par défaut
                updateRadialChart(currentPeriod);

                // Gestion du changement de période via le dropdown
                const periodLinks = document.querySelectorAll('#lastDaysdropdown a');
                const dropdownButton = document.getElementById('dropdownPeriodButton');

                periodLinks.forEach(link => {
                    link.addEventListener('click', (event) => {
                        event.preventDefault();
                        const period = link.getAttribute('data-period');
                        dropdownButton.textContent = periodDisplayText[period] + ' ';
                        const svgIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                        svgIcon.setAttribute('class', 'w-2.5 m-2.5 ms-1.5');
                        svgIcon.setAttribute('aria-hidden', 'true');
                        svgIcon.setAttribute('fill', 'none');
                        svgIcon.setAttribute('viewBox', '0 0 10 6');
                        const pathIcon = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                        pathIcon.setAttribute('stroke', 'currentColor');
                        pathIcon.setAttribute('stroke-linecap', 'round');
                        pathIcon.setAttribute('stroke-linejoin', 'round');
                        pathIcon.setAttribute('stroke-width', '2');
                        pathIcon.setAttribute('d', 'm1 1 4 4 4-4');
                        svgIcon.appendChild(pathIcon);
                        dropdownButton.appendChild(svgIcon);

                        updateRadialChart(period);
                        document.getElementById('lastDaysdropdown').classList.add('hidden'); // Fermer le dropdown
                    });
                });

                // Initialisation du texte du bouton avec la période par défaut
                dropdownButton.textContent = periodDisplayText[currentPeriod] + ' ';
                const initialSvgIcon = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
                initialSvgIcon.setAttribute('class', 'w-2.5 m-2.5 ms-1.5');
                initialSvgIcon.setAttribute('aria-hidden', 'true');
                initialSvgIcon.setAttribute('fill', 'none');
                initialSvgIcon.setAttribute('viewBox', '0 0 10 6');
                const initialPathIcon = document.createElementNS('http://www.w3.org/2000/svg', 'path');
                initialPathIcon.setAttribute('stroke', 'currentColor');
                initialPathIcon.setAttribute('stroke-linecap', 'round');
                initialPathIcon.setAttribute('stroke-linejoin', 'round');
                initialPathIcon.setAttribute('stroke-width', '2');
                initialPathIcon.setAttribute('d', 'm1 1 4 4 4-4');
                initialSvgIcon.appendChild(initialPathIcon);
                dropdownButton.appendChild(initialSvgIcon);
            </script>
        <?php
    }

    ///////////////////

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
                                            <a href="/admin/tickets/view/<?php echo $ticket['t_id']; ?>" class="flex items-center space-x-4">
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

    public function renderSearchForm()
    {
        ?>
            <h1>Global Search</h1>
            <form action="index.php?module=admin&action=search" method="get">
                <input type="text" name="query" placeholder="Search..." required>
                <button type="submit">Search</button>
            </form>
    <?php
    }
}
