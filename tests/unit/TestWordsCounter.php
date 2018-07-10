<?php

namespace App\Tests\Unit;


use App\MapWordsCounter;
use PHPUnit\Framework\TestCase;

class TestWordsCounter extends TestCase
{
    /** @test */
    public function testItSplitsCorrectly() {
        $words = ['Pascal', 'Pascal', 'Case', 'Case', 'Example'];
        $expected = ['Pascal' => 2, 'Case' => 2, 'Example' => 1];
        $splitted = (new MapWordsCounter)->count($words);
        $this->assertArraySubset($expected, $splitted);
    }
}