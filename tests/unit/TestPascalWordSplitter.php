<?php

namespace App\Tests\Unit;


use App\PascalWordSplitter;
use PHPUnit\Framework\TestCase;

class TestPascalWordSplitter extends TestCase
{
    /** @test */
    public function testItSplitsCorrectly() {
        $word = 'PascalCaseExample';
        $expected = ['Pascal', 'Case', 'Example'];
        $splitted = (new PascalWordSplitter)->split($word);
        $this->assertArraySubset($expected, $splitted);
    }
}