<?php

namespace Tests\Unit;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use WithFaker;

    public function testProjectCreatedCorrectly()
    {
        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'statuses' => Project::STATUS_PLANNED,
        ];

        $this->json('POST', '/api/projects', $data)
            ->assertStatus(201)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'statuses',
                    'created_at'
                ]
            ]);
    }

    public function testProjectUpdatedCorrectly()
    {
        $project = factory(Project::class)->create([
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'statuses' => Project::STATUS_PLANNED,
        ]);

        $data = [
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'statuses' => Project::STATUS_PLANNED,
        ];

        $this->json('PUT', '/api/projects/' . $project->id, $data)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'statuses',
                    'created_at'
                ]
            ]);
    }

    public function testsProjectDeletedCorrectly()
    {
        $project = factory(Project::class)->create([
            'name' => $this->faker->word,
            'description' => $this->faker->text,
            'statuses' => Project::STATUS_PLANNED,
        ]);

        $this->json('DELETE', '/api/projects/' . $project->id)
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'id',
                    'name',
                    'description',
                    'statuses',
                    'created_at'
                ]
            ]);
    }

    public function testProjectListedCorrectly()
    {
        $this->json('GET', '/api/projects')
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'description',
                        'statuses',
                        'created_at'
                    ]
                ]
            ]);
    }
}
