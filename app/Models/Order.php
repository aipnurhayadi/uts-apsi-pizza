<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, RelatedUserAndTimestamp;

    protected $fillable = [
        'user_id',
        'address_id',
        'payment_method_id',
        'payment_status',
        'order_type',
        'order_status',
    ];

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
