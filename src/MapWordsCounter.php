<?php

namespace App;


class MapWordsCounter implements WordsCounter
{
    /**
     * @param array|string[] $words
     * @return array|string[]
     */
    public function count(array $words): array
    {
        return array_reduce($words, function(array $map, string $word) {
            if(!array_key_exists($word, $map)) {
                $map[$word] = 0;
            }
            $map[$word] += 1;
            return $map;
        }, []);
    }
}