<?php

namespace App\Infrastructure\Repositories\MeekroDB;

use DB;

abstract class BaseRepository
{
    public function __construct(protected readonly string $table)
    {
        DB::$user = $_ENV['MYSQL_USER'];;
        DB::$password = $_ENV['MYSQL_ROOT_PASSWORD'];;
        DB::$dbName = $_ENV['MYSQL_DB'];
        DB::$host = $_ENV['LOCAL_IP'];
        DB::$port = $_ENV['MYSQL_PORT'];
        DB::$encoding = 'utf8';
    }
}