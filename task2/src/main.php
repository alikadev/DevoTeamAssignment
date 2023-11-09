<?php

require_once "Workers/Worker.php";
require_once "Controllers/ControllerCLI.php";

$wrk = new Worker();
$ctrl;
if (isset($_SERVER["argv"])) 
{
    $ctrl = new ControllerCLI();
} 
else  
{
    die("Unexpected request method, please use the CLI");
}

$ctrl->setWorker($wrk);
$wrk->setCtrl($ctrl);

$ctrl->start();
