<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_jwt_token_can_be_created_for_user(): void
    {
        $user = User::factory()->create(['role' => 'employee']);

        $token = JWTAuth::fromUser($user);

        $this->assertIsString($token);
        $this->assertNotEmpty($token);
    }

    public function test_user_implements_jwt_subject_contract_methods(): void
    {
        $user = User::factory()->create();

        $this->assertSame($user->id, $user->getJWTIdentifier());
        $this->assertSame([], $user->getJWTCustomClaims());
    }
}
