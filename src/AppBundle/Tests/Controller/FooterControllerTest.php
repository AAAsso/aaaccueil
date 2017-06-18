<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FooterControllerTest extends WebTestCase
{
    public function testA_propos()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/a_propos');
    }

    public function testEquipe()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/equipe');
    }

    public function testPlan_du_site()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/plan_du_site');
    }

}
