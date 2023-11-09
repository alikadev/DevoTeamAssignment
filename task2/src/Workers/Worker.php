<?php

require_once "Controllers/IController.php";
require_once "Exceptions/RequestException.php";

class Worker
{
    const GOOGLE_API_KEY = "INSERT YOU GOOGLE API KEY";
    const GOOGLE_CX = "INSERT YOU GOOGLE CX";

    private IController $ctrl;

    public function __construct()
    {
    }

    public function start()
    {
    }

    private function parse_query(string $query) : string
    {
        return str_replace(" ", "%20", $query);
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
        // Do the GET request to the Google API
        $json = file_get_contents(
           "https://www.googleapis.com/customsearch/v1". 
           "?key=" . $this::GOOGLE_API_KEY . 
           "&cx=" . $this::GOOGLE_CX . 
           "&q=" . $this->parse_query($query)
        );

        if ($json == false)
        {
            throw new RequestException("Fail to communicate with the server");
        }

        // Decode the request result
        $array = json_decode($json, true);

        if ($array == null) {
            throw new RequestException("Fail to decode the server's output");
        }
        
        // Return the request result
        $req = $array["queries"]["request"][0];
        if (!isset($req["totalResults"])) return 0;

        return intval($req["totalResults"]);
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