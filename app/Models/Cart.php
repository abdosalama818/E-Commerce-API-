<?php

namespace App\Models;

use App\Models\Product;
use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{

    protected $fillable = [
        'cookie_id',
        'product_id',
        'quantity',
    ];



    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
