<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FavoritesTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function guest_cannot_favorited_anything()
    {
        $this->withExceptionHandling()
            ->post('replies/1/favorites')
            ->assertRedirect('/login');

    }

    /**  @test */
    public function an_authenticated_user_can_favorited_any_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $this->post('replies/' . $reply->id . '/favorites');
        $this->assertCount(1, $reply->favorites);
    }
}
