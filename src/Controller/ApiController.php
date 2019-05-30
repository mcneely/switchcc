<?php

namespace App\Controller;

use App\Service\ChangeCalculator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ApiController
 * @package App\Controller
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * Takes in totalCost and amountProvided and calculates
     *
     * @Route("/calculateChange/{totalCost}/{amountProvided}",
     *      methods={"GET"},
     * )
     * @param float            $totalCost
     * @param float            $amountProvided
     * @param ChangeCalculator $changeCalculator
     * @return JsonResponse
     */
    public function calculateChangeAction(
        float $totalCost,
        float $amountProvided,
        ChangeCalculator $changeCalculator
    ): JsonResponse
    {
        try {
            $change = $changeCalculator->calculateChange($totalCost, $amountProvided);
            $result = [
                'change' => empty($change) ? "none" : $change,
            ];
        } catch (Exception $e) {
            $result = [
                'error' => $e->getMessage(),
            ];
        }

        return $this->json($result);
    }
}
