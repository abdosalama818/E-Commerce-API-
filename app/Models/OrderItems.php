<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItems extends Pivot
{
    protected $table = 'order_items';
    public $incrementing = true; // becuase pivot tables primary key is not auto incrementing by default

    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

      public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
