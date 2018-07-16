<?php

namespace App\Application\UseCase;


interface UseCase
{
    public function do(string ...$args);
}