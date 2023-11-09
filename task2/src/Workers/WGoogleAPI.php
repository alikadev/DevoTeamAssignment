<?php

require_once "IWAPIRequester.php";

class WGoogleAPI implements IWAPIRequester
{
    const GOOGLE_API_URL = "https://www.googleapis.com/customsearch/v1";
    const GOOGLE_API_KEY = "INSERT YOU GOOGLE API KEY";
    const GOOGLE_CX = "INSERT YOUR GOOGLE CX";

    public function get_result_count(string $query) : int
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

    private function parse_query(string $query) : string 
    {
        return str_replace(" ", "%20", $query);
    }
}