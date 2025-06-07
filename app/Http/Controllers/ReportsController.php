<?php

namespace App\Http\Controllers;
use App\Models\ReportsModel as reportsdata;

class ReportsController extends Controller{

    public function reports(){
        $approvallist = reportsdata::all();
        return view('pages.reports',['data'=>$approvallist]);
    }
}



