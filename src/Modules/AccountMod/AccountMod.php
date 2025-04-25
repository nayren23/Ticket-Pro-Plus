<?php
/*src/modules/AccountMod/AccountMod.php*/
/*mod = module*/

require_once "AccountCont.php";
require_once("./Common/CommonLib/Error404.php");
if (constant("APP_SECRET") != $_ENV["APP_SECRET"])
    die(showError404());

class AccountMod
{

    private $Controller;
    public function __construct()
    {
        $this->Controller = new AccountCont();
        $this->Controller->exec();
    }

    public function getController()
    {
        return $this->Controller;
    }
}
