<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    //use RefreshDatabase;

    public function test_login_successful()
    {

        $credentials = [
            'email' => "pelda@pelda.com",
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'token',
                     'user' => [
                         'id',
                         'email',
                         'nickname',
                         'birthdate',
                     ],
                 ]);
    }

    public function test_login_failed_with_invalid_credentials()
    {
        $credentials = [
            'email' => 'nonexistent@example.com',
            'password' => 'wrongpassword',
        ];

        $response = $this->postJson('/api/login', $credentials);

        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'The provided credentials do not match our records.',
                 ]);
    }

    public function test_logout_successful()
    {
        $user = User::where('email', 'pelda@pelda.com')->first();

        $this->actingAs($user);

        $response = $this->postJson('/api/logout');

        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'logout successful',
                 ]);

        $this->assertCount(0, $user->tokens);
    }
}
