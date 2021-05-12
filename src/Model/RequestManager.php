<?php

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;

class RequestManager
{
    public function request($pathToApi): array
    {
        $content = [];
        $client = HttpClient::create();
        $response = $client->request('GET', $pathToApi);

        $statusCode = $response->getStatusCode();

        if ($statusCode === 200) {
            $content = $response->toArray();
            // convert the response (here in JSON) to an PHP array
        }

        return $content;
    }
}
