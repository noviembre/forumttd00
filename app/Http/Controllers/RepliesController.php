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
     * @return \Illuminate\Http\Response
     */

    public function store($channelId, Thread $thread)
    {
        $this->validateReply();

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
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validateReply();
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

    protected function validateReply()
    {
        $this->validate(request(), [ 'body' => 'required' ]);
        resolve(Spam::class)->detect(request('body'));
    }
}
