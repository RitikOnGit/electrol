<?php

namespace App\Http\Controllers;
use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientController extends Controller{

    public function clientManage(){
        $clientlist = ClientModel::all();
        return view('pages.clientManage',['data'=>$clientlist]);
    }

    public function show_edit($id)
    {
        $client = ClientModel::where('status','Active')->find($id);
        if ($client) {
            return response()->json($client);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }
    public function save(Request $request){
    // dd($request->all());
        $request->validate([
            'client_name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'pan_num' => 'nullable|string',
        ]);

        if ($request->staff_id) {
            $client = ClientModel::findOrFail($request->client_id);
        } else {
            $client = new ClientModel();
        }

        $client->c_name = $request->client_name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->location = $request->location;
        $client->pan_no = $request->pan_num;
        $client->gst_no = $request->gst_no;
        $client->comp_type = $request->comp_type;
        $client->comp_name = $request->comp_name;

        if ($request->hasFile('pan_photo')) {
            $panPhoto = $request->file('pan_photo');
            $panPhotoName = Str::uuid() . '.' . $panPhoto->getClientOriginalExtension();
            $panPhotoPath = $panPhoto->storeAs('client_pan/pan_photos', $panPhotoName, 'public');
            $client->pan_photo = $panPhotoPath;
        }
        $client->save();

        return response()->json(['success' => 'Client saved successfully!']);
    }

}



