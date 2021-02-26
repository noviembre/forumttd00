<?php

namespace Tests\Feature;

use App\Mail\PleaseConfirmYourEmail;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class RegistrationTest extends TestCase
{

    use DatabaseMigrations;

    /** @test */
    function a_confirmation_email_is_sent_upon_registration()
    {
        Mail::fake();
//        event(new Registered(create('App\User')));
        $this->post(route('register'), [
            'name'                  => 'John',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    /** @test */
    function user_can_fully_confirm_their_email_addresses()
    {
        Mail::fake();

        $this->post(route('register'), [
            'name'                  => 'John',
            'email'                 => 'john@example.com',
            'password'              => 'password',
            'password_confirmation' => 'password'
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed);
        $this->assertNotNull($user->confirmation_token);

        $response = $this->get('/register/confirm?token=' . $user->confirmation_token);
        $this->assertTrue($user->fresh()->confirmed);
        $response->assertRedirect('/threads');

    }
}
