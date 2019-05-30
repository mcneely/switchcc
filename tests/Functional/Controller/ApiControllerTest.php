<?php

namespace App\Tests\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

class ApiControllerTest extends WebTestCase
{
    /** @var Client $client */
    protected $client;

    protected function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * @dataProvider changeProvider
     */
    public function testCalculateChange($totalCost, $amountProvided, $expected)
    {
        $this->client->request(Request::METHOD_GET, "/api/calculateChange/{$totalCost}/{$amountProvided}");
        $actual = $this->client->getResponse()->getContent();
        $this->assertEquals('{"change":'.$expected.'}', $actual);
    }

    public function testCalculateChangeError()
    {
        $this->client->request(Request::METHOD_GET, "/api/calculateChange/400.10/2.00");
        $actual = $this->client->getResponse()->getContent();
        $this->assertEquals('{"error":"Total Cost Must be less than Amount Provided."}', $actual);

    }

    public function changeProvider()
    {
        return [
            [300.10, 400, '{"$50 Bills":1,"$20 Bills":2,"$5 Bills":1,"$2 Bills":2,"Quarters":3,"Dimes":1,"Nickels":1}'],
            [350.10, 400.05, '{"$20 Bills":2,"$5 Bills":1,"$2 Bills":2,"Quarters":3,"Dimes":2}'],
            [400, 400, '"none"'],
        ];
    }
}
