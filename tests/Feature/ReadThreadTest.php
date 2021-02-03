<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {

        $response = $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }


    /** @test */
    public function a_user_can_filter_threads_according_to_a_channel()
    {
        $channel = create('App\Channel');
        $threadInChannel = create('App\Thread', [ 'channel_id' => $channel->id ]);
        $threadNotInChannel = create('App\Thread');

        $this->get('/threads/' . $channel->slug)
            ->assertSee($threadInChannel->title)
            ->assertDontSee($threadNotInChannel->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_any_username()
    {
        $this->signIn(create('App\User', [ 'name' => 'JohnDoe' ]));
        $threadByJohn = create('App\Thread', [ 'user_id' => auth()->id() ]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
            ->assertSee($threadByJohn->title)
            ->assertDontSee($threadNotByJohn->title);
    }

    /** @test */
    public function a_user_can_filter_threads_by_popurality()
    {
        $threadsWith_2Replies = create('App\Thread');
        create('App\Reply', [ 'thread_id' => $threadsWith_2Replies->id ], 2);

        $threadsWith_3Replies = create('App\Thread');
        create('App\Reply', [ 'thread_id' => $threadsWith_3Replies->id ], 3);

        $threadsWith_0Replies = $this->thread;
        $response = $this->getJson('threads?popular=1')->json();
        $this->assertEquals([ 3, 2, 0 ], array_column($response, 'replies_count'));
    }


    /** @test */
    function a_user_can_filter_threads_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', [ 'thread_id' => $thread->id ]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }


    /** @test */
    function a_user_can_request_all_replies_for_a_given_thread()
    {
        $thread = create('App\Thread');
        create('App\Reply', [ 'thread_id' => $thread->id ], 2);

        $response = $this->getJson($thread->path() . '/replies')->json();

        $this->assertCount(2, $response[ 'data' ]);
        $this->assertEquals(2, $response[ 'total' ]);
    }


}
