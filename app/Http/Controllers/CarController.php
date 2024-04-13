<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'cars.';
    const PATH_UPLOAD = 'cars';
    public function index()
    {
        $data = Car::query()->with('category')->paginate(5);
        return view(self::PATH_VIEW . __FUNCTION__, compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->latest()->pluck('name', 'id')->all();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100|unique:cars',
            'brand' => 'required|max:100',
            'img' => 'nullable|image|max:2048',
            'describe' => 'required',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ]
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Car::query()->create($data);
        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Car $car)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Car $car, Category $categories)
    {
        $categories = Category::query()->latest()->pluck('name', 'id')->all();
        return view(self::PATH_VIEW . __FUNCTION__, compact('car', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Car $car)
    {
        $request->validate([
            'name' => [
                'required',
                'max:100',
                Rule::unique('cars')->ignore($car->id)
            ],
            'brand' => 'required|max:100',
            'img' => 'nullable|image|max:2048',
            'describe' => 'required',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ]
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $oldImg = $car->img;
        $car->update($data);

        if($request->hasFile('img')&&Storage::exists($oldImg)){
            Storage::delete($oldImg);
        }

        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        $car->delete();
        if(Storage::exists($car->img)){
            Storage::delete($car->img);
        }
        return back()->with('msg', 'Thao tác thành công');
    }
}
