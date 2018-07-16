<?php

namespace App\Domain\Counter;


interface WordsCounter
{
    /**
     * @param array|string[] $words
     * @return array|string[]
     */
    public function add(string ...$words);

    public function count(): array;
}