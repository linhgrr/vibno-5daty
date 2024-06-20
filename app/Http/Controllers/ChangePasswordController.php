<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function showChangePasswordForm()
    {
        return view('auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current-password' => 'required',
            'new-password' => 'required|min:8|confirmed',
        ]);

        $currentPassword = Auth::user()->password;

        if (!Hash::check($request->input('current-password'), $currentPassword)) {
            return redirect()->back()->with('error', 'Mật khẩu hiện tại không đúng.');
        }

        Auth::user()->update(['password' => Hash::make($request->input('new-password'))]);

        return redirect()->back()->with('success', 'Đổi mật khẩu thành công.');
    }
}
