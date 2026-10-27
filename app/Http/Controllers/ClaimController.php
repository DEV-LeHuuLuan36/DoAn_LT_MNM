<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    public function store(Request $request, Item $item)
    {
        // Chỉ cho phép gửi yêu cầu nhận đồ đối với bài đăng Đồ nhặt được (found)
        if ($item->type !== 'found') {
            return back()->with('error', 'Chức năng yêu cầu nhận đồ chỉ áp dụng cho bài đăng Đồ nhặt được.');
        }

        // Không cho phép chủ bài đăng tự gửi claim nhận đồ của chính mình
        abort_if($item->user_id === Auth::id(), 403, 'Bạn không thể gửi yêu cầu nhận lại cho chính bài đăng của mình.');

        // Chỉ cho phép claim bài đăng đang approved
        abort_if($item->status !== 'approved', 404, 'Bài đăng không ở trạng thái nhận yêu cầu.');

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:20', 'max:1000'],
        ], [
            'message.required' => 'Vui lòng nhập mô tả đặc điểm chứng minh sở hữu.',
            'message.min' => 'Mô tả đặc điểm chứng minh phải có ít nhất 20 ký tự.',
            'message.max' => 'Mô tả không được vượt quá 1000 ký tự.',
        ]);

        // TC11: Kiểm tra trùng lặp
        $existingClaim = Claim::where('item_id', $item->id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();

        if ($existingClaim) {
            return back()->with('error', 'Bạn đã gửi yêu cầu cho bài đăng này.');
        }

        Claim::create([
            'item_id' => $item->id,
            'user_id' => Auth::id(),
            'message' => $validated['message'],
            'status' => 'pending',
            'admin_note' => null,
        ]);

        return back()->with('success', 'Đã gửi yêu cầu, chờ xác nhận.');
    }

    public function destroy(Claim $claim)
    {
        // Cho phép người dùng hủy claim đang pending của chính mình
        abort_if($claim->user_id !== Auth::id(), 403, 'Bạn không có quyền hủy yêu cầu này.');
        abort_if($claim->status !== 'pending', 400, 'Chỉ có thể hủy yêu cầu đang ở trạng thái chờ duyệt.');

        $claim->delete();

        return back()->with('success', 'Đã hủy yêu cầu nhận đồ.');
    }
}
