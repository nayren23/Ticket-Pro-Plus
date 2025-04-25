<?php

require_once "./Common/GenericClass/GenericView.php";
require_once("./Common/CommonLib/Error404.php");

if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404Admin());

class StatisticalInfoView extends GenericView
{
    public function  __construct()
    {
        parent::__construct();
    }

    function dsplayStatisticalInfo($statUseur)
    {
?>
<div class="container">

    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pattern">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-th text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1"><?php echo $statUseur[2]['userNumber'] ?></h5>
                    <p class="text-muted mb-0">Total des Utilisateurs</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pattern">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-th text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1"><?php echo $statUseur[0]['userNumber'] ?></h5>
                    <p class="text-muted mb-0">Total des Professeurs</p>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card bg-pattern">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-th text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1"><?php echo $statUseur[1]['userNumber'] ?></h5>
                    <p class="text-muted mb-0">Total des Administrateurs</p>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-pattern">
                <div class="card-body">
                    <div class="float-right">
                        <i class="fa fa-th text-primary h4 ml-3"></i>
                    </div>
                    <h5 class="font-size-20 mt-0 pt-1"><?php echo $statUseur[3]['userNumber'] ?></h5>
                    <p class="text-muted mb-0">Total des Fiches</p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    }
}
?>