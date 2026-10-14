<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $locations = Location::withCount('items')->latest()->paginate(10);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:locations,name'],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Vui lòng nhập tên địa điểm.',
            'name.unique' => 'Địa điểm này đã tồn tại trong hệ thống.',
        ]);

        Location::create($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Thêm địa điểm mới thành công.');
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:locations,name,' . $location->id],
            'description' => ['nullable', 'string'],
        ], [
            'name.required' => 'Vui lòng nhập tên địa điểm.',
            'name.unique' => 'Địa điểm này đã tồn tại trong hệ thống.',
        ]);

        $location->update($validated);

        return redirect()->route('admin.locations.index')->with('success', 'Cập nhật địa điểm thành công.');
    }

    public function destroy(Location $location)
    {
        if ($location->items()->exists()) {
            return back()->with('error', 'Không thể xóa địa điểm này vì đang có bài đăng liên kết.');
        }

        $location->delete();

        return redirect()->route('admin.locations.index')->with('success', 'Đã xóa địa điểm thành công.');
    }
}
