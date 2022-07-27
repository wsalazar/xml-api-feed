<?php

namespace App\Services;

use GuzzleHttp\Client;

class RandomUsersService extends ConsumeServices
{

    public function __construct(Client $client)
    {
        $this->url = "https://randomuser.me/api?results=10";
        parent::__construct($client);
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
}



