<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'number',
        'status',
        'paymet_status',
        'user_id',
    ];



        public function products(){
        return $this->belongsToMany(Product::class,
        'order_items', //pivot table name
        'order_id', //foreign key on pivot table for current model
        'product_id', //foreign key on pivot table for related model
        'id',
        'id')
        ->using(OrderItems::class)
        ->withPivot(['qty','price','product_name']);;
    }

    //observer to generate order number
    public static function booted()
    {
        static::creating(function(Order $order){
            $order->number = Order::getNextOrderNumber();
        });
    } 


    public static function getNextOrderNumber(){
        $year = Carbon::now()->year();
        $number = Order::whereYear('created_at',$year)->max('number');
        if($number){
           return $number + 1 ;
        }
        return $year . '0001';
 
    }


}
