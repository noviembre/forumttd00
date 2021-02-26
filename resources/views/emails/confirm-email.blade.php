@component('mail::message')
    # One last step

    We just need to confirm your email address to prove your are human. you get it, right ?

    @component('mail::button', ['url' => url('/register/confirm?token=' . $user->confirmation_token)])
        Confirm Email
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
