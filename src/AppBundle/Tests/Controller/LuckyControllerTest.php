<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/app/lucky/number');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('AppBundle lucky number', $crawler->text());
    }
}
