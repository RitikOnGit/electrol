<?php

namespace App\Http\Controllers;

class DashboardController extends Controller{
    public function index(){
        return view('index');
    }



    public function tenderManage(){
        return view('pages.tenderManage');
    }

    public function clientManage(){
        return view('pages.clientManage');
    }

    public function approval(){
        return view('pages.approval');
    }

    public function reports(){
        return view('pages.reports');
    }
}
