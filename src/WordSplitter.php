<?php

namespace App;


interface WordSplitter
{
    /**
     * @param string $word
     * @return array|string[]
     */
    public function split(string $word): array;
}