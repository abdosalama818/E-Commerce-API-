<?php
namespace App\Interface;

use App\Models\Product;

interface  ProductInterface
{
    public function getAllProducts();

    public function getProductById($id);
    

   
}