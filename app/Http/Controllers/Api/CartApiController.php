<?php

namespace App\Http\Controllers\Api;

use App\Facade\CartFacade;
use App\Http\Controllers\Controller;
use App\Http\Requests\CartRequest;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try{
          $carts = CartFacade::cartItems();

          if($carts->isEmpty()){
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('info.cart_is_empty'),
            ], 200);
          }

        return response()->json([
            'success' => true,
            'status' => 'success',
            'message' => __('info.cart_items_retrieved_successfully'),
            'data' => $carts
        ], 200);

        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => __('errors.server_error'),
            ], 500);
        }

    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(CartRequest $request)
    {
        try{
            $validated = $request->validated();
            $quantity = $request->input('quantity', 1);
            $product =  Product::findOrFail($request->input('product_id'));
            $cart = CartFacade::addToCart($product, $quantity);

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('info.item_added_to_cart_successfully'),
                'data' => $cart
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CartRequest $request )
    {
        try{
 
 $validated = $request->validated();
            $quantity = $request->input('quantity', 1);
            $product =  Product::findOrFail($request->input('product_id'));
           $cart =  CartFacade::updateCart($product, $quantity);

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('info.item_updated_in_cart_successfully'),
                'data' => $cart
            ], 200);
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => __('errors.server_error'),
            ], 500);
        }
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
       
            CartFacade::delete($id);

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('info.item_removed_from_cart_successfully'),
            ], 200);
           
    
        }catch(\Exception $e){
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
