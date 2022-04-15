<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginSuccess()
    {
        $data = [
            'email' => 'email2@gmail.com',
            'password' => 'password2',
        ];

        $client = static::createClient();
        $client->request('POST', '/login', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testLoginWithInvalidCredentials()
    {
        $data = [
            'email' => 'email2@invalid.com',
            'password' => 'invalid_invalid',
        ];

        $client = static::createClient();
        $client->request('POST', '/login', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Invalid credentials', $client->getResponse()->getContent());
    }
}
