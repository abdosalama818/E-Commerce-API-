<?php

namespace App\Repository;

use App\Interface\ProductInterface;
use App\Models\Product;

class ProductRepository implements ProductInterface

{
    public function getAllProducts()
    {

        //here i added pagination and translation for each product using (through) method
        $products = Product::paginate(10)
            ->through(function ($product) {
                return $product->getTranslatedData();
            });
        return $products;
    }
    public function getProductById($id)
    {

        ///here i return translated data for specific product by resourses 
        return Product::find($id);
    }
}
