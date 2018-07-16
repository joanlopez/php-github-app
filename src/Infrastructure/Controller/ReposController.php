<?php

namespace App\Infrastructure\Controller;

use App\Application\UseCase\CountWordsUseCase;
use App\Application\UseCase\UseCaseWrongParametersException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/repos")
 */
class ReposController extends AbstractController
{
    /** @var CountWordsUseCase */
    private $countWordsUseCase;

    public function __construct(CountWordsUseCase $countWordsUseCase)
    {
        $this->countWordsUseCase = $countWordsUseCase;
    }

    /**
     * @Route("/{organization}/{repository}/words", methods="GET", name="getRepoWords")
     */
    public function words($organization, $repository)
    {
        $status = Response::HTTP_OK;
        $data = [];
        try {
            $data = $this->countWordsUseCase->do($organization, $repository);
        } catch (UseCaseWrongParametersException $e) {
            $status = Response::HTTP_NO_CONTENT;
        }
        return $this->json($data, $status);
    }
}