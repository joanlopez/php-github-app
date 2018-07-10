<?php

namespace App\Tests;

use App\HttpGuzzleGithubApiClient;
use App\MapWordsCounter;
use App\PascalWordSplitter;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class TestGithubApiClient extends TestCase
{
    /** @test */
    public function TestTheApplication() {
        $githubToken = '3ac8301e628d5fbbfa2e7aa48dd367232f22bcd5'; // Insert your token here
        $client = new HttpGuzzleGithubApiClient(
            new Client(['headers' => ['Authorization' => 'token '.$githubToken]]),
            new PascalWordSplitter(),
            new MapWordsCounter
        );
        $organization = 'guzzle'; // Insert your organization here
        $repo = 'guzzle'; // Insert your repo here
        $wordsCount = $client->countRepoWords($organization, $repo);
        print_r($wordsCount);
    }
}