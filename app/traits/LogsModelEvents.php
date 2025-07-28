<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

trait LogsModelEvents
{
    public static function bootLogsModelEvents()
    {
        // Automatically generate UUID if incrementing is false
        static::creating(function ($model) {
            if (!$model->incrementing && empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            Log::info(class_basename($model) . " is being created with ID: {$model->id}");
        });

        static::created(function ($model) {
            Log::info(class_basename($model) . " created: {$model->id}");
        });

        static::retrieved(function ($model) {
            Log::info(class_basename($model) . " retrieved the data: {$model->id}");
        });

        static::saving(function ($model) {
            Log::info(class_basename($model) . " saving: {$model->id}");
        });

        static::saved(function ($model) {
            Log::info(class_basename($model) . " saved: {$model->id}");
        });

        static::updating(function ($model) {
            Log::info(class_basename($model) . " is being updated: {$model->id}");
        });

        static::updated(function ($model) {
            Log::info(class_basename($model) . " updated: {$model->id}");
        });

        static::deleting(function ($model) {
            Log::warning(class_basename($model) . " is being deleted: {$model->id}");
        });

        static::deleted(function ($model) {
            Log::warning(class_basename($model) . " deleted: {$model->id}");
        });

        // static::restoring(function ($model) {
        //     Log::notice(class_basename($model) . " is being restored: {$model->id}");
        // });

        // static::restored(function ($model) {
        //     Log::notice(class_basename($model) . " restored: {$model->id}");
        // });
    }
}
