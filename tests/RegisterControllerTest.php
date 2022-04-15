<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterControllerTest extends WebTestCase
{
    public function testRegistraterSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/register', [
            'pseudo' => 'Lorem',
            'email' => 'lorem@gmail.com',
            'password' => 'password23',
            'region' => 'iledefrance',
            'hobbies' => ['sport', 'cinéma'],
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testRegistraterFail()
    {
        $client = static::createClient();
        $client->request('POST', '/register', [
            'email' => 'lorem@gmail.com',
            'password' => '',
        ]);

        $this->assertStringContainsString('error', $client->getResponse()->getContent());
    }
}
