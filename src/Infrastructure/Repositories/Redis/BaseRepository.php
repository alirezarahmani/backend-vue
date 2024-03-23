<?php

namespace App\Infrastructure\Repositories\Redis;

use Predis\Client;

abstract class BaseRepository
{
    protected Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}