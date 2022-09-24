<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\User;
use Tests\TestCase;

class UserListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function フォローされているユーザーを返却する()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.followers', $user->name));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function フォローしているユーザーを返却する()
    {
        $user = User::factory()->create();

        $response = $this->get(route('users.followings', $user->name));

        $response->assertStatus(200);
    }
}
