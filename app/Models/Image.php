<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use SoftDeletes;

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($value)
    {
        return Storage::url($value);
    }
}
