<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    //index
    public function index(Request $request)
    {
        $attendances = Attendance::with('user')
            ->when($request->input('name'), function($query, $name) {
                $query->whereHas('user', function($query) use ($name) {
                    $query->where('name', 'like', "%.$name.%");
                });
            })->orderBy('id', 'desc')->paginate(10);
        return view('pages.absensi.index', compact('attendances'));
    }

    //edit
        // Metode untuk menampilkan formulir pengeditan data kehadiran
        public function edit($id)
        {
            $attendance = Attendance::findOrFail($id); // Menemukan data kehadiran berdasarkan ID
            return view('pa', compact('attendance')); // Menampilkan formulir pengeditan dengan data kehadiran yang ditemukan
        }
}
