<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnluckyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/app/unlucky/number');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('AppBundle lucky number 0', $crawler->text());
    }
}
