<?php

require_once "Exceptions/RequestException.php";

interface IWAPIRequester
{
    /**
     * Get the result count for a query.
     * 
     * @param string $query The query
     * @return int The result count
     * 
     * @throws RequestException The error
     */
    public function get_result_count(string $query) : int;
}