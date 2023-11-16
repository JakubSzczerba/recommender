<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Controller;

use App\Service\Movie\RecommendationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MovieController extends AbstractController
{
    private RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    #[Route('/random', name: 'randomMovie', methods: ['GET'])]
    public function randomMovie(): JsonResponse
    {
        $randomMovies = $this->recommendationService->getThreeRandomTitles();

        return $this->json($randomMovies);
    }

    #[Route('/specific', name: 'specificTitleMovie', methods: ['GET'])]
    public function specificTitleMovie(): JsonResponse
    {
        $letterWMovies = $this->recommendationService->getStartingFromAndEvenTitles();

        return $this->json($letterWMovies);
    }

    #[Route('/long', name: 'longTitleMovie', methods: ['GET'])]
    public function longTitleMovie(): JsonResponse
    {
        $letterWMovies = $this->recommendationService->getMultipleWordsTitles();

        return $this->json($letterWMovies);
    }
}
