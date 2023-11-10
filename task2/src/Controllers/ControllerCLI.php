<?php

require_once "Controllers/IController.php";
require_once "Workers/Worker.php";
require_once "Exceptions/RequestException.php";

class ControllerCLI implements IController
{
    private Worker $worker;

    public function __construct()
    {
    }

    /**
     * This is the function to call to start the application. It 
     * will start the worker itself. The worker reference MUST be 
     * already set before calling this function
     */
    public function start() : void
    {
        $this->worker->start();

        array_shift($_SERVER["argv"]);
        foreach ($_SERVER["argv"] as $search)
        {
            try {
                $googleCount = $this->worker->google_get_result_count($search);
                print "For $search Google: $googleCount" . PHP_EOL;
            } catch (RequestException $ex) {
                print "ERROR: " . $ex->getMessage() . PHP_EOL;
            }
        }
    }

    public function setWorker(Worker $worker) : void
    {
        $this->worker = $worker;
    }
}