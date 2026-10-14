<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'student_code' => ['nullable', 'string', 'max:20'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'current_password' => ['nullable', 'string'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'avatar.image' => 'Ảnh đại diện phải là tệp hình ảnh.',
            'avatar.mimes' => 'Ảnh đại diện phải có định dạng jpg, jpeg, png hoặc webp.',
            'avatar.max' => 'Ảnh đại diện dung lượng tối đa 2MB.',
            'password.min' => 'Mật khẩu mới phải có ít nhất 6 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu mới không trùng khớp.',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'] ?? null;
        $user->student_code = $validated['student_code'] ?? null;

        // Xử lý upload avatar
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            $avatarName = 'avatar_' . uniqid() . '.' . $avatarFile->getClientOriginalExtension();

            // Xóa ảnh cũ nếu có
            if ($user->avatar && file_exists(public_path('images/' . $user->avatar))) {
                @unlink(public_path('images/' . $user->avatar));
            }

            $avatarFile->move(public_path('images'), $avatarName);
            $user->avatar = $avatarName;
        }

        // Xử lý đổi mật khẩu (F10)
        if (!empty($validated['password'])) {
            if (empty($validated['current_password'])) {
                return back()->withErrors(['current_password' => 'Vui lòng nhập mật khẩu hiện tại để đổi mật khẩu mới.']);
            }
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'Mật khẩu hiện tại không chính xác.']);
            }
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Cập nhật thông tin cá nhân thành công!');
    }

    public function myItems()
    {
        $items = Item::with(['category', 'location'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('profile.my-items', compact('items'));
    }

    public function myClaims()
    {
        $claims = Claim::with(['item.category', 'item.location'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('profile.my-claims', compact('claims'));
    }
}
