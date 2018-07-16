<?php

namespace App\Application\Service;


use App\Application\HTTPClient\HTTPClient;
use App\Domain\Path\Path;
use App\Domain\Path\PathTypeNotAllowedException;

class HTTPGitHubApiClient implements GitHubApiClient
{
    private const GITHUB_URL = 'https://api.github.com/repos/%s/%s/contents';

    /** @var HTTPClient */
    private $client;

    /** @var string */
    private $authToken;

    /** @var array */
    private $httpOptions;

    public function __construct(HTTPClient $client, string $authToken)
    {
        $this->client = $client;
        $this->authToken = $authToken;

        $this->httpOptions = [
            'Authorization' => $authToken
        ];
    }

    public function getRepoFilePaths(string $organization, string $repository): array
    {
        return $this->getRepoFilePathsFromUrl(
            $this->buildApiUrl($organization, $repository)
        );
    }

    private function getRepoFilePathsFromUrl(string $url): array
    {
        $paths = [];
        $contents = $this->client->request('GET', $url, $this->httpOptions);
        foreach ($contents as $content) {
            try {
                $path = new Path($content['name'], $content['type'], $content['url']);
                $paths = $this->appendPaths($paths, $path);
            } catch (PathTypeNotAllowedException $e) {
                continue;
            }
        }
        return $paths;
    }

    private function appendPaths(array $paths, Path $path): array
    {
        if (Path::FILE_TYPE === $path->type()) {
            $paths[] = $path;
            return $paths;
        }

        $pathsOfPath = $this->getRepoFilePathsFromUrl($path->uri());
        $paths = array_merge($paths, $pathsOfPath);
        return $paths;
    }

    private function buildApiUrl(string $organization, string $repository): string
    {
        return sprintf(self::GITHUB_URL, $organization, $repository);
    }
}