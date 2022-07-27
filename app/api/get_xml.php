<?php

use App\Services\ArraySort;
use App\Services\RandomUsersService;
use App\Services\BoredAPIService;
use App\Services\XMLHandler;
use GuzzleHttp\Client;

$app->get('/api/get-xml', function () use ($app) {
    $client = new Client();
    $service = new RandomUsersService($client);
    if (!$service->isServiceUp()) {
        $service = new BoredAPIService($client);
        if(!$service->isServiceUp()) {
            http_response_code(503);
            echo "Service is down";
            die();
        }
    }
    $content = $service->request();
    $results = $content->results;
    $array = $service->hydrate($results);

    $sorter = new ArraySort($service, $array);
    $sortedArray = $sorter->sortAscending()->reverseSort();
    $xmlData = new SimpleXMLElement('<?xml version="1.0"?><data></data>');

    $xml = new XMLHandler();
    $xmlData = $xml->addToXML($xmlData, $sortedArray);
    header('Content-Type: text/xml');
    echo $xml->asXML($xmlData);
    die();
});