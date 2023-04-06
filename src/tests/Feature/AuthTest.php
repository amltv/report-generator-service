<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function testLogin(): void
    {
        User::factory()->create([
            'email' => 'test@test.dev'
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'test@test.dev',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'token'
        ]);
    }

    public function testUserNotFound(): void
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'notexists@test.dev',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
    }

    public function testWrongPassword(): void
    {
        User::factory()->create([
            'email' => 'test@test.dev'
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'test@test.dev',
            'password' => 'wrong',
        ]);

        $response->assertStatus(401);
    }

}
