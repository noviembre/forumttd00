<?php

namespace App\Inspections;

Class Spam
{

    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class,
    ];

    public function detect($body)
    {
        foreach ($this->inspections as $inspection) {
            app($inspection)->detect($body);
        }
        return false;
    }

}