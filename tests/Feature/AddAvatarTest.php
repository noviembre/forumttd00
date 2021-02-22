<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

use Tests\TestCase;

class AddAvatarTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function only_members_can_add_avatars()
    {
        $this->withExceptionHandling();
        $this->json('POST', 'api/users/1/avatar')
            ->assertStatus(401);
    }

    /** @test */
    function a_valid_avatar_must_be_provided()
    {
        $this->withExceptionHandling()->signIn();

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => 'not-an-image'
        ])->assertStatus(422);
    }

    
}
