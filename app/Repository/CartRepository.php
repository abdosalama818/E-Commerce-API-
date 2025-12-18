<?php

namespace App\Repository;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;

class CartRepository

{

    public function cartItems() : Collection
    {
        $cartItems = Cart::where('cookie_id', $this->getCartToken())->get();
        return $cartItems;
    }

    
    public function addToCart($product, $quantity)
    {
        $cart = Cart::where('cookie_id', '=', $this->getCartToken())->where('product_id', '=', $product->id)->first();
        if ($cart) {
            $cart->increment('quantity', $quantity);
        } else {
            $cart = Cart::create([
                'cookie_id' => $this->getCartToken(),
                'product_id' => $product->id,
                'quantity' => $quantity
            ]);
        }

        return $cart;
    }


    public function updateCart($product, $quantity)
    {
       $cart =  Cart::where('cookie_id', '=', $this->getCartToken())->where('product_id', '=', $product->id)->first();
        $cart->update([
                'quantity' => $quantity
            ]);
            return $cart;

    }


     public function delete($id){
      return  Cart::where('product_id','=',$id)->
        where('cookie_id','=',$this->getCartToken())
        ->delete();

    }

        public function empty(){
        Cart::where('cookie_id','=',$this->getCartToken())
        ->delete();

    }

    public function total()
    {
        return Cart::where('cookie_id', $this->getCartToken())
            ->with('product')
            ->get()
            ->sum(function ($cart) {
                return $cart->product->price * $cart->quantity;
            });
    }

   public function getCartToken(): string
{
    $token = request()->header('X-Cart-Token');

    if (!$token) {
        $token = (string) Str::uuid();
    }

    return $token;
}
}
