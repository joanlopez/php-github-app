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
     * @Route("/{organization}/{repository}/words", methods="GET", name="getRepoWords")
     */
    public function words($organization, $repository)
    {
        $status = Response::HTTP_OK;
        $data = [];
        $client = new HttpGuzzleGithubApiClient(
            new Client(['headers' => ['Authorization' => 'token '. getenv('GITHUB_AUTH_TOKEN')]]),
            new PascalWordSplitter,
            new MapWordsCounter
        );

        try {
            $data = $client->countRepoWords($organization, $repository);
        } catch (GuzzleException $e) {
            $status = Response::HTTP_NO_CONTENT;
        }
        return $this->json($data, $status);
    }
}