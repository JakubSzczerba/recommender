<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Service\Movie;

use App\Provider\Movie\InputProvider;

class RecommendationService
{
    private const RANDOM_COUNT = 3;
    private const STARING_LETTER = 'W';
    private InputProvider $inputProvider;

    public function __construct(InputProvider $inputProvider)
    {
        $this->inputProvider = $inputProvider;
    }

    public function getThreeRandomTitles(): array
    {
        $movies = $this->inputProvider->getMovies();

        if (count($movies) < self::RANDOM_COUNT) {
            throw new \RuntimeException('Not enough movies for random selection.');
        }

        $recommendedMovies = [];
        for ($i = 0; $i < self::RANDOM_COUNT; $i++) {
            $randomIndex = rand(0, count($movies) - 1);
            $recommendedMovies[] = $movies[$randomIndex];

            unset($movies[$randomIndex]);
            $movies = array_values($movies);
        }

        return $recommendedMovies;
    }

    public function getStartingFromAndEvenTitles(): array
    {
        $movies = $this->inputProvider->getMovies();

        if (empty($movies)) {
            throw new \RuntimeException('Not enough movies for random selection.');
        }

        $recommendedMovies = [];
        foreach ($movies as $movie) {
            if (str_starts_with($movie, self::STARING_LETTER) && strlen($movie) % 2 === 0) {
                $recommendedMovies[] = $movie;
            }
        }

        return $recommendedMovies;
    }

    public function getMultipleWordsTitles(): array
    {
        $movies = $this->inputProvider->getMovies();

        $recommendedMovies = [];
        foreach ($movies as $movie) {
            if (str_contains($movie, ' ')) {
                $recommendedMovies[] = $movie;
            }
        }

        return $recommendedMovies;
    }
}