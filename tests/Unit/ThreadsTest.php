<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadsTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function a_thread_has_replies()
    {
        $thread = factory('App\Thread')->create();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }
}
