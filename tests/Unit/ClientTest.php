<?php

namespace Tests\Unit;

use App\Client;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ClientTest extends TestCase
{
    use WithFaker;

    public function testClientCreatedCorrectly()
    {
        $data = [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password
        ];

        $this->json('POST', '/api/clients', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]);
    }

    public function testsClientDeletedCorrectly()
    {
        $client = factory(Client::class)->create([
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password
        ]);

        $this->json('DELETE', '/api/clients/' . $client->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'first_name',
                    'last_name',
                    'email',
                    'created_at'
                ]
            ]);
    }

    public function testClientsListedCorrectly()
    {
        $this->json('GET', '/api/clients')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'first_name',
                        'last_name',
                        'email',
                        'created_at'
                    ]
                ]
            ]);
    }
}
