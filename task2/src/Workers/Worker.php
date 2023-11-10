<?php

require_once "Controllers/IController.php";
require_once "Exceptions/RequestException.php";
require_once "WGoogleAPI.php";
require_once "WBingAPI.php";

class Worker
{
    private IController $ctrl;

    private WGoogleAPI $googleAPI;
    private WBingAPI $bingAPI;

    public function __construct()
    {
        $this->googleAPI = new WGoogleAPI();
        $this->bingAPI = new WBingAPI();
    }

    public function start()
    {
    }

    /**
     * Get the best search engine API in the "best" array.
     * The array for at is (engine => [result, query])
     * 
     * @param  array  $arr The "best" array
     * @return string      The best of the "best" array
     */
    public function get_best(array $arr) : string
    {
        $best = "";
        $bestResult = -1;
        foreach ($arr as $engine => $info)
        {
            if ($bestResult < $info["result"])
            {
                $best = $engine;
                $bestResult = $info["result"];
            }
        }
        return $best;
    }

    /**
     * Use the Bing's Search API to get the result count for a query.
     * 
     * @param string $query The query.
     * @return int The result count.
     * @throws RequestException The error.
     */
    public function bing_get_result_count(string $query) : int
    {
        return $this->bingAPI->get_result_count($query);
    }

    /**
     * Use the Google's Search API to get the result count for a query.
     * 
     * @param string $query The query.
     * @return int The result count.
     * @throws RequestException The error.
     */
    public function google_get_result_count(string $query) : int
    {
        return $this->googleAPI->get_result_count($query);
    }

    /**
     * Set the Controller that the worker may use to do any request type.
     * 
     * @param IController $ctrl The controller reference
     */
    public function setCtrl(IController $ctrl)
    {
        $this->ctrl = $ctrl;
    }
}