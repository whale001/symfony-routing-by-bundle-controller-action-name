<?php

namespace Option3Bundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UnluckyControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/option3/unlucky/number');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Option3Bundle lucky number 0', $crawler->text());
    }
}
