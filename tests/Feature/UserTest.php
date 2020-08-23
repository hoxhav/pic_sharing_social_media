<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $response = $this->postJson('/api/auth/register', [ 'name' => 'Test name' ,'email' => 'Test email', 'password' => 'TestPassword','password_confirmation' => 'TestPassword']);

        $response
            ->assertSuccessful()
            ->assertJson([
                'created' => true,
            ]);
    }
}
