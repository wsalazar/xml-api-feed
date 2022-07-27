<?php

namespace App\Services;

use GuzzleHttp\Client;

class BoredAPIService extends ConsumeServices
{
    public function __construct(Client $client)
    {
        $this->url = "http://www.boredapi.com/api/activity";
        parent::__construct($client);
    }

    /**
     * @param array $results
     * @return array
     */
    public function hydrate(array $results): array
    {
        $boredArray = [];
        foreach ($results as $index => $oneResult) {
            $objectVars = get_object_vars($oneResult);
            foreach ($objectVars as $key => $vars) {
                $boredArray[$index]['BoredApi'][$key] = $vars;
            }
        }
        return $boredArray;
    }

    /**
     * @param array $array
     * @return array
     */
    public final function sort(array $array): array
    {
        usort($array, function($var1, $var2) {
            return strcmp($var1['BoredApi']['type'], $var2['BoredApi']['type']);
        });
        return $array;
    }
}