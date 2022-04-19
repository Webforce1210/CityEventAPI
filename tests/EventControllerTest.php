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

    public function testShowNotFound(): void
    {
        $client = static::createClient();
        $client->request('GET', '/event/123456789');

        $this->assertResponseStatusCodeSame(404);
    }

    public function testAdd(): void
    {
        $data = [
            'title' => 'Lorem Ipsum',
            'adresse' => 'Lieu1',
            'description' => 'Description1',
            'budget' => 20,
            'date_debut' => '2022-12-17',
            'date_fin' => '2022-12-17',
            'heure_debut' => '14:30:00',
            'heure_fin' => '16:30:00',
            'type_activite' => 'basket',
            'nb_participant_max' => 30,
        ];

        $client = static::createClient();
        $client->request('POST', '/event/add', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testFilter(): void
    {
        $data = [
            'adresse' => 'Lieu1',
            'hobbies' => 'cinema',
        ];

        $client = static::createClient();
        $client->request('POST', '/event/filter', [], [], [], json_encode($data));
        $this->assertResponseIsSuccessful();
    }

    public function testUpdate(): void
    {
        $data = [
            'title' => 'Lorem Ipsum',
            'adresse' => 'Lieu1',
            'description' => 'Description1',
            'budget' => 20,
            'date_debut' => '2022-12-17',
            'date_fin' => '2022-12-17',
            'heure_debut' => '14:30:00',
            'heure_fin' => '16:30:00',
            'type_activite' => 'basket',
            'nb_participant_max' => 30,
        ];

        $client = static::createClient();
        $client->request('POST', '/event/1/update', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testUpdateNotAllField(): void
    {
        $data = [
            'title' => 'Lorem Ipsum',
            'adresse' => 'Lieu1',
            'description' => 'Description1',
            'budget' => 20,
            'date_debut' => '2022-12-17',
        ];

        $client = static::createClient();
        $client->request('POST', '/event/1/update', [], [], [], json_encode($data));

        $this->assertResponseIsSuccessful();
        $this->assertStringContainsString('success', $client->getResponse()->getContent());
    }

    public function testUpdateNotFound(): void
    {
        $data = [
            'title' => 'Lorem Ipsum',
            'adresse' => 'Lieu1',
            'description' => 'Description1',
            'budget' => 20,
        ];

        $client = static::createClient();
        $client->request('POST', '/event/11111111111111/update', [], [], [], json_encode($data));

        $this->assertResponseStatusCodeSame(404);
    }
}
