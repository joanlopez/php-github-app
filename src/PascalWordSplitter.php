<?php

namespace App;


class PascalWordSplitter implements WordSplitter
{
    /**
     * @param string $word
     * @return array|string[]
     */
    public function split(string $word): array
    {
        return array_slice(preg_split('/(?=[A-Z][a-z]+)/',$word), 1);
    }
}