<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

class ThreadSubscription extends Model
{

    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Notify the related user that the thread was updated.
     *
     * @param \App\Reply $reply
     */
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this, $reply));
    }
}
