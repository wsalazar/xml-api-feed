<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

abstract class ConsumeServices
{
    protected $validService;

    protected $url;

    protected $client;

    /**
     * @var
     * @desccription this argument is used if the url does not have a query string to express how many records to return.
     * randomusers has a results=n boredapi does not.
     */
    protected $noLimit;

    /**
     * @param Client $client
     * @param $noLimit
     * @throws GuzzleException
     */
    public function __construct(Client $client, bool $noLimit = false)
    {
        $this->client = $client;
        $randomUserRequest = $this->client->head($this->url);
        $this->validService = true;
        if ($randomUserRequest->getStatusCode() === 503) {
            $this->validService = false;
        }
        $this->noLimit = $noLimit;
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public final function request(): \stdClass
    {
        try {
            if (!$this->noLimit) {
                $response = [];
                for ($i = 0; $i < 10; $i++) {
                    $request = $this->client->request("GET", $this->url);
                    $body = $request->getBody();
                    $results = json_decode($body->getContents());
                    $object = new \stdClass();
                    foreach ($results as $key => $value) {
                        $object->{$key} = $value;
                    }
                    $response[$i] = $object;
                }
                $contents = json_encode(['results'=>$response]);
            } else {
                $request = $this->client->request("GET", $this->url);
                $body = $request->getBody();
                $contents = $body->getContents();
            }
        } catch (GuzzleException $exception) {
            return $exception->getMessage();
        }
        return json_decode($contents);
    }

    /**
     * @return bool
     */
    public final function isServiceUp(): bool
    {
        return $this->validService;
    }

}