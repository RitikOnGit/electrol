<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;

class PDFController extends Controller
{
    public function generatePDF()
    {
        $data = ['title' => 'Welcome to Laravel PDF Example'];
        $pdf = PDF::loadView('myPDF', $data);

        // dd($data);
        // return $pdf->download('example.pdf');
        return $pdf->stream();
    }
}
