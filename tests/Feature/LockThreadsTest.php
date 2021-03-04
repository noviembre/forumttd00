<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function non_administrators_may_not_lock_threads()
    {
//        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);
//        $this->post(route('locked-threads.store', $thread))->assertStatus(403);
        $this->patch($thread->path(),[
            'locked' => true,
        ])->assertStatus(403);

        $this->assertFalse(!!$thread->fresh()->locked);
    }

    /** @test */
    function once_locked_a_thread_may_not_receive_new_replies()
    {
        $this->signIn();
        $thread = create('App\Thread');
        $thread->lock();
        $this->post($thread->path() . '/replies', [
            'body'    => 'Foobar',
            'user_id' => auth()->id(),
        ])->assertStatus(422);
    }


}
