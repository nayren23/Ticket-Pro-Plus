<?php

namespace TicketProPlus\App\Modules\Admin;

use TicketProPlus\App\Core;

class AdminCont extends Core\GenericController
{
    public function __construct()
    {
        $this->model = new AdminModel();
        $this->view = new AdminView();
    }

    public function stats()
    {
        $developerTickets = $this->model->getTicketCountsByDeveloper();
        $totalTicketStat = $this->model->getTotalTicketCounts();
        $averageResolutionTime = $this->model->getAverageResolutionTime();
        $periodCountsArray = [
            [
                'period' => 'today',
                'data' => $this->model->getTicketCountsByPeriod('today'),
                'displayText' => 'Today',
            ],
            [
                'period' => 'week',
                'data' => $this->model->getTicketCountsByPeriod('week'),
                'displayText' => 'This week',
            ],
            [
                'period' => 'month',
                'data' => $this->model->getTicketCountsByPeriod('month'),
                'displayText' => 'This month',
            ],
            [
                'period' => 'year',
                'data' => $this->model->getTicketCountsByPeriod('year'),
                'displayText' => 'This year',
            ],
        ];

        $this->view->renderStatisticsDashboard($developerTickets, $totalTicketStat, $averageResolutionTime, $periodCountsArray);
    }
}
