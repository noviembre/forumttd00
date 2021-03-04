<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class LockThreadsTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function an_adminstrator_can_lock_any_thread()
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
