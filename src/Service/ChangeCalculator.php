<?php


namespace App\Service;

use Exception;

/**
 * Class ChangeCalculator
 * @package App\Service
 */
class ChangeCalculator
{
    const DENOMINATIONS = [
        "$100 Bills" => 100.00,
        "$50 Bills"  => 50.00,
        "$20 Bills"  => 20.00,
        "$10 Bills"  => 10.00,
        "$5 Bills"   => 5.00,
        "$2 Bills"   => 2.00,
        "$1 Bills"   => 1.00,
        "Quarters"   => .25,
        "Dimes"      => .10,
        "Nickels"    => .05,
        "Pennies"    => .01,
    ];

    /**
     * @param float $totalCost
     * @param float $amountProvided
     * @return array
     * @throws Exception
     */
    public function calculateChange(float $totalCost, float $amountProvided): array
    {
        if ($totalCost > $amountProvided) {
            throw new Exception("Total Cost Must be less than Amount Provided.");
        }

        $totalChange = round($amountProvided - $totalCost,2);
        $changeArray = [];

        foreach (self::DENOMINATIONS as $denomination => $value) {
            if ($totalChange >= $value) {
                $changeArray[$denomination] = (int) floor($totalChange / $value);
                $totalChange                -= $changeArray[$denomination] * $value;
                // Reset precision to deal with php precision issue.
                $totalChange = round($totalChange, 2);
            }
        }

        return $changeArray;
    }
}