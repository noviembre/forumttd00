<?php

namespace App;

use App\Events\ThreadHasNewReply;
use App\Events\ThreadReceivedNewReply;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Thread extends Model
{

    use RecordsActivity;

    protected $guarded = [];
    protected $with = [ 'creator', 'channel' ];
    protected $appends = [ 'isSubscribedTo' ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();


        /*
         *  When a thread is deleting
         *  I want to delete its replies in the process.
         */
        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
        static::created(function ($thread) {
            $thread->update([ 'slug' => $thread->title ]);
        });
    }

    public function path()
    {
        #--- this method works with a_thread_can_make_a_string_path
        # (Thread.ft.Test 1/2)
        return "/threads/{$this->channel->slug}/{$this->slug}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /*
     * Add a reply to a Thread
     * @param array $reply
     * @return Model
     */

    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);
        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * Apply all relevant thread filters.
     *
     * @param  Builder $query
     * @param  ThreadFilters $filters
     * @return Builder
     */
    public function scopeFilter($query, $filters)
    {
        return $filters->apply($query);
    }

    /*
    |--------------------------------------------------------------------------
    | Subcriptions
    |--------------------------------------------------------------------------
    |
    */

    /**
     * Subscribe a user to the current thread.
     *
     * @param  int|null $userId
     * @return $this
     */
    public function subscribe($userId = null)
    {
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);

        return $this;
    }

    /**
     * Unsubscribe a user from the current thread.
     *
     * @param int|null $userId
     */
    public function unsubscribe($userId = null)
    {
        $this->subscriptions()
            ->where('user_id', $userId ?: auth()->id())
            ->delete();
    }

    public function subscriptions()
    {
        return $this->hasMany(ThreadSubscription::class);
    }

    /**
     * Determine if the current user is subscribed to the thread.
     *
     * @return boolean
     */
    public function getIsSubscribedToAttribute()
    {
        return $this->subscriptions()
            ->where('user_id', auth()->id())
            ->exists();
    }

    public function hasUpdatesFor($user)
    {
        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }


    public function setSlugAttribute($value)
    {
        $slug = Str::slug($value);


        if (static::whereSlug($slug)->exists()) {
            $slug = "{$slug}-" . $this->id;
        }


        $this->attributes[ 'slug' ] = $slug;
    }
}
