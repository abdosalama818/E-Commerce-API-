<?php
namespace App\Services;

use App\Interface\ProductInterface;
use App\Models\Product;

class ProductServices

{
    
  public $productInterface;
    public function __construct(ProductInterface $productInterface)
    {
        $this->productInterface = $productInterface;
    }

    public function getAllProducts()
    {
        return $this->productInterface->getAllProducts();
    }

    public function getProductById($id)
    {
        return $this->productInterface->getProductById($id);
    }
}