<?php

namespace App\Http\Controllers;

use App\Category;
use App\Product;
use App\ProductVariation;
use App\Rating;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        return view('index');
    }

    public function categories()
    {
        $categories = Category::paginate(9);
        return view('categories', compact('categories'));
    }

    public function products($category)
    {
        $products = Product::where('category_id', $category)->paginate(9);
        return view('products', compact('products'));
    }

    public function ratings()
    {
        $ratings = Rating::paginate(9);
        return view('ratings', compact('ratings'));
    }

    public function single($id)
    {
        $product =  Product::findOrFail($id);
        return view('single', compact('product'));
    }

}
