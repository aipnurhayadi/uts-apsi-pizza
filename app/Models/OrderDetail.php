<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use SoftDeletes, RelatedUserAndTimestamp;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'notes',
    ];
}
