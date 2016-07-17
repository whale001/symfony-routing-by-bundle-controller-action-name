<?php

namespace Option2Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnluckyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/option2/unlucky/number');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Option2Bundle lucky number 0', $crawler->text());
    }
}
