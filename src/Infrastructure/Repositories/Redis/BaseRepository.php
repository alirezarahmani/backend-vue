<?php

namespace App\Infrastructure\Repositories\Redis;

use Predis\Client;

abstract readonly class BaseRepository
{
    protected readonly Client $client;

    public function __construct()
    {
        $this->client = new Client();
    }
}