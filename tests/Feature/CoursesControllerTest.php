<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Course;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursesControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $headers = [
        'Accept' => 'application/json',
    ];

    /** @test */
    public function canIndex()
    {
        Course::factory()->count(10)->create();
        $this->assertDatabaseCount(Course::class, 10);

        $response = $this->get('/api/courses');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'payload');
    }

    /** @test */
    public function canNotStore()
    {
        $response = $this->post('/api/courses', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function canStore()
    {
        $response = $this->postJson('/api/courses', [
            'title' => 'Course title',
        ]);

        $response->assertStatus(201)
            ->assertJson(fn(AssertableJson $json) => $json->has('payload', fn($json) => $json->where('title', 'Course title')
                ->etc()
            )->etc());
    }
}
