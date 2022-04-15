<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginControllerTest extends WebTestCase
{
    public function testLoginSuccess()
    {
        $client = static::createClient();
        $client->request('POST', '/login', [
            'email' => 'email2@gmail.com',
            'password' => 'password2',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testLoginWithInvalidCredentials()
    {
        $client = static::createClient();
        $client->request('POST', '/login', [
            'email' => 'email2@invalid.com',
            'password' => 'invalid_invalid',
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('Invalid credentials', $client->getResponse()->getContent());
    }
}
