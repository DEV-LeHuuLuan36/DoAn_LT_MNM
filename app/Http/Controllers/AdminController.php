<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'users' => User::where('role', 'user')->count(),
            'pending_items' => Item::where('status', 'pending')->count(),
            'returned_items' => Item::where('status', 'returned')->count(),
            'pending_claims' => Claim::where('status', 'pending')->count(),
        ];

        $latestClaims = Claim::with(['item', 'user'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'latestClaims'));
    }

    public function items(Request $request)
    {
        $query = Item::with(['category', 'location', 'user']);

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'returned'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('type') && in_array($request->type, ['lost', 'found'])) {
            $query->where('type', $request->type);
        }

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $items = $query->latest()->paginate(10)->withQueryString();

        return view('admin.items.index', compact('items'));
    }

    public function updateItemStatus(Request $request, Item $item)
    {
        $request->validate([
            'status' => ['required', 'in:pending,approved,rejected,returned'],
        ]);

        $item->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Đã cập nhật trạng thái bài đăng thành công.');
    }

    public function destroyItem(Item $item)
    {
        if ($item->image && file_exists(public_path('images/' . $item->image))) {
            @unlink(public_path('images/' . $item->image));
        }

        $item->delete();

        return back()->with('success', 'Đã xóa bài đăng thành công.');
    }

    public function claims(Request $request)
    {
        $query = Claim::with(['item.category', 'item.location', 'user']);

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'])) {
            $query->where('status', $request->status);
        }

        $claims = $query->latest()->paginate(10)->withQueryString();

        return view('admin.claims.index', compact('claims'));
    }

    public function handleClaim(Request $request, Claim $claim)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected'],
            'admin_note' => ['nullable', 'string', 'max:500'],
        ]);

        DB::transaction(function () use ($claim, $request) {
            $claim->update([
                'status' => $request->status,
                'admin_note' => $request->admin_note,
            ]);

            // TC12: Nếu duyệt claim (approved), cập nhật status item thành returned và reject các pending claims khác
            if ($request->status === 'approved') {
                $claim->item->update([
                    'status' => 'returned',
                ]);

                Claim::where('item_id', $claim->item_id)
                    ->where('id', '!=', $claim->id)
                    ->where('status', 'pending')
                    ->update([
                        'status' => 'rejected',
                        'admin_note' => 'Hệ thống tự động từ chối do bài đăng đã được trao trả cho người nhận trước đó.',
                    ]);
            }
        });

        return back()->with('success', 'Đã xử lý yêu cầu nhận đồ thành công.');
    }

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->filled('role') && in_array($request->role, ['admin', 'user'])) {
            $query->where('role', $request->role);
        }

        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('email', 'like', "%{$keyword}%")
                  ->orWhere('student_code', 'like', "%{$keyword}%");
            });
        }

        $users = $query->orderBy('id', 'asc')->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function updateUser(Request $request, User $user)
    {
        // Không thể tự khóa hoặc hạ quyền chính tài khoản đang đăng nhập
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể thao tác trên chính tài khoản của mình.');
        }

        if ($request->has('toggle_lock')) {
            $user->is_locked = !$user->is_locked;
            $user->save();
            $statusText = $user->is_locked ? 'khóa' : 'mở khóa';
            return back()->with('success', "Đã {$statusText} tài khoản người dùng thành công.");
        }

        if ($request->filled('role') && in_array($request->role, ['admin', 'user'])) {
            $user->role = $request->role;
            $user->save();
            return back()->with('success', 'Đã cập nhật phân quyền người dùng thành công.');
        }

        return back();
    }

    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'Bạn không thể tự xóa tài khoản của chính mình.');
        }

        if ($user->avatar && file_exists(public_path('images/' . $user->avatar))) {
            @unlink(public_path('images/' . $user->avatar));
        }

        $user->delete();

        return back()->with('success', 'Đã xóa tài khoản người dùng thành công.');
    }
}
