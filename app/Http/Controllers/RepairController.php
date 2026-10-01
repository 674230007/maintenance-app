<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Repair;
use Illuminate\Support\Facades\Auth;

class RepairController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // ถ้าเป็น Admin หรือ ช่าง ให้เห็นรายการทั้งหมด ถ้าเป็น User เห็นเฉพาะของตัวเอง
        if ($user->role === 'admin' || $user->role === 'technician') {
            $repairs = Repair::with('user')->latest()->get();
        } else {
            $repairs = Repair::with('user')->where('user_id', $user->id)->latest()->get();
        }

        return view('repairs.index', compact('repairs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('repairs', 'public');
        }

        Repair::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'status' => 'รอดำเนินการ',
        ]);

        return redirect()->route('repairs.index')->with('success', 'ส่งคำขอแจ้งซ่อมสำเร็จเรียบร้อย');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role !== 'admin' && $user->role !== 'technician') {
            abort(403, 'คุณไม่มีสิทธิ์เปลี่ยนสถานะ');
        }

        $repair = Repair::findOrFail($id);
        $repair->update(['status' => $request->status]);
        
        return redirect()->back()->with('success', 'อัปเดตสถานะเรียบร้อยแล้ว');
    }
}