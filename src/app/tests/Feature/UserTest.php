<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/auth/register', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'mobile_number' => '123456789',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Registration successful',
        ]);
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);
    }
    /** @test */
    public function a_user_cannot_register()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/api/auth/register', [
            'name' => '',
            'email' => 'john.doe@example.com',
            'password' => 'password',
            'mobile_number' => '123456789',
        ]);

        $response->assertStatus(422);

    }
    /** @test */
    public function a_user_can_login()
    {
        $user = User::factory()->create([
            'email' => 'john.doa@example.com',
            'password' => bcrypt('password'),
            'mobile_number' => '123455789',
            'name' => 'John Doe',
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'john.doa@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'Login successful',
        ]);
        $response->assertJsonStructure([
            'data' => [
                'user' => [
                    'name',
                    'email',
                    'mobile_number',
                ],
                'access_token',
            ],
        ]);

    }

    /** @test */
    public function a_user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john.dow@example.com',
            'password' => bcrypt('password'),
            'mobile_number' => '123445789',
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'john.dow@example.com',
            'password' => 'wrong-password',
        ]);
        $response->assertStatus(422);
        $response->assertJson([
            'message' => 'your credentials doesn\'t match our records',
        ]);
        $this->assertGuest();
    }

}
