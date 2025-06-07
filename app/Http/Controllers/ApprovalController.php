<?php

namespace App\Http\Controllers;
use App\Models\ApprovalModel;

class ApprovalController extends Controller{

    public function approval(){
        $approvallist = ApprovalModel::all();
        return view('pages.approval',['data'=>$approvallist]);
    }
}



