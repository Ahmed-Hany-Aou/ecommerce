<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    /**
     * Show the Admin Profile.
     */
    public function AdminProfile()
    {
        // Fetch currently authenticated admin
        $adminData = Auth::guard('admin')->user();
        return view('admin.admin_profile_view', compact('adminData'));
    }

    /**
     * Edit Admin Profile.
     */
    public function AdminProfileEdit()
    {
        // Fetch currently authenticated admin
        $editData = Auth::guard('admin')->user();
        return view('admin.admin_profile_edit', compact('editData'));
    }

    /**
     * Store updated Admin Profile.
     */
    public function AdminProfileStore(Request $request)
    {
        // Fetch currently authenticated admin
        $data = Auth::guard('admin')->user();
        $data->name = $request->name;
        $data->email = $request->email;

        if ($request->file('profile_photo_path')) {
            $file = $request->file('profile_photo_path');
            // Remove old profile photo
            @unlink(public_path('upload/admin_images/' . $data->profile_photo_path));
            $filename = date('YmdHi') . $file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'), $filename);
            $data['profile_photo_path'] = $filename;
        }
        $data->save();

        // Notification message
        $notification = [
            'message' => 'Admin Profile Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('admin.profile')->with($notification);
    }

    /**
     * Show the Change Password page.
     */
    public function AdminChangePassword()
    {
        return view('admin.admin_change_password');
    }

    /**
     * Update Admin Password.
     */
    public function AdminUpdateChangePassword(Request $request)
    {
        $validateData = $request->validate([
            'oldpassword' => 'required',
            'password' => 'required|confirmed',
        ]);

        // Get currently authenticated admin's hashed password
        $hashedPassword = Auth::guard('admin')->user()->password;
        if (Hash::check($request->oldpassword, $hashedPassword)) {
            $admin = Auth::guard('admin')->user();
            $admin->password = Hash::make($request->password);
            $admin->save();

            // Logout admin after password change
            Auth::guard('admin')->logout();
            return redirect()->route('admin.logout');
        } else {
            return redirect()->back()->withErrors(['oldpassword' => 'Old password is incorrect']);
        }
    }
}
