<?php

namespace Tests\Feature;

use App\Activity;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{

    use DatabaseTransactions;

    /** @test */
    function guests_may_not_create_threads()
    {
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect(route('login'));

        $this->post(route('threads'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $user = factory('App\User')->states('unconfirmed')->create();
        $this->signIn($user);
        $thread = make('App\Thread');

        $this->post(route('threads'), $thread->toArray())
            ->assertRedirect(route('threads'))
            ->assertSessionHas('flash', 'You must first confirm your email address');
    }


    /** @test */
    function a_user_can_create_new_forum_threads()
    {
        // Given we have a signed user
        $this->signIn();

        // when we hit the endpoint to createa new thread
        $thread = make('App\Thread');

        $response = $this->post(route('threads'), $thread->toArray());

        // then we visit the thread path and
        // We should see the new thread
        $this->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);

    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread([ 'title' => null ])
            ->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread([ 'body' => null ])
            ->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread([ 'channel_id' => null ])
            ->assertSessionHasErrors('channel_id');

        $this->publishThread([ 'channel_id' => 999 ])
            ->assertSessionHasErrors('channel_id');

    }

    /** @test */
    function a_thread_requires_a_unique_slug()
    {

        $this->signIn();

        $thread = create('App\Thread', [ 'title' => 'Foo Title' ]);
        $this->assertEquals($thread->fresh()->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray())->json();
        $this->assertEquals("foo-title-{$thread['id']}", $thread[ 'slug' ]);

    }

    /** @test */
    function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();
        $thread = create('App\Thread', [ 'title' => 'Some Title 24' ]);
        $thread = $this->postJson(route('threads'), $thread->toArray())->json();
        $this->assertEquals("some-title-24-{$thread['id']}", $thread[ 'slug' ]);

    }

    /** @test */
    public function unauthorized_users_may_not_delete_threads()
    {
        $this->withExceptionHandling();
        $thread = create('App\Thread');

        $this->delete($thread->path())->assertRedirect(route('login'));

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }

    /** @test */
    function unauthorized_users_may_not_update_threads()
    {

        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => create('App\User')->id ]);

        $this->patch($thread->path(), [
            'title' => 'changed'
        ])->assertStatus(403);

    }


    /** @test */
    function a_thread_requires_a_title_and_body_to_be_updated()
    {

        $this->withExceptionHandling();
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);

        $this->patch($thread->path(), [
            'title' => 'changed'
        ])->assertSessionHasErrors('body');

        $this->patch($thread->path(), [
            'body' => 'changed'
        ])->assertSessionHasErrors('title');
    }

    /** @test */
    function a_thread_can_be_updated()
    {
        $this->signIn();
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

    /** @test */
    public function authorized_users_can_delete_threads()
    {
        $this->signIn();

        $thread = create('App\Thread', [ 'user_id' => auth()->id() ]);
        $reply = create('App\Reply', [ 'thread_id' => $thread->id ]);

        $response = $this->json('DELETE', $thread->path());

        $response->assertStatus(204);
        $this->assertDatabaseMissing('threads', [ 'id' => $thread->id ]);
        $this->assertDatabaseMissing('replies', [ 'id' => $reply->id ]);

        $this->assertEquals(0, Activity::count());
    }


    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $thread = make('App\Thread', $overrides);

        return $this->post(route('threads'), $thread->toArray());
    }
}
