<?php

namespace Tests\Feature;

use App\Models\User;
use App\Services\RegistrationService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class RegistrationServiceTest extends TestCase
{
    use RefreshDatabase;

    protected RegistrationService $registrationService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registrationService = new RegistrationService();
    }

    public function test_register_creates_new_user()
    {
        $request = Request::create('/register', 'POST', [
            'email' => 'test@example.com',
            'nickname' => 'TestUser',
            'birthdate' => '1996-11-08',
            'password' => 'password123',
        ]);

        $response = $this->registrationService->register($request);
        
        $this->assertEquals(201, $response->getStatusCode());
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
            'nickname' => 'TestUser',
        ]);

        $this->assertTrue(file_exists(storage_path('app/private/users/users.csv')));
    }

    public function test_register_fails_with_existing_email()
    {
        User::create([
            'email' => 'test@example.com',
            'nickname' => 'ExistingUser',
            'birthdate' => '1996-11-08',
            'password' => Hash::make('password123'),
        ]);

        $request = Request::create('/register', 'POST', [
            'email' => 'test@example.com',
            'nickname' => 'TestUser',
            'birthdate' => '1996-11-08',
            'password' => 'password123',
        ]);

        $this->expectException(ValidationException::class);
        $this->registrationService->register($request);
    }

}
