<?php

namespace App\Infrastructure\Controller;

use App\HttpGuzzleGithubApiClient;
use App\MapWordsCounter;
use App\PascalWordSplitter;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repos")
 */
class ReposController extends AbstractController
{
    /**
     * @Route("/{org}/{repo}/words", methods="GET", name="getRepoWords")
     */
    public function words($org, $repo)
    {
        $status = Response::HTTP_OK;
        $data = [];
        $githubToken = getenv('GITHUB_AUTH_TOKEN');
        $client = new HttpGuzzleGithubApiClient(
            new Client(['headers' => ['Authorization' => 'token '.$githubToken]]),
            new PascalWordSplitter,
            new MapWordsCounter
        );

        try {
            $data = $client->countRepoWords($org, $repo);
        } catch (GuzzleException $e) {
            $status = Response::HTTP_NO_CONTENT;
        }
        return $this->json($data, $status);
    }
}