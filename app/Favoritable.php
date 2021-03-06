<?php

namespace App;

trait Favoritable
{
    /**
     * Boot the trait.
     */
    protected static function bootFavoritable()
    {
        static::deleting(function ($model) {
            $model->favorites->each->delete();
        });
    }


    public function favorite()
    {
        $attributes = [ 'user_id' => auth()->id() ];

        if ( ! $this->favorites()->where($attributes)->exists() )
        {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $attributes = [ 'user_id' => auth()->id() ];

        $this->favorites()->where($attributes)->get()->each->delete();

    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavorited();
    }

    /**
     * Determine if the current reply has been favorited.
     *
     * @return boolean
     */
    public function isFavorited()
    {
        return ! ! $this->favorites->where('user_id', auth()->id())->count();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }
}