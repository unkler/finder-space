<?php

namespace Tests\Feature;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ArticleListTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_記事一覧を返却する()
    {
        $articles = Article::factory()->count(5)->create();

        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($articles as $article) {
            $response
                ->assertSee($article->title)
                ->assertSee($article->body);
        }
    }
}
