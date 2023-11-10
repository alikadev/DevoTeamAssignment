<?php

require_once "IController.php";
require_once "Workers/Worker.php";
require_once "Exceptions/RequestException.php";
require_once "config.php";

class ControllerCLI implements IController
{
    private const GOOGLE_ID = "Google";
    private const BING_ID = "Bing";
    private Worker $worker;
    private array $best; // name => [query, result]

    public function __construct()
    {
        $this->best = [];
    }

    /**
     * Process a single query on each supported search engine.
     * 
     * @param  string $query The query to process
     */
    private function process_query(string $query)
    {
        try {
            // Line start
            print '"' . $query . '"';

            // Process engines
            if (USING_GOOGLE)
            {
                // Get count
                $googleCount = $this->worker->google_get_result_count($query);

                // Show information
                print " Google: $googleCount";

                // Check if it is the best one
                if (!isset($this->best[$this::GOOGLE_ID]) 
                    || $googleCount > $this->best[$this::GOOGLE_ID])
                {
                    $this->best[$this::GOOGLE_ID] = [
                        "query" => $query,
                        "result" => $googleCount
                    ];
                }
            }

            if (USING_BING)
            {
                // Get count
                $bingCount = $this->worker->bing_get_result_count($query);

                // Show information
                print " Bing: $bingCount";

                // Check if it is the best one
                if (!isset($this->best[$this::BING_ID]) 
                    || $bingCount > $this->best[$this::BING_ID])
                {
                    $this->best[$this::BING_ID] = [
                        "query" => $query,
                        "result" => $bingCount
                    ];
                }
            }

            print PHP_EOL;
                
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
        $globalBest = "";

        $command = array_shift($_SERVER["argv"]);
        if (count($_SERVER["argv"]) == 0)
        {
            print "Usage: $command <args>" . PHP_EOL;
            return;
        }
        foreach ($_SERVER["argv"] as $query)
        {
            $this->process_query($query);
        }

        foreach ($this->best as $best => $info)
        {
            print "$best winner: " . $info["query"] . PHP_EOL;
        }

        print "Total winner: ". $this->worker->get_best($this->best) . PHP_EOL;
    }

    public function setWorker(Worker $worker) : void
    {
        $this->worker = $worker;
    }
}