<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EventControllerTest extends WebTestCase
{
    public function testAllEvents(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testLastEvents(): void
    {
        $client = static::createClient();
        $client->request('GET', '/event/last');

        $this->assertResponseIsSuccessful();
    }

    public function testShow(): void
    {
        $client = static::createClient();
        $client->request('GET', '/event/1');

        $this->assertResponseIsSuccessful();
    }
}
