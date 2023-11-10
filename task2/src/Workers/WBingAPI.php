<?php

require_once "IWAPIRequester.php";

class WBingAPI implements IWAPIRequester
{
    const BING_API_URL = "https://api.bing.microsoft.com/v7.0/search";

    public function get_result_count(string $query) : int
    {
        // Prepare the context
        $options = [
            'http' => [
                'header' => 'Ocp-Apim-Subscription-Key: ' . BING_API_KEY,
                'method' => 'GET',
            ],
        ];

        $context = stream_context_create($options);

        // Do the GET request to the Google API
        $json = file_get_contents(
            $this::BING_API_URL . 
            "?q=" . $this->parse_query($query),
            false,
            $context
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
         $req = $array["webPages"];
         if (!isset($req["totalEstimatedMatches"])) return 0;
 
         return intval($req["totalEstimatedMatches"]);
    }

    private function parse_query(string $query) : string 
    {
        return str_replace(" ", "%20", $query);
    }
}