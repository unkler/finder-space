<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GoodTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_いいねを登録する()
    {
         $user = User::factory()->create();

         $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->putJson(route('articles.like', $article));

        $this->assertDatabaseHas('likes',[
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * @test
     */
    public function should_いいねを解除する()
    {
         $user = User::factory()->create();

         $article = Article::factory()->create(['user_id' => $user->id]);

         $article->likes()->attach($user);

        $this->actingAs($user)->deleteJson(route('articles.like', $article));

        $this->assertDatabaseMissing('likes',[
            'user_id' => $user->id,
            'article_id' => $article->id,
        ]);
    }

    /**
     * @test
     */
    public function should_ログイン中のユーザーがいいねしている記事はtrueを返す()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create();

        $article->likes()->attach($user);

        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    /**
     * @test
     */
    public function should_ログイン中のユーザーがいいねしていない記事はfalseを返す()
    {
        $user = User::factory()->create();

        $another = User::factory()->create();

        $article = Article::factory()->create();

        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
