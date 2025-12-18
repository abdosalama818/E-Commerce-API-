<?php

namespace App\Facade;
use Illuminate\Support\Facades\Facade;

use App\Repository\CartRepository;


Class CartFacade extends Facade
{

      protected static function getFacadeAccessor(){
        return CartRepository::class;
    } 
}