<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController1 extends Controller
{
    // Hiển thị form chỉnh sửa thông tin người dùng
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:2|regex:/^[\p{L}\s]+$/u',
            'phone' => 'required|string|min:10|regex:/^[0-9\s]+$/',
            'email' => 'required|email',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Cập nhật thông tin
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->email = $request->email;

        // Xử lý avatar nếu có upload
        if ($request->hasFile('avatar')) {
            $oldAvatarPath = $user->getOriginal('avt');
            if ($oldAvatarPath && Storage::disk('public')->exists($oldAvatarPath)) {
                Storage::disk('public')->delete($oldAvatarPath);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avt = $avatarPath;
        }

        $user->save();

        return redirect()->back()->with('success', 'Thông tin đã được cập nhật thành công!');
    }

}