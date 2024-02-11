<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class ProvinceSearchTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_can_get_all_provinces()
    {
        // Create a test user
        $user = User::factory()->create();

        // Send authentication request to /api/login endpoint
        $authResponse = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        // Extract token from authentication response
        $token = $authResponse->json('access_token');

        // Send HTTP GET request to /api/provinces endpoint with authentication token
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
            'Accept' => 'application/json',
        ])->get('/api/search/provinces');

        // Ensure the response has status code 200 (OK)
        $response->assertStatus(200);

        // Ensure the response data matches the expected structure
        $response->assertJsonStructure([
            '*' => ['province_id', 'province'],
        ]);
    }

    public function test_can_get_all_provinces_not_authenticated()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
        ])->get('/api/search/provinces');

        $response->assertStatus(401);
    }

    public function test_can_get_province_by_id()
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
        ])->get('/api/search/provinces?id=1');

        $response->assertStatus(200);
    }

    public function test_search_province_by_non_existing_id()
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
        ])->get('/api/search/provinces?id=10000');

        $response->assertStatus(404);
    }
}
