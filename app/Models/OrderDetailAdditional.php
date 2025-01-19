<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailAdditional extends Model
{
    use SoftDeletes, RelatedUserAndTimestamp;

    protected $fillable = [
        'order_detail_id',
        'order_detail_additionable_id',
        'order_detail_additionable_type',
    ];

    public function orderDetail()
    {
        return $this->belongsTo(OrderDetail::class);
    }

    public function orderDetailAdditionable()
    {
        return $this->morphTo();
    }
}
