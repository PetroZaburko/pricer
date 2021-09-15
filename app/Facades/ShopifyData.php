<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getAllProducts($fields = Null)
 * @method static getOneProduct($product_id, array $array = null)
 * @method static updateProduct(array $data);
  */
class ShopifyData extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'Shopify';
    }
}
