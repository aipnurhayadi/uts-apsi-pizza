<?php

namespace App;

use Illuminate\Support\Facades\Auth;

trait RelatedUserAndTimestamp
{
    /**
     * Boot the trait to handle model events.
     */
    public static function bootRelatedUserAndTimestamp()
    {
        static::creating(function ($model) {
            $model->created_at = now();
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_at = now();
            $model->updated_by = Auth::id();
        });

        static::deleting(function ($model) {
            if (method_exists($model, 'runSoftDelete')) {
                $model->deleted_by = Auth::id();
                $model->save();
            }
        });
    }
}
