<?php

/*
 * This file was created by Jakub Szczerba
 * Contact: https://www.linkedin.com/in/jakub-szczerba-3492751b4/
*/

declare(strict_types=1);

namespace App\Tests\Service\Movie;

use App\Provider\Movie\InputProvider;
use App\Service\Movie\RecommendationService;
use PHPUnit\Framework\TestCase;

class RecommendationServiceTest extends TestCase
{
    public function testGetThreeRandomTitles(): void
    {
        $inputProviderMock = $this->createMock(InputProvider::class);
        $inputProviderMock->expects($this->once())
            ->method('getMovies')
            ->willReturn(['Movie1', 'Movie2', 'Movie3', 'Movie4', 'Movie5']);

        $recommendationService = new RecommendationService($inputProviderMock);
        $result = $recommendationService->getThreeRandomTitles();

        $this->assertCount(3, $result);
        foreach ($result as $title) {
            $this->assertContains($title, ['Movie1', 'Movie2', 'Movie3', 'Movie4', 'Movie5']);
        }
    }

    public function testGetStartingFromAndEvenTitles(): void
    {
        $inputProviderMock = $this->createMock(InputProvider::class);
        $inputProviderMock->expects($this->once())
            ->method('getMovies')
            ->willReturn(['Water', 'Wind', 'Fire', 'World', 'Sky', 'Watchers']);

        $recommendationService = new RecommendationService($inputProviderMock);
        $result = $recommendationService->getStartingFromAndEvenTitles();

        $this->assertCount(2, $result);
        $this->assertContains('Wind', $result);
        $this->assertContains('Watchers', $result);
    }

    public function testGetMultipleWordsTitles(): void
    {
        $inputProviderMock = $this->createMock(InputProvider::class);
        $inputProviderMock->expects($this->once())
            ->method('getMovies')
            ->willReturn(['OneWord', 'Two Words', 'Three Words']);

        $recommendationService = new RecommendationService($inputProviderMock);
        $result = $recommendationService->getMultipleWordsTitles();

        $this->assertCount(2, $result);
        $this->assertContains('Two Words', $result);
        $this->assertContains('Three Words', $result);
    }
}