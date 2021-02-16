<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MentionUserTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function mentioned_users_in_a_reply_are_notificated()
    {
        $john = create('App\User', [ 'name' => 'JohnDoe' ]);
        $this->signIn($john);

        $jane = create('App\User', [ 'name' => 'JaneDoe' ]);

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => '@JaneDoe look at this.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());
        $this->assertCount(1, $jane->notifications);

    }


}
