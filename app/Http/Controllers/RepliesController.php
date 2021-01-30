<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * persist a new reply.
     *
     * @param  $channelId
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */

    public function store($channelId, Thread $thread)
    {
        $this->validate(request(), [ 'body' => 'required' ]);

        $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id()
        ]);

        return back()->with('flash', 'Your reply has been left.');
    }

    public function destroy(Reply $reply)
    {
        if ( $reply->user_id != auth()->id() )
        {
            return response([],403);
        }
        $reply->delete();
        return back();
    }
}
