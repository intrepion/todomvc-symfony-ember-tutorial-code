<?php

namespace AppBundle\Tests\Controller;

<<<<<<< HEAD
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
=======
use Liip\FunctionalTestBundle\Test\WebTestCase;
>>>>>>> a112b0bb58c938271078e9d7ed7640f3f71afb94

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
<<<<<<< HEAD
=======
        $this->loadFixtures(array(
            'AppBundle\DataFixtures\ORM\LoadAppRoleData',
            'AppBundle\DataFixtures\ORM\LoadAppUserData',
            'AppBundle\DataFixtures\ORM\LoadTodoData',
        ));
>>>>>>> a112b0bb58c938271078e9d7ed7640f3f71afb94
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Welcome to Symfony', $crawler->filter('#container h1')->text());
<<<<<<< HEAD
=======

        $crawler = $client->request(
            'POST',
            '/login_check'
        );

        $this->assertContains(
            '{"code":401,"message":"Bad credentials"}',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'POST',
            '/login_check',
            array(
                '_username' => 'user',
                '_password' => 'notuser'
            )
        );

        $this->assertContains(
            '{"code":401,"message":"Bad credentials"}',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'POST',
            '/login_check',
            array(
                '_username' => 'user',
                '_password' => 'user'
            )
        );

        $this->assertContains(
            '{"token":',
            $client->getResponse()->getContent()
        );

        $json = json_decode($client->getResponse()->getContent(), true);

        $crawler = $client->request(
            'POST',
            '/api/todos/'
        );

        $this->assertContains(
            '"status":"Bad Request","code":400',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'POST',
            '/api/todos/',
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                    'data' => array(
                        'type' => 'todos',
                        'attributes' => array(
                            'title' => 'Add a new todo',
                            'isCompleted'=> false,
                        )
                    )
                )
            )
        );

        $matches = array();
        preg_match(
            '/"id":(\d+),/',
            $client->getResponse()->getContent(),
            $matches
        );

        $this->assertContains(
            '"title":"Add a new todo","isCompleted":false',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'GET',
            '/api/todos/' . $matches[1],
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                )
            )
        );

        $this->assertContains(
            '"title":"Add a new todo","isCompleted":false',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'PATCH',
            '/api/todos/' . $matches[1],
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                    'data' => array(
                        'type' => 'todos',
                        'attributes' => array(
                            'title'=> 'Change a todo',
                            'isCompleted'=> true,
                        )
                    )
                )
            )
        );

        $this->assertContains(
            '"title":"Change a todo","isCompleted":true',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'GET',
            '/api/todos/',
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                )
            )
        );

        $this->assertContains(
            '"title":"Finish creating example project","isCompleted":true',
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            '"title":"Finish writing tutorial","isCompleted":false',
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            '"title":"Change a todo","isCompleted":true',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'DELETE',
            '/api/todos/' . $matches[1],
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                )
            )
        );

        $crawler = $client->request(
            'GET',
            '/api/todos/',
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'],
                )
            )
        );

        $this->assertContains(
            '"title":"Finish creating example project","isCompleted":true',
            $client->getResponse()->getContent()
        );

        $this->assertContains(
            '"title":"Finish writing tutorial","isCompleted":false',
            $client->getResponse()->getContent()
        );

        $this->assertNotContains(
            '"title":"Change a todo","isCompleted":true',
            $client->getResponse()->getContent()
        );

        $crawler = $client->request(
            'GET',
            '/api/todos/',
            array(),
            array(),
            array(),
            json_encode(
                array(
                    'jsonWebToken' => $json['token'] . 'wrong',
                )
            )
        );

        $this->assertContains(
            '"status":"Bad Request","code":400',
            $client->getResponse()->getContent()
        );

>>>>>>> a112b0bb58c938271078e9d7ed7640f3f71afb94
    }
}
