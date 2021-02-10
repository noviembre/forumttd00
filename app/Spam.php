<?php

namespace App;

Class Spam
{

    public function detect($body)
    {
        $this->detectInvalidKeywords($body);

        return false;
    }

    protected function detectInvalidKeywords($body)
    {
        $invalidKeywords = [
            'Yahoo Customer Support'
        ];

        foreach ($invalidKeywords as $keyword){
            if ( stripos($body, $keyword) !== false )
            {
                throw new \Exception('Your reply contains spam.');
            }
        }
    }
}