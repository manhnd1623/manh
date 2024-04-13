<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class DeviceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    const PATH_VIEW = 'devices.';
    const PATH_UPLOAD = 'devices';

    public function index()
    {
        $data = Device::query()->with('category')->paginate(5);;
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
            'name' => 'required|max:100',
            'serial' => 'required|max:100|unique:devices',
            'model' => 'required|max:100',
            'img' => 'nullable|image|max:2048',
            'is_active' => [
                'required',
                Rule::in([
                    Device::ACTIVE,
                    Device::INACTIVE
                ])
            ],
            'describe' => 'nullable'
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        Device::query()->create($data);

        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $request->validate([
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'name' => 'required|max:100',
            'serial' => [
                'required',
                'max:100',
                Rule::unique('devices')->ignore($device->id)
            ],
            'model' => 'required|max:100',
            'img' => 'nullable|image|max:2048',
            'is_active' => [
                'required',
                Rule::in([
                    Device::ACTIVE,
                    Device::INACTIVE
                ])
            ],
            'describe' => 'nullable'
        ]);

        $data = $request->except('img');

        if($request->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, $request->file('img'));
        }

        $oldImg = $device->img;
        $device->update($data);

        if($request->hasFile('img')&&Storage::exists($oldImg)){
            Storage::delete($oldImg);
        }

        return back()->with('msg', 'Thao tác thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $device->delete();
        if(Storage::exists($device->img)){
            Storage::delete($device->img);
        }
        return back()->with('msg', 'Thao tác thành công');
    }
}
