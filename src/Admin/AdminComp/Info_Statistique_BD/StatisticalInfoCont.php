<?php

require_once "StatisticalInfoView.php";
require_once "StatisticalInfoModel.php";
require_once("./Common/CommonLib/Error404.php");

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

class StatisticalInfoCont extends GenericController
{

    public function __construct()
    {
        $this->view = new StatisticalInfoView();
        $this->model = new StatisticalInfoModel();
    }

    public function exec()
    {
        $statUseur = $this->recuperationStatistiqueUseur();
        $this->dsplayStatisticalInfo($statUseur);
    }

    public function dsplayStatisticalInfo($statUseur)
    {
        $this->view->dsplayStatisticalInfo($statUseur);
    }

    public function recuperationStatistiqueUseur()
    {
        return $this->model->recuperationStatistiqueUseur();
    }
}