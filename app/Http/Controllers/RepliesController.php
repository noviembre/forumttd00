<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Rules\SpamFree;
use App\Thread;
use Gate;
//use Illuminate\Auth\Access\Gate;

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
        if (Gate::denies('create', new Reply)){
            return response('You are posting too frecuently. Please Take a break.', 422);
        }
        try {

            request()->validate([
                'body' => ['required', new SpamFree],

            ]);

            $reply = $thread->addReply([
                'body'    => request('body'),
                'user_id' => auth()->id()
            ]);


        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }

        return $reply->load('owner');
    }


    /**
     * @param Reply $reply
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
//            $this->validate(request(), [ 'body' => 'required:spamfree' ]);
            request()->validate([ 'body' => 'required:spamfree' ]);
            $reply->update(request([ 'body' ]));

        } catch (\Exception $e) {
            return response('Sorry, your reply could not be saved at this time.', 422);
        }


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
