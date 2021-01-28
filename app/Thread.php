<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    protected $guarded = [];
    protected $with = [ 'creator', 'channel' ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('replyCount', function ($builder)
        {
            $builder->withCount('replies');
        });

    }

    public function path()
    {
        #--- this method works with a_thread_can_make_a_string_path
        # (Thread.ft.Test 1/2)
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply)
    {
        $this->replies()->create($reply);
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

}
