<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/user');

        $this->assertResponseIsSuccessful();
    }

    public function testShow()
    {
        $client = static::createClient();
        $client->request('GET', '/user/1');

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('email2@gmail.com', $client->getResponse()->getContent());
    }

    public function testShowNotFound()
    {
        $client = static::createClient();
        $client->request('GET', '/user/11111456');

        $this->assertResponseStatusCodeSame(404);
    }
}
