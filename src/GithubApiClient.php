<?php

namespace App;


interface GithubApiClient
{
    /**
     * @param string $organization
     * @param string $repo
     * @return array|string[]
     */
    public function countRepoWords(string $organization, string $repo): array;
}