<?php

namespace App\Http\Controllers;
use App\Models\TenderModel;
use App\Models\ClientModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TenderController extends Controller{

    public function tenderManage(){
        $tenderlist = TenderModel::leftJoin('clients', 'tender.c_name', '=', 'clients.id')
            ->select('tender.*', 'clients.c_name as c_name')
            ->get();

        $tenderlist->transform(function ($item) {
            unset($item->created_at, $item->updated_at);
            return $item;
        });
        $client_data = ClientModel::select('id','c_name as name')->get();
        return view('pages.tenderManage',['tenderlist'=>$tenderlist,'client_data'=>$client_data]);
    }
    // tenderadd
    public function saveTender(Request $request)
    {
        // dd($request->all());
        try {
            if ($request->tender_id) {
                $tender = TenderModel::findOrFail($request->tender_id);
            } else {
                $tender = new TenderModel();
            }

            $tender->c_name = $request->client_name;
            $tender->email = $request->email;
            $tender->phone = $request->phone;
            $tender->company_type = $request->company_type;
            $tender->gst = $request->gst;
            $tender->pan_number = $request->pan_num;

            // Handle file uploads
            if ($request->hasFile('pan_photo')) {
                $panPhoto = $request->file('pan_photo');
                $panPhotoName = Str::uuid() . '.' . $panPhoto->getClientOriginalExtension();
                $panPhotoPath = $panPhoto->storeAs('tender/pan_photos', $panPhotoName, 'public');
                $tender->pan_photo = $panPhotoPath;
            }

            $tender->start_date = $request->start_date;
            $tender->end_date = $request->end_date;
            $tender->department = $request->department;
            $tender->emd_amount = $request->emd_amount;
            $tender->tender_fees = $request->tender_fees;
            $tender->tender_expenses = $request->tender_expenses;
            $tender->accounting_no = $request->accounting_no;

            // Save the tender data
            $tender->save();

            return response()->json(['success' => 'Tender saved successfully!']);
        } catch (\Exception $e) {
            // Handle any errors
            return response()->json(['error' => 'There was an error saving the tender: ' . $e->getMessage()], 500);
        }
    }


}



