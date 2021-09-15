<?php

namespace App\Http\Controllers;
use App\Adverts;
use App\Category;
use App\Facades\ShopifyData;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class AdvertsController extends Controller
{
    public function index()
    {
        $products = ShopifyData::getAllProducts(['id', 'title', 'handle', 'image']);
        $products = $this->paginate($products,config('view.per_page'),'', ['path' => '/olx/public/adverts']);
        $categories = Category::all();
        $adverts = Adverts::all();

        foreach ($products as $product) {
            if($advert = $adverts->where('advert_id',$product->id)->first()) {
                $product->category = $advert->category;
            }
        }
        return view('pages.adverts', compact('products', 'categories'));
    }

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function save(Request $request)
    {
        $adverts = Adverts::all();

        if (is_null($request->get('category_id'))) {
            if ($advert = $adverts->where('advert_id',$request->get('advert_id'))->first()) {
                $advert->delete();
                return redirect()->route('adverts')->with([
                    'message' => "You delete category ".$advert->category->title." from advert ".$request->get('advert_title'),
                    'status' => '0'
                ]);
            }
            return redirect()->route('adverts');
        }

        if ($advert = $adverts->where('advert_id',$request->get('advert_id'))->first()) {
            $advert->update($request->all());
            return redirect()->route('adverts')->with([
                'message' => "You added category ".$advert->category->title." to advert ".$request->get('advert_title'),
                'status' => '1'
            ]);
        }

        else {
            $advert = Adverts::create($request->all());
            return redirect()->route('adverts')->with([
                'message' => "You added category ".$advert->category->title." to advert ".$request->get('advert_title'),
                'status' => '1'
            ]);
        }
    }

}
