<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ArticleControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 글쓰기_화면을_볼_수_있다(): void
    {
        $this->get(route('articles.create'))
        ->assertStatus(200)
        ->assertSee('글쓰기');
    }

    /**
     * @test
     */
    public function 글을_작성할_수_있다(): void
    {
        $testData = [
            'body' => 'test article'
        ];

        $user = User::factory()->create();

        $this->actingAs($user)
        ->post(route('articles.store'),$testData)
        ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', $testData);
    }

    /**
     * @test
     */
    public function 글_목록을_확인할_수_있다(): void
    {
        $now = Carbon::now();
        $afterOneSecond = (clone $now)->addSecond();

        $article1 = Article::factory()->create(
            ['created_at' => $now]
        );
        $article2 = Article::factory()->create(
            ['created_at' => $afterOneSecond]
        );

        $this->get(route('articles.index'))
        ->assertSeeInOrder([
            $article2->body,
            $article1->body
        ]);
    }

    /**
     * @test
     */
    public function 개별_글을_조회할_수_있다(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.show', ['article' => $article->id]))
        ->assertSuccessful()
        ->assertSee($article->body);
    }

    /**
     * @test
     */
    public function 글수정_화면을_볼_수_있다(): void
    {
        $article = Article::factory()->create();

        $this->get(route('articles.edit', ['article' => $article->id]))
        ->assertStatus(200)
        ->assertSee('글 수정');
    }

    /**
     * @test
     */
    public function 글을_수정할_수_있다(): void
    {
        $payload = ['body' => '수정된 글'];

        $article = Article::factory()->create();

        $this->patch(route('articles.update', ['article' => $article->id]), $payload)
        ->assertRedirect(route('articles.index'));

        $this->assertDatabaseHas('articles', $payload);
    }

    /**
     * @test
     */
    public function 글을_삭제할_수_있다(): void
    {
        $article = Article::factory()->create();

        $this->delete(route('articles.destroy', ['article' => $article->id]))
        ->assertRedirect(route('articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $article->id]);
    }
}
