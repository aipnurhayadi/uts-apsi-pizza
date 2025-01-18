<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
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

    public function deliveryTime()
    {
        return $this->belongsTo(DeliveryTime::class);
    }

    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
