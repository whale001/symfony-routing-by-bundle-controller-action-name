<?php

namespace Option1Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LuckyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/option1/lucky/number');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Option1Bundle lucky number', $crawler->text());
    }
}
