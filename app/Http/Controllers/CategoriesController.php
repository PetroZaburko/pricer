<?php

namespace App\Http\Controllers;

use App\AdvertsHistory;
use App\Category;
use App\Facades\CategoryData;
use App\Facades\ShopifyData;
use App\History;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CategoriesController extends Controller
{
    public function index()
    {
        $categories = Category::where('company_id', Auth::user()->company_id)->paginate(config('view.per_page'));
        return view('pages.categories',['categories' => $categories]);
    }


    public function store(Request $request)
    {
        $request->request->add(['company_id' => Auth::user()->company_id]);
        $this->validate($request, [
                'company_id' => 'required',
                'title' => [
                    'required',
                    Rule::unique('categories')->where('company_id', $request->input('company_id'))
                ]
            ]);
        $category = Category::create($request->all());

        return response()->json([
            'title' => $category->title,
            'id' => $category->id
        ]);
    }


//    public function edit($id)
//    {
////        $category = Category::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
//        $category = Category::find($id);
//        return view('pages.edit',['category' => $category]);
//    }

    public function update(Request $request, $id)
    {
        $category = Category::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
//        $category = Category::find($id);
        $this->validate($request,[
            'title' => [
                'required',
                Rule::unique('categories')->ignore($request->input('title'))->where('company_id', $request->input('company_id'))
            ]
        ]);
        $category->update($request->all());
        return response()->json([
            'title' => $category->title,
            'status' => $category->wasChanged()
        ]);
    }

    public function delete($id)
    {
        $category = Category::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
//        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'message' => "Category $category->title was deleted !!!"
        ]);

        //!!!!!  delete all history fo this category and detail history


    }

    public function upload (Request $request)
    {
        $updatedCategories = [];
        $allActiveProductsID = Arr::pluck(ShopifyData::getAllProducts(['id']), 'id');
        foreach ($request->get('value') as $id => $value) {
            if($value) {
                $terms = CategoryData::getCategoryTerms($id, $request);
//                $category = Category::find($id);
                $category = Category::where('id', $id)->where('company_id', Auth::user()->company_id)->first();
                if (($adverts = ($category->advert))->isNotEmpty()) {
                    $updatedCategories[]= $category->title;
                    $history = History::add($terms);
                    foreach ($adverts as $advert) {
                        $updates= []; //? why
                        if(in_array($advert->advert_id, $allActiveProductsID)) {
                            $product = ShopifyData::getOneProduct( $advert->advert_id, ['id', 'variants', 'title']);
                            $updates['product']['id'] = $product->id;
                            $updates['product']['title'] = $product->title;
                            foreach ($product->variants as $key => $variant) {
                                $updates['product']['variants'][$key]['id'] = $variant->id;
                                $updates['product']['variants'][$key]['title'] = $variant->title;
                                $updates['product']['variants'][$key]['old_price'] = $variant->price;
                                $updates['product']['variants'][$key]['price'] = CategoryData::updateAdvertPrice($terms, $variant->price);
                            }
                            if(ShopifyData::updateProduct($updates)) {
                                foreach ($updates['product']['variants'] as $variant) {
                                    $fields['history_id'] = $history->id;
                                    $fields['advert_name'] = $updates['product']['title'] . (($variant['title'] == 'Default Title') ? '' : ' '. $variant['title']);
                                    $fields['old_value'] = $variant['old_price'];
                                    $fields['new_value'] = $variant['price'];
                                    AdvertsHistory::add($fields);
                                }
                            }
                        }
                    }
                }
            }
        }

        $message = (empty($updatedCategories))? 'You don\'t update adverts, please insert some values, or add adverts to category' : "All adverts in ".(count($updatedCategories)>1 ? 'categories ' : 'category ').implode(', ', $updatedCategories). " updated successful";
        return redirect()->back()->with([
            'message' => $message,
            'status' => (empty($updatedCategories) ? '0' : '1')
        ]);
    }


    public function history($id)
    {
//        $histories = History::orderBy('id', 'desc')->where('category_id', $id)->paginate(config('view.per_page'));
        $histories = History::where('category_id', $id)->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->paginate(config('view.per_page'));
        return view('pages.history', ['histories' => $histories]);
    }
}
