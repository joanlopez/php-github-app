<?php

namespace App;

use GuzzleHttp\ClientInterface as Client;

class HttpGuzzleGithubApiClient implements GithubApiClient
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var WordSplitter
     */
    private $splitter;
    /**
     * @var WordsCounter
     */
    private $wordsCounter;

    /**
     * @var array
     */
    private $parseMethods;

    private const GITHUB_URL = 'https://api.github.com/repos/%s/%s/contents';

    private const FILE_LABEL = 'file';

    private const DIRECTORY_LABEL = 'dir';

    public function __construct(Client $client, WordSplitter $splitter, WordsCounter $wordsCounter)
    {
        $this->client = $client;
        $this->splitter = $splitter;
        $this->wordsCounter = $wordsCounter;

        $this->parseMethods = [
            self::FILE_LABEL => function($fileNamesAcc, $fileContent) {
                $fileName = $this->removeExtension($fileContent['name']);
                if('' !== $fileName) {
                    $fileNamesAcc[] = $fileName;
                }
                return $fileNamesAcc;
            },
            self::DIRECTORY_LABEL => function($fileNamesAcc, $directoryContent) {
                $url = $directoryContent['url'];
                $directoryFileNames = $this->getFileNames($url);
                return array_merge($fileNamesAcc, $directoryFileNames);
            }
        ];
    }

    /**
     * @param string $organization
     * @param string $repo
     * @return array|string[]
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function countRepoWords(string $organization, string $repo): array
    {
        $url = sprintf(self::GITHUB_URL, $organization, $repo);
        $fileNames = $this->getFileNames($url);
        $fileNamesWords = [];
        foreach ($fileNames as $fileName) {
            $fileNamesWords = array_merge($fileNamesWords, $this->splitter->split($fileName));
        }
        $wordsCount = $this->wordsCounter->count($fileNamesWords);

        return $wordsCount;
    }

    /**
     * @param string $url
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFileNames(string $url): array
    {
        $fileNames = [];
        $response = $this->client->request('GET', $url, ['verify' => false]);
        $contents = json_decode($response->getBody(), true);
        foreach($contents as $content) {
            $type = $content['type'];
            $fileNames = $this->parseMethods[$type]($fileNames, $content);
        }
        return $fileNames;
    }

    private function removeExtension(string $filename): string {
        return pathinfo($filename, PATHINFO_FILENAME);
    }
}