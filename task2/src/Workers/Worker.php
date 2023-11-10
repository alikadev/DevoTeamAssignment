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