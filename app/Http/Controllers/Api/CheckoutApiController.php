<?php

namespace App\Http\Controllers\Api;

use App\Facade\CartFacade;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItems;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id',Auth::user()->id)->with('products')->get();
        if($orders->isEmpty()){
            return response()->json([
             
              'success' => false,
               'status' => 'failure',
                'message'=>__('info.no_orders_found')
            ],404);
        }
        return response()->json([
            'success' => true,
            'status' => 'success',
            'data'=> OrderResource::collection($orders)
        ],200);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
      try{
        $cartItems = CartFacade::cartItems();

        if($cartItems->isEmpty()){
            return response()->json([
             
              'success' => false,
               'status' => 'failure',
                'message'=>__('info.cart_is_empty')
            ],400);
        }

        $order = Order::create([
            'user_id'=>Auth::user()->id,
            'status'=>'pending',
            'payment_status'=>'unpaid',
        ]);

        foreach($cartItems as $item){
            $order->products()->attach($item->product_id,[
                'qty'=>$item->quantity,
                'price'=>$item->product->price,
                'product_name'=>$item->product->getTranslation('title',$request->header('Accept-Language','en')),
            ]);
        }
         DB::commit();
         CartFacade::empty();
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message'=>__('info.order_created_successfully'),
                'order_number'=>$order->number, 
            ],201);

        }catch(Exception $e){
            DB::rollBack();
            return response()->json(['message'=>'Order creation failed','error'=>$e->getMessage()],500);
        }
     

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::where('user_id',Auth::user()->id)->with('products')->find($id);
        if(!$order){
            return response()->json([
             
              'success' => false,
               'status' => 'failure',
                'message'=>__('info.no_orders_found')
            ],404);
        }
        return response()->json([
            'success' => true,
            'status' => 'success',
            'data'=> new OrderResource($order)
        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
