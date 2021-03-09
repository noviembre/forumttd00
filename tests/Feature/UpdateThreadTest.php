<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class UpdateThreadTest extends TestCase
{

    use DatabaseTransactions;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->withExceptionHandling();

        $this->signIn();
    }

    /** @test */
    function unauthorized_users_may_not_update_threads()
    {

        $thread = create('App\Thread', [ 'user_id' => create('App\User')->id ]);

        $this->patch($thread->path(), [])->assertStatus(403);

    }


    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated()
    {

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);

        $this->patch($thread->path(), [
            'title' => 'changed'
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'changed'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_can_be_updated_by_its_creator()
    {
        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);
        $this->patch($thread->path(), [
            'title' => 'changed',
            'body'  => 'changed body',
        ]);

        tap($thread->fresh(), function ($thread) {
            $this->assertEquals('changed', $thread->title);
            $this->assertEquals('changed body', $thread->body);
        });

    }


}
