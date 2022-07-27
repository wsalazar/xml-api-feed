<?php

namespace App\Services;

use GuzzleHttp\Client;

class RandomUsersService extends ConsumeServices
{

    public function __construct(Client $client)
    {
        $this->url = "https://randomuser.me/api?results=10";
        parent::__construct($client, true);
    }

    /**
     * @param array $results
     * @return arra
     */
    public function hydrate(array $results): array
    {
        $randomUsersArray = [];
        foreach ($results as $index => $oneResult) {
            $randomUsersArray[$index]['person']['fullName'] = ['first' => $oneResult->name->first, 'last' => $oneResult->name->last];
            $randomUsersArray[$index]['person']['contact'] = ['phone' => $oneResult->phone, 'email' => $oneResult->email];
            $randomUsersArray[$index]['person']['location'] = ['country' => $oneResult->location->country];
        }
        return $randomUsersArray;
    }

    /**
     * @param array $array
     * @return array
     */
    public final function sort(array $array): array
    {
        usort($array, function($var1, $var2) {
            return strcmp($var1['person']['fullName']['last'], $var2['person']['fullName']['last']);
        });
        return $array;
    }
}



