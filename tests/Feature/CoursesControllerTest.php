<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CoursesControllerTest extends TestCase
{
    use RefreshDatabase;

    private array $headers = [
        'Accept' => 'application/json',
    ];

    /** @test */
    public function canDelete()
    {
        $user = User::factory()->create();
        $response = $this->delete('/api/users/' . $user->id);
        $response->assertStatus(200);
    }

    /** @test */
    public function canNotDelete()
    {
        User::truncate();
        $response = $this->delete('/api/users/100');
        $response->assertStatus(404);
    }

    /** @test */
    public function canIndex()
    {
        User::factory()->count(10)->create();

        $user = User::first();

        $response = $this->get('/api/users');
        $response->assertStatus(200);
        $response->assertJsonCount(10, 'payload');
        $response->assertJson(fn(AssertableJson $json) => $json->has(10)
            ->first(fn($json) => $json->where('id', $user->id)
                ->where('name', $user->name)
                ->where('email', $user->email)
                ->missing('password')
                ->etc()
            )
        );
    }

    /** @test */
    public function canNotStore()
    {
        $response = $this->post('/api/users', []);
        $response->assertStatus(422);
    }

    /** @test */
    public function canStore()
    {
        $response = $this->postJson('/api/users', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => '12345678',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'status' => true,
            ]);
    }
}
