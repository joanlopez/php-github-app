<?php

namespace App\Application\HTTPClient;

interface HTTPClient
{
    public function request(string $method, string $url, array $options): array;
}