<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NotificationsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function a_notification_is_prepared_when_a_subscribed_thread_receives_a_new_reply_that_is_not_by_the_current_user()
    {
        $this->signIn();
        $thread = create('App\Thread')->subscribe();

        $this->assertCount(0, auth()->user()->notifications);

        // then each time a new reply is left..
        $thread->addReply([
            'user_id' => auth()->id(),
            'body'    => 'some reply here',
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);
    }


}
