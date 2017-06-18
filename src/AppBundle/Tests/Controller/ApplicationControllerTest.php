<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ApplicationControllerTest extends WebTestCase
{
    public function testNouveau()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/annonce/nouveau');
    }

    public function testListe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/applications/');
    }

}
