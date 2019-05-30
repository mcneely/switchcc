<?php

namespace App\Tests\Unit\Service;

use App\Service\ChangeCalculator;
use Exception;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;

class CalculateChangeActionTest extends TestCase
{
    /** @var ChangeCalculator $changeCalculator */
    protected $changeCalculator;

    protected function setUp()
    {
        $this->changeCalculator = new ChangeCalculator();
    }

    /**
     * @dataProvider changeProvider
     */
    public function testCalculateChange($totalCost, $amountProvided, $expected)
    {

        $actual = $this->changeCalculator->calculateChange($totalCost, $amountProvided);
        $this->assertEquals($expected, json_encode($actual));
    }

    public function testCalculateChangeException()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Total Cost Must be less than Amount Provided.");
        $this->changeCalculator->calculateChange(400.10, 2.00);
    }

    public function changeProvider()
    {
        return [
            [300.10, 400, '{"$50 Bills":1,"$20 Bills":2,"$5 Bills":1,"$2 Bills":2,"Quarters":3,"Dimes":1,"Nickels":1}'],
            [350.10, 400.05, '{"$20 Bills":2,"$5 Bills":1,"$2 Bills":2,"Quarters":3,"Dimes":2}'],
            [400, 400, '[]'],
        ];
    }


}
