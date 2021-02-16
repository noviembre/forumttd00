<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;
use Gate;


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
     * @param CreatePostRequest $form
     * @return \Illuminate\Http\Response
     */

    public function store($channelId, Thread $thread, CreatePostRequest $form)
    {

        $reply = $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id()
        ]);

        preg_match_all('/\@([^\s\.]+)/', $reply->body, $matches);

        $names = $matches[ 1 ];

        foreach ($names as $name) {
            $user = User::whereName($name)->first();

            if ( $user ) {
                $user->notify(new YouWereMentioned($reply));
            }
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
