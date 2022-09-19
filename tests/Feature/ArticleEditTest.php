<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use App\Http\Requests\ArticleRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class ArticleEditTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function should_ログイン中の場合は変更画面に遷移する()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create();

        $response = $this->actingAs($user)->get(route('articles.edit', $article));

        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function should_未ログインの場合は一覧画面にリダイレクトする()
    {
        $article = Article::factory()->create();

        $response = $this->get(route('articles.edit', $article));

        $response->assertRedirect(route('articles.index'));
    }

    /**
     * @test
     */
    public function should_記事を更新する()
    {
        $user = User::factory()->create();

        $article = Article::factory()->create(['user_id' => $user->id]);

        $update_data = [
            'title' => 'title update data',
            'body' => 'body update data',
        ];

        $this->actingAs($user)->put(route('articles.update', $article), $update_data);

        $this->assertDatabaseHas(
            'articles',
            $update_data + [
                'id' => $article->id,
                'user_id' => $user->id
            ]
        );
    }

    /**
     *
     * @param array $keys
     * @param array $values
     * @param boolean $expect
     * 
     * @test
     * @dataProvider articleRegisterDataProvider
     */
    public function should_バリデーションを検証する(array $keys, array $values, bool $expect)
    {
        $dataList = array_combine($keys, $values);

        $request = new ArticleRequest();
        $rules = $request->rules();
        $validator = Validator::make($dataList, $rules);
        $result = $validator->passes();

        $this->assertEquals($expect, $result);
    }

    /**
     * バリデーション用データプロバイダ
     *
     * @return array
     */
    public function articleRegisterDataProvider(): array
    {
        return [
            'タイトル必須エラー(null)' => [
                ['title', 'body'],
                [null, 'test body'],
                false
            ],
            'タイトル必須エラー(空文字)' => [
                ['title', 'body'],
                ['', 'test body'],
                false
            ],
            'タイトル最大文字数OK' => [
                ['title', 'body'],
                [str_repeat('a', 50), 'test body'],
                true
            ],
            'タイトル最大文字数エラー' => [
                ['title', 'body'],
                [str_repeat('a', 51), 'test body'],
                false
            ],
            '本文必須エラー(null)' => [
                ['title', 'body'],
                ['test title', null],
                false
            ],
            '本文必須エラー(空文字)' => [
                ['title', 'body'],
                ['test title', null],
                false
            ],
            '本文最大文字数OK' => [
                ['title', 'body'],
                ['test title', str_repeat('a', 500)],
                true
            ],
            '本文最大文字数エラー' => [
                ['title', 'body'],
                ['test title', str_repeat('a', 501)],
                false
            ],
        ];
    }
}
