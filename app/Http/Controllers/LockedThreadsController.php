<?php

namespace App\Http\Controllers;

use App\Thread;

class LockedThreadsController extends Controller
{

    public function store(Thread $thread)
    {
        if ( ! auth()->user()->isAdmin() ) {
            return response('You not have permission to lock this thread.', 403);
        }

        $thread->lock();
    }
}
