<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductCrust extends Model
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

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function orderDetailAdditionals()
    {
        return $this->morphMany(OrderDetailAdditional::class, 'order_detail_additionable');
    }
}
