<?php

namespace App\Http\Controllers\Api\ecommerceModules;

use App\Http\Controllers\Controller;
use App\Models\ecommerceModels\productsCategory\category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    
    public function index($lang, $limit)
    {
        $categories = category::with('description')->where('parent_id', 0)->orderBy('id', 'desc');

        if ($limit > 0) {
            $categories = $categories->paginate($limit);
        } else {
            $categories->get();
        }

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $categories], 200);
    }


    public function subCategories($category_id, $limit)
    {
        $categories = category::with('description')->where('parent_id', $category_id)->orderBy('id', 'desc')->paginate($limit);

        return response()->json(['success' => __('admin.data_fetched'), 'data' => $categories], 200);
    }


    public function categoryProducts($category_products, $limit)
    {
        $products = category::with('products')->orderBy('id', 'desc')->get();
        return response()->json(['products' => $products]);
    }

}