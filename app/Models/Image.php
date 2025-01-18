<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use SoftDeletes, RelatedUserAndTimestamp;

    protected $fillable = [
        'created_by',
        'created_at',
        'updated_by',
        'updated_at',
        'deleted_by',
        'deleted_at'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getPathAttribute($value)
    {
        return Storage::url($value);
    }
}
