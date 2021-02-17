<?php

namespace App\Listeners;

use App\Events\ThreadReceivedNewReply;
use App\Notifications\YouWereMentioned;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {

        preg_match_all('/\@([^\s\.]+)/', $event->reply->body, $matches);

        foreach ($matches[ 1 ] as $name) {
            $user = User::whereName($name)->first();

            if ( $user ) {
                $user->notify(new YouWereMentioned($event->reply));
            }
        }
    }
}
