<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    use DatabaseTransactions;

    /**  @test */
    public function a_channel_consist_of_threads()
    {
        $channel = create('App\Channel');
        $thread = create('App\Thread', [ 'channel_id' => $channel->id ]);

        $this->assertTrue($channel->threads->contains($thread));
    }
}
