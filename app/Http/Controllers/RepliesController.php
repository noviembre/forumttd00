<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
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
     * @param $channelId
     * @param  \App\Thread $thread
     * @param Spam $spam
     * @return \Illuminate\Http\Response
     */

    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), [ 'body' => 'required' ]);

        $spam->detect(request('body'));


        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id()
        ]);

        if ( request()->expectsJson() ) {
            return $reply->load('owner');
        }

        return back()->with('flash', 'Your reply has been left.');
    }

    /**
     * @param Reply $reply
     * @param Spam $spam
     */
    public function update(Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), [ 'body' => 'required' ]);

        $spam->detect(request('body'));

        $reply->update(request([ 'body' ]));

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if ( request()->expectsJson() ) {
            return response([ 'status' => 'Reply Deleted' ]);
        }
        return back();
    }
}
