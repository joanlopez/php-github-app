<?php

namespace App;


interface WordsCounter
{
    /**
     * @param array|string[] $words
     * @return array|string[]
     */
    public function count(array $words): array;
}