<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/app/default/index');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('AppBundle, default controller, index action', $crawler->text());
    }
}
