<?php

namespace App\Tests;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ChatEventControllerTest extends WebTestCase
{
    public function testAddNotLogged(): void
    {
        $client = static::createClient();
        $client->request('POST', '/event/1/chat/add', [], [], [], json_encode([
            'message' => 'lorem ipsum sit amet',
        ]));

        $this->assertStringContainsString('missing credentials', $client->getResponse()->getContent());
    }

    public function testAddLoggedUserSuccess(): void
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->find(1);
        $client->loginUser($user);
        $client->request('POST', '/event/1/chat/add', [], [], [], json_encode([
            'message' => 'lorem ipsum sit amet',
        ]));
        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testAddLoggedUserNotFound()
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->find(1);
        $client->loginUser($user);
        $client->request('POST', '/event/1123456/chat/add', [], [], [], json_encode([
            'message' => 'lorem ipsum sit amet',
        ]));

        $this->assertResponseStatusCodeSame(404);
        $this->assertStringContainsString('Event not found', $client->getResponse()->getContent());
    }

    public function testAddLoggedUserWithInvalidData()
    {
        $client = static::createClient();
        $user = static::getContainer()->get(UserRepository::class)->find(1);
        $client->loginUser($user);
        $client->request('POST', '/event/1123456/chat/add', [], [], [], json_encode([
            'message' => null,
        ]));

        $this->assertStringContainsString('error', $client->getResponse()->getContent());
    }
}
