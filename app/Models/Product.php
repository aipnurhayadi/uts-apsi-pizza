<?php

namespace App\Models;

use App\RelatedUserAndTimestamp;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NumberFormatter;

class Product extends Model
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

    public function getIdrPriceAttribute()
    {
        if ($this->price === null) {
            return 'Rp0,00';
        }

        $formatter = new NumberFormatter('id_ID', NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($this->price, 'IDR');
    }

    /**
     * Relasi satu produk ke banyak images.
     */
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * Relasi satu produk ke banyak jenis crust.
     */
    public function crusts()
    {
        return $this->hasMany(ProductCrust::class);
    }

    /**
     * Relasi satu produk ke banyak ukuran.
     */
    public function sizes()
    {
        return $this->hasMany(ProductSize::class);
    }
}
