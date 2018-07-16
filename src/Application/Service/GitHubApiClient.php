<?php

namespace App\Application\Service;

use App\Domain\Path\Path;

interface GitHubApiClient
{
    /**
     * @return array|Path[]
     */
    public function getRepoFilePaths(string $organization, string $repository): array;
}