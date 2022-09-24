<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class FollowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function フォローする()
    {
        $follower = User::factory()->create();

        $requestData = [
            'user' => $follower
        ];

        $followee = User::factory()->create();

        $this->actingAs($follower)->put(route('users.follow', $followee->name), $requestData);

        $this->assertDatabaseHas('follows', [
            'follower_id' => $follower->id,
            'followee_id' => $followee->id,
        ]);
    }

    /**
     * @test
     */
    public function フォローを解除する()
    {
        $follower = User::factory()->create();

        $requestData = [
            'user' => $follower
        ];

        $followee = User::factory()->create();

        $follower->followings()->attach($followee);

        $this->actingAs($follower)->delete(route('users.unfollow', $followee->name), $requestData);

        $this->assertDatabaseMissing('follows', [
            'follower_id' => $follower->id,
            'followee_id' => $followee->id,
        ]);
    }

    /**
     * @test
     */
    public function should_自分自分のフォローは404ページに遷移する()
    {
        $user = User::factory()->create();

        $requestData = [
            'user' => $user
        ];

        $response = $this->actingAs($user)->put(route('users.follow', $user->name), $requestData);

        $response->assertStatus(404);
    }
}
