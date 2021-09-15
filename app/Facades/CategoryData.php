<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static getCategoryTerms(int|string $id, \Illuminate\Http\Request $request)
 * @method static updateAdvertPrice($terms, $price)
 */
class CategoryData extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'category';
    }

}
