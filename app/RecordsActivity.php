<?php

namespace App;


trait RecordsActivity
{

    protected static function bootRecordsActivity()
    {
        static::created(function ($thread)
        {
            $thread->recordActivity('created');
        });
    }

    public function recordActivity($event)
    {
        Activity::create([
            'user_id'      => auth()->id(),
            'type'         => $this->getActivityType($event),
            'subject_id'   => $this->id,
            'subject_type' => get_class($this),
        ]);
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$type}";
    }
}