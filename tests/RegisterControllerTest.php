<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegistraterSuccess()
    {
        $data = [
            'pseudo' => 'Lorem',
            'email' => 'lorem@gmail.com',
            'password' => 'password23',
            'region' => 'iledefrance',
            'hobbies' => ['sport', 'cinéma'],
        ];

        $client = static::createClient();
        $client->request('POST', '/register', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testRegistraterFail()
    {
        $data = [
            'email' => 'lorem@gmail.com',
            'password' => '',
        ];

        $client = static::createClient();
        $client->request('POST', '/register', [], [], [], json_encode($data));

        $this->assertStringContainsString('error', $client->getResponse()->getContent());
    }
}
