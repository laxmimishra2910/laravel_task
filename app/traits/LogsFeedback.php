<?php

namespace App\traits;

use Illuminate\Support\Facades\Log;

trait LogsFeedback
{
     public static function bootLogsFeedback()
    {
         static::deleted(function ($feedback) {
            Log::info('Feedback deleted: ' . $feedback->id);
        });
    }
}
