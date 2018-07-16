<?php

namespace App\Domain\Counter;


class MapWordsCounter implements WordsCounter
{
    /** @var array $wordsMap */
    private $wordsMap;

    public function __construct()
    {
        $this->wordsMap = [];
    }

    public function count(): array
    {
        return $this->wordsMap;
    }

    public function add(string ...$words)
    {
        foreach ($words as $word) {
            $this->addOne($word);
        }
    }

    private function addOne(string $word)
    {
        if(!array_key_exists($word, $this->wordsMap)) {
            $this->wordsMap[$word] = 0;
        }

        $this->wordsMap[$word] += 1;
    }
}