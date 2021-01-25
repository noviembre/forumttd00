<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }


    /** @test */
    public function an_authenticated_user_can_create_new_forum_threads()
    {
        // Given we have a signed user
        $this->signIn();

        // when we hit the endpoint to createa new thread
        $thread = make('App\Thread');

        $response = $this->post('/threads', $thread->toArray());

        // then we visit the thread path and
        // We should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->signIn();
        $thread = make('App\Thread', [ 'title' => null ]);

        dd($thread);

        $this->post('/thread', $thread)
            ->assertSessionHasErrors('title');

    }
}
