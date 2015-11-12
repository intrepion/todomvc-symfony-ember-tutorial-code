<?php

namespace AppBundle\Tests\Controller;

use Liip\FunctionalTestBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\LoadAppRoleData',
            'AppBundle\DataFixtures\ORM\LoadAppUserData',
        ));
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());

        $crawler = $client->request(
            'POST',
            '/login_check',
            array(
                '_username' => 'user',
                '_password' => 'notuser'
            )
        );

        $crawler = $client->request(
            'POST',
            '/login_check',
            array(
                '_username' => 'user',
                '_password' => 'user'
            )
        );
    }
}
