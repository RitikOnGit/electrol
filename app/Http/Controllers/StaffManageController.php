<?php

namespace App\Http\Controllers;

use App\Models\StaffManage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaffManageController extends Controller
{

    public function staffManage()
    {
        $stafflist = StaffManage::all();
        return view('pages.staffManage', ['data' => $stafflist]);
    }

    public function show($id)
    {
        $product = StockItem::where('status', 'Active')->find($id);

        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function save(Request $request)
    {

        $request->validate([
            'staff_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'aadhar' => 'required|string',
            'pan_num' => 'nullable|string',
            // 'aadhar_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'pan_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->staff_id) {
            $staff = StaffManage::findOrFail($request->staff_id);
        } else {
            $staff = new StaffManage();
        }

        $staff->name = $request->staff_name;
        $staff->email = $request->email;
        $staff->phone = $request->phone;
        $staff->role = $request->role;
        $staff->aadhar_number = $request->aadhar;
        $staff->pan_number = $request->pan_num;

        if ($request->hasFile('aadhar_photo')) {
            $aadharPhoto = $request->file('aadhar_photo');
            $aadharPhotoName = Str::uuid() . '.' . $aadharPhoto->getClientOriginalExtension();
            $aadharPhotoPath = $aadharPhoto->storeAs('aadhar_photos', $aadharPhotoName, 'public');
            $staff->aadhar_photo = $aadharPhotoPath;
        }

        if ($request->hasFile('pan_photo')) {
            $panPhoto = $request->file('pan_photo');
            $panPhotoName = Str::uuid() . '.' . $panPhoto->getClientOriginalExtension();
            $panPhotoPath = $panPhoto->storeAs('pan_photos', $panPhotoName, 'public');
            $staff->pan_photo = $panPhotoPath;
        }
        $staff->save();

        return redirect()->back()->with('success', 'Staff saved successfully!');
    }

    public function edit()
    {
        $stafflist = StaffManage::all();
        return view('pages.staffManage', ['data' => $stafflist]);
    }
}
