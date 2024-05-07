<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
     //index
    public function index(Request $request)
    {
        $permissions = Permission::with('user')
            ->when($request->input('name'), function ($query, $name) {
                $query->whereHas('user', function ($query) use ($name) {
                    $query->where('name', 'like', '%' . $name . '%');
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.permission.index', compact('permissions'));
    }

     //view
    public function show($id)
    {
        $permission = Permission::with('user')->find($id);
        return view('pages.permission.show', compact('permission'));
        // return view('pages.permission.show', compact('permission'));
    }

     //edit
    public function edit($id)
    {
        $permission = Permission::find($id);
        return view('pages.permission.edit', compact('permission'));
        // return view('pages.permission.edit', compact('permission'));
    }

     //update
    public function update(Request $request, $id)
    {
        $permission = Permission::find($id);
        $permission->is_approved = $request->is_approved;
        $str = $request->is_approved == 1 ? 'Disetujui' : 'Ditolak';
        $permission->save();
        // $this->sendNotificationToUser($permission->user_id, 'Status Izin anda adalah ' . $str);
        return redirect()->route('permisions.index')->with('success', 'Permission updated successfully');
    }


     // Method untuk menghapus izin
    public function destroy($id)
    {
         $permission = Permission::findOrFail($id); // Mencari izin berdasarkan ID
         $permission->delete(); // Menghapus izin dari database
        return redirect()->route('permisions.index')->with('success', 'Permission deleted successfully');
    }
    // public function sendNotificationToUser($userId, $message)
    // {
    //      // Dapatkan FCM token user dari tabel 'users'

    //     $user = User::find($userId);
    //     $token = $user->fcm_token;

    //      // Kirim notifikasi ke perangkat Android
    //     //  $messaging = app('firebase.messaging');
    //     //  $notification = Notification::create('Status Izin', $message);

    //     //  $message = CloudMessage::withTarget('token', $token)
    //     //      ->withNotification($notification);

    //     //  $messaging->send($message);
    // }
}
