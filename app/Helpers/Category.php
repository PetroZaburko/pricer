<?php


namespace App\Helpers;


use Illuminate\Http\Request;

class Category
{
    /**
     * @param $categoryId
     * @param Request $request
     * @return array
     */
    public function getCategoryTerms($categoryId, Request $request)
    {
        $terms = $request->all(['asc_desc', 'perc_rate', 'value']);
        $result['category_id'] = $categoryId;
        foreach ($terms as $key => $term) {
            $result[$key] = $term[$categoryId];
        }
        return $result;
    }

    /**
     * @param array $terms
     * @param $price
     * @return float|int
     */
    public function updateAdvertPrice($terms, $price)
    {
        if($terms['perc_rate']) {
            $newPrice = ($terms['asc_desc']) ? $price - $terms['value'] : $price + $terms['value'];
        }
        else {
            $newPrice = ($terms['asc_desc']) ? $price - $price * $terms['value'] / 100 : $price + $price * $terms['value'] / 100;
        }
        return ($newPrice > 0) ? round($newPrice,1) : 0;
    }

}
