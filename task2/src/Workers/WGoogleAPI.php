<?php

require_once "IWAPIRequester.php";

class WGoogleAPI implements IWAPIRequester
{
    const GOOGLE_API_URL = "https://www.googleapis.com/customsearch/v1";

    /**
     * Get the Google search engine estimated result count.
     * 
     * @param  string $query The query to process
     * @return int           The estimated result count.
     */
    public function get_result_count(string $query) : int
    {
        // Do the GET request to the Google API
        $json = file_get_contents(
            $this::GOOGLE_API_URL . 
            "?key=" . GOOGLE_API_KEY . 
            "&cx=" . GOOGLE_CX . 
            "&q=" . urlencode($query)
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
}