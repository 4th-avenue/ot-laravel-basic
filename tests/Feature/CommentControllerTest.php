<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function 댓글을_작성할_수_있다(): void
    {
        $user = User::factory()->create();

        $article = Article::factory()->create();

        $payload = ['article_id' => $article->id, 'body' => 'hello'];

        $this->actingAs($user)
        ->post(route('comments.store'), $payload)
        ->assertStatus(302)
        ->assertRedirectToRoute('articles.show', ['article' => $article->id]);

        $this->assertDatabaseHas('comments', $payload);
    }
}
