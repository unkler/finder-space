<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleDeleteTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_記事を削除する()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user)->delete(route('articles.destroy', ['article' => $article]));

         $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
