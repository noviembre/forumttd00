<?php

namespace Tests\Unit;
use App\Spam;
use Tests\TestCase;

class SpamTest extends TestCase
{

    /** @test */
    function it_checks_for_invalid_keywords()
    {
        $spam = new Spam();
        $this->assertFalse($spam->detect('Innocent Reply Here'));

        $this->expectException('Exception');
        $spam->detect('yahoo customer support');

    }

    /** @test */
    function it_checks_for_any_key_being_held_down()
    {
        $spam = new Spam();
        $this->expectException('Exception');
        $spam->detect('Hello world aaaaaa');

    }

    

}
