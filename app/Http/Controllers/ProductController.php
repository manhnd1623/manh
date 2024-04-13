<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'products.';
    const PATH_UPLOAD = 'products';

    public function index()
    {
        $data = Product::query()->with('category')->paginate(5);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->pluck('name', 'id')->all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'name' => 'required|max:100|unique:products',
            'price' => 'required',
            'price_sale' => 'required',
            'img' => 'nullable|image|max:2048',
            'describe' => 'required'
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Product::query()->create($data);
        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'name' => [
                'required',
                'max:100',
                Rule::unique('products')->ignore($product->id)
            ],
            'price' => 'required',
            'price_sale' => 'required',
            'img' => 'nullable|image|max:2048',
            'describe' => 'required'
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $oldImg = $product->img;
        $product->update($data);

        if($request->hasFile('img')&&Storage::exists($oldImg)){
            Storage::delete($oldImg);
        }

        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        if(Storage::exists($product->img)){
            Storage::delete($product->img);
        }
        return back()->with('msg', 'Thao tác thành công');
    }
}
