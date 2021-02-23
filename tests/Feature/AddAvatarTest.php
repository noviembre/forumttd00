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

    /** @test */
    function a_user_may_add_an_avatar_to_their_profile()
    {
        $this->signIn();

        Storage::fake('disco');

        $this->json('POST', 'api/users/' . auth()->id() . '/avatar', [
            'avatar' => $file = UploadedFile::fake()->image('avatar.jpg')
        ]);

        $this->assertEquals(asset('storage/avatars/' . $file->hashName()), auth()->user()->avatar_path);


        # moving image to a path
        Storage::disk('disco')->assertExists('avatars/' . $file->hashName());


    }

    /** @test */
    function a_user_can_determine_their_avatar_path()
    {
        $user = create('App\User');

        $this->assertEquals(asset('storage/avatars/default.png'), $user->avatar_path);
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(asset('storage/avatars/me.jpg'), $user->avatar_path);
    }
}
