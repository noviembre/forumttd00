<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class FavoritesTest extends TestCase
{

    use DatabaseTransactions;

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

    /**  @test */
    public function an_authenticated_user_can_unfavorited_a_reply()
    {
        $this->signIn();
        $reply = create('App\Reply');
        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');
        $this->assertCount(0, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create('App\Reply');
        try
        {
            $this->post('replies/' . $reply->id . '/favorites');
            $this->post('replies/' . $reply->id . '/favorites');

        } catch (\Exception $e)
        {
            $this->fail('Dis not expect to insert the same record set twice');
        }
        $this->assertCount(1, $reply->favorites);
    }
}
