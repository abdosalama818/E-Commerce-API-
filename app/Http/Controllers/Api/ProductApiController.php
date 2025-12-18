<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Services\ProductServices;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{

    public $productService;
    public function __construct(ProductServices $productService)
    {
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->productService->getAllProducts();

        try {
            $products = $this->productService->getAllProducts();
            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => __('info.products_retrieved_successfully'),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'data' => $products->items(),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $product = $this->productService->getProductById($id);
            if (!$product) {
                return response()->json(
                    [
                        'success' =>    false,
                        'status' => 'error',
                        'message' => __('info.product_not_found'),

                    ],
                    404
                );
            }

            return response()->json([
                'success' => true,
                'status' => 'success',
                'message' => 'Product retrieved successfully',
                'data' => new ProductResource($product),
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'status' => 'error',
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
