<?php

namespace App\Application\UseCase;

use App\Application\Service\GitHubApiClient;
use App\Domain\Counter\WordsCounter;
use App\Domain\Path\Path;
use App\Domain\Splitter\WordSplitter;

class CountWordsUseCase implements UseCase
{
    /** @var GithubApiClient */
    private $client;

    /** @var WordSplitter */
    private $splitter;

    /** @var WordsCounter */
    private $counter;

    public function __construct(GithubApiClient $client, WordSplitter $splitter, WordsCounter $counter)
    {
        $this->client = $client;
        $this->splitter = $splitter;
        $this->counter = $counter;
    }

    /**
     * @throws UseCaseWrongParametersException
     */
    public function do(string ...$args)
    {
        if (2 !== count($args)) {
            throw new UseCaseWrongParametersException;
        }
        $paths = $this->client->getRepoFilePaths($args[0], $args[1]);
        return $this->countWordsIn($paths);
    }

    private function countWordsIn(array $paths): array
    {
        /** @var Path $path */
        foreach ($paths as $path) {
            $splitWords = $this->splitter->split($path->nameWithoutExtension());
            $this->counter->add(...$splitWords);
        }
        return $this->counter->count();
    }
}