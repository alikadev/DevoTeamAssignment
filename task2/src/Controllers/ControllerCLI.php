<?php

require_once "Controllers/IController.php";
require_once "Workers/Worker.php";
require_once "Exceptions/RequestException.php";
require_once "config.php";

class ControllerCLI implements IController
{
    private Worker $worker;

    public function __construct()
    {
    }

    private function process_query(string $query) : void
    {
        $line_max = 0;
        $line_best = "NOBODY";
        try {
            // Line start
            print '"' . $query . '" ';

            if (USING_GOOGLE)
            {
                // Get count
                $googleCount = $this->worker->google_get_result_count($query);

                // Show information
                print "Google: $googleCount";

                // Check if it is the best one
                if ($googleCount > $line_max)
                {
                    $line_max = $googleCount;
                    $line_best = "Google";
                }
            }

            if (USING_BING)
            {
                // Get count
                $bingCount = $this->worker->bing_get_result_count($query);

                // Show information
                print " Bing: $bingCount";

                // Check if it is the best one
                if ($bingCount > $line_max)
                {
                    $line_max = $bingCount;
                    $line_best = "Bing";
                }
            }

            // Line end
            
            print " best: $line_best" . PHP_EOL;
                
        } catch (RequestException $ex) {
            print "ERROR: " . $ex->getMessage() . PHP_EOL;
        }
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
        foreach ($_SERVER["argv"] as $query)
        {
            $this->process_query($query);
        }
    }

    public function setWorker(Worker $worker) : void
    {
        $this->worker = $worker;
    }
}