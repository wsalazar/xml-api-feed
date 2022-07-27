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
        $randomUsersArray = [];
        foreach ($results as $index => $oneResult) {
            $randomUsersArray[$index]['person']['fullName'] = ['first' => $oneResult->name->first, 'last' => $oneResult->name->last];
            $randomUsersArray[$index]['person']['contact'] = ['phone' => $oneResult->phone, 'email' => $oneResult->email];
            $randomUsersArray[$index]['person']['location'] = ['country' => $oneResult->location->country];
        }
        return $randomUsersArray;
    }
}