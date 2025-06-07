<?php

namespace App\Http\Controllers;
use App\Models\SiteManage;
use App\Models\StaffManage;
use App\Models\ClientModel;
use Illuminate\Http\Request;

class SiteManagerController extends Controller{

    public function siteManage(){
        $sitelist = SiteManage::all();
        $superViserlist = StaffManage::all();
        $clientList = ClientModel::all();
        return view('pages.siteManage',['data'=>$sitelist ,'supVis' => $superViserlist, 'clientList' => $clientList]);
    }

    public function save(Request $request)
    {
        // dd($request->all());
        $request->validate([
            // 'staff_name' => 'required|string|max:255',
        ]);

        if ($request->site_id) {
            $site = SiteManage::findOrFail($request->site_id);
        } else {
            $site = new SiteManage();
        }

        $site->site_name = $request->name;
        $site->location = $request->location;
        $site->superviser = $request->superviser;
        $site->start_date = $request->start_date;
        $site->end_date = $request->end_date;
        $site->department = $request->department;
        $site->client = $request->client_name;

        $site->save();

        return redirect()->back()->with('success', 'Staff saved successfully!');
    }
}

