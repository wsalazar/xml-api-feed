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
     * @param Client $client
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $randomUserRequest = $this->client->head($this->url);
        $this->validService = true;
        if ($randomUserRequest->getStatusCode() === 503) {
            $this->validService = false;
        }
    }

    /**
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public final function request(): \stdClass
    {
        try {
            $request = $this->client->request("GET", $this->url);
            $body = $request->getBody();
            $contents = $body->getContents();
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