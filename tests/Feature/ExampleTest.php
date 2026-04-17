<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function test_api_health_endpoint_returns_success(): void
    {
        $response = $this->get('/up');

        $response->assertStatus(200);
    }
}
