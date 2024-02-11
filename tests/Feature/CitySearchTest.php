<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class CitySearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_get_all_cities()
    {
        $user = User::factory()->create();

        $authResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $authResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/search/cities');

        $response->assertStatus(200);
    }

    public function test_can_get_all_cities_not_authenticated()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/search/cities');

        $response->assertStatus(401);
    }

    public function test_can_get_cities_by_id()
    {
        $user = User::factory()->create();

        $authResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $authResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/search/cities?id=1');

        $response->assertStatus(200);
    }

    public function test_search_cities_by_non_existing_id()
    {
        $user = User::factory()->create();

        $authResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $authResponse->json('access_token');

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/search/cities?id=10000');

        $response->assertStatus(404);
    }
}
