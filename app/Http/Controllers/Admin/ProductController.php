<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Product;
use App\ProductImage;
use App\ProductVariation;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all(['id', 'name']);
        $products = Product::paginate(10);
        return view('admin.products.index', compact('categories', 'products'));
    }

    public function create() {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['description'] = '';
        $product = Product::create($data);
        flash('Produto criado com sucesso')->success();
        return redirect()->route('admin.products.edit', ['product'=>$product->id]);
    }

    public function show($id){}

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all(['id','name']);
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        if ($request->hasFile('images')) {
            $images = $request->file('images');
            if (!is_array($images)) $images = [$images];
            foreach ($images as $image) {
                $path = $image->store('products', 'public');
                $product->images()->create(['path'=>$path]);
            }
        }

        flash('Produto atualizado com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        flash('Produto removido com sucesso')->success();
        return redirect()->route('admin.products.index');
    }

    public function addVar(Request $request)
    {
        $var = ProductVariation::create($request->all());
        return ['id'=>$var->id, 'price'=>'R$ '.number_format($var->price, 2, ',', '.')];
    }

    public function destroyVar($id)
    {
        ProductVariation::destroy($id);
        return ['destroyed'=>true];
    }

    public function destroyImage($id)
    {
        $image = ProductImage::findOrFail($id);
        if (Storage::disk('public')->exists($image->path)) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
        }
        else return ['success'=>false];
        return ['success'=>true];
    }
}
