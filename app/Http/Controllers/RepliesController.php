<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', [ 'except' => 'index' ]);
    }

    /**
     * Fetch all relevant replies.
     *
     * @param int $channelId
     * @param Thread $thread
     */
    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(5);
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

        if ( str_contains(request('body'), 'Yahoo Customer Support') )
        {
            throw new \Exception('Your reply contains spam.');
        }

        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id()
        ]);

        if ( request()->expectsJson() )
        {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your reply has been left.');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->update(request([ 'body' ]));

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if ( request()->expectsJson() )
        {
            return response([ 'status' => 'Reply Deleted' ]);
        }
        return back();
    }
}
