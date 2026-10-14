<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::orderByRaw("CASE WHEN slug = 'muc-khac' THEN 1 ELSE 0 END, id ASC")->get();
        $locations = Location::all();

        $query = Item::with(['category', 'location', 'user'])
            ->where('status', 'approved');

        // Lọc từ khóa tìm kiếm
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        // Lọc theo loại đồ vật (lost/found)
        if ($request->filled('type') && in_array($request->type, ['lost', 'found'])) {
            $query->where('type', $request->type);
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Lọc theo địa điểm
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        $items = $query->latest()->paginate(9)->withQueryString();
        $lostCount = Item::where('status', 'approved')->where('type', 'lost')->count();
        $foundCount = Item::where('status', 'approved')->where('type', 'found')->count();

        return view('items.index', compact('items', 'categories', 'locations', 'lostCount', 'foundCount'));
    }

    public function show(Item $item)
    {
        // Khách hoặc thành viên khác chỉ xem được bài approved hoặc returned
        if (!in_array($item->status, ['approved', 'returned'])) {
            if (!Auth::check() || (Auth::id() !== $item->user_id && Auth::user()->role !== 'admin')) {
                abort(403, 'Bạn không có quyền xem bài đăng này.');
            }
        }

        $item->load(['user', 'category', 'location']);
        $comments = $item->comments()->with('user')->latest()->get();

        // Bài đăng liên quan cùng danh mục hoặc địa điểm
        $relatedItems = Item::where('status', 'approved')
            ->where('id', '!=', $item->id)
            ->where(function ($q) use ($item) {
                $q->where('category_id', $item->category_id)
                  ->orWhere('location_id', $item->location_id);
            })
            ->latest()
            ->take(4)
            ->get();

        // Kiểm tra xem người dùng hiện tại đã gửi claim pending hay chưa
        $userPendingClaim = null;
        if (Auth::check()) {
            $userPendingClaim = $item->claims()
                ->where('user_id', Auth::id())
                ->where('status', 'pending')
                ->first();
        }

        return view('items.show', compact('item', 'comments', 'relatedItems', 'userPendingClaim'));
    }

    public function create()
    {
        $categories = Category::orderByRaw("CASE WHEN slug = 'muc-khac' THEN 1 ELSE 0 END, id ASC")->get();
        $locations = Location::all();

        return view('items.create', compact('categories', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:lost,found'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'event_date' => ['required', 'date', 'before_or_equal:today'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'type.required' => 'Vui lòng chọn loại tin đăng (mất đồ hoặc nhặt được).',
            'type.in' => 'Loại tin đăng không hợp lệ.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'description.required' => 'Vui lòng nhập mô tả chi tiết.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'location_id.required' => 'Vui lòng chọn địa điểm.',
            'location_id.exists' => 'Địa điểm không tồn tại.',
            'event_date.required' => 'Vui lòng chọn ngày xảy ra sự việc.',
            'event_date.date' => 'Ngày không đúng định dạng.',
            'event_date.before_or_equal' => 'Ngày không được ở tương lai.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg, png hoặc webp.',
            'image.max' => 'Ảnh tối đa 2MB.',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
        }

        Item::create([
            'user_id' => Auth::id(),
            'category_id' => $validated['category_id'],
            'location_id' => $validated['location_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'image' => $imageName,
            'event_date' => $validated['event_date'],
            'contact_info' => $validated['contact_info'] ?? null,
            'status' => 'pending',
        ]);

        return redirect()->route('profile.my-items')->with('success', 'Đăng tin thành công, vui lòng chờ duyệt.');
    }

    public function edit(Item $item)
    {
        // TC08: Kiểm tra quyền sở hữu
        abort_if($item->user_id !== Auth::id(), 403, 'Bạn không có quyền chỉnh sửa bài đăng này.');

        $categories = Category::orderByRaw("CASE WHEN slug = 'muc-khac' THEN 1 ELSE 0 END, id ASC")->get();
        $locations = Location::all();

        return view('items.edit', compact('item', 'categories', 'locations'));
    }

    public function update(Request $request, Item $item)
    {
        // TC08: Kiểm tra quyền sở hữu
        abort_if($item->user_id !== Auth::id(), 403, 'Bạn không có quyền chỉnh sửa bài đăng này.');

        $validated = $request->validate([
            'type' => ['required', 'in:lost,found'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'category_id' => ['required', 'exists:categories,id'],
            'location_id' => ['required', 'exists:locations,id'],
            'event_date' => ['required', 'date', 'before_or_equal:today'],
            'contact_info' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'type.required' => 'Vui lòng chọn loại tin đăng.',
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'description.required' => 'Vui lòng nhập mô tả.',
            'description.min' => 'Mô tả phải có ít nhất 10 ký tự.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'location_id.required' => 'Vui lòng chọn địa điểm.',
            'event_date.required' => 'Vui lòng chọn ngày xảy ra sự việc.',
            'event_date.before_or_equal' => 'Ngày không được ở tương lai.',
            'image.image' => 'Tệp tải lên phải là hình ảnh.',
            'image.max' => 'Ảnh tối đa 2MB.',
        ]);

        if ($request->hasFile('image')) {
            // Xóa ảnh cũ
            if ($item->image && file_exists(public_path('images/' . $item->image))) {
                @unlink(public_path('images/' . $item->image));
            }

            $file = $request->file('image');
            $imageName = uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $imageName);
            $item->image = $imageName;
        }

        $item->type = $validated['type'];
        $item->title = $validated['title'];
        $item->description = $validated['description'];
        $item->category_id = $validated['category_id'];
        $item->location_id = $validated['location_id'];
        $item->event_date = $validated['event_date'];
        $item->contact_info = $validated['contact_info'] ?? null;
        // Chỉnh sửa bài đăng cần quay về trạng thái pending để Admin duyệt lại
        $item->status = 'pending';
        $item->save();

        return redirect()->route('items.show', $item)->with('success', 'Cập nhật bài đăng thành công, vui lòng chờ duyệt lại.');
    }

    public function destroy(Item $item)
    {
        abort_if($item->user_id !== Auth::id(), 403, 'Bạn không có quyền xóa bài đăng này.');

        if ($item->image && file_exists(public_path('images/' . $item->image))) {
            @unlink(public_path('images/' . $item->image));
        }

        $item->delete();

        return back()->with('success', 'Đã xóa bài đăng.');
    }
}
