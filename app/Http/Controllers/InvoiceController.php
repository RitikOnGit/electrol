<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\InvoiceModel;
use App\Models\ClientModel;
use NumberToWords\NumberToWords;
use Illuminate\Support\Facades\Auth;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller{

    public function invoiceManage(){
        $invoiceList = InvoiceModel::leftJoin('clients', 'clients.id', '=', 'invoice.customer_name')
            ->select('invoice.*', 'clients.c_name as customer_name')
            ->get();
        return view('pages.invoiceManage',['data'=>$invoiceList]);
    }
     public function invoiceadd(){
        $invoiceList = InvoiceModel::all();
        $client_data = ClientModel::select('id','c_name as name')->get();
        return view('pages.invoiceadd',['data'=>$invoiceList, 'client_data' =>$client_data]);
    }

    public function invoiceSave(Request $request){
    try {
        // dd($request->all());
        $validatedData = $request->validate([
            'invoice_number' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'invoice_date' => 'required|date',
            'pono' => 'required|numeric',
            'po_date' => 'nullable|date',
            'Against' => 'required|string|max:255',
            // 'amount.*' => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'description' => 'nullable|string',
        ]);

        $invoice = new InvoiceModel();
        $invoice->invoice_number = $validatedData['invoice_number'];
        $invoice->customer_name = $validatedData['customer_name'];
        $invoice->invoice_date = $validatedData['invoice_date'];
        $invoice->pono = $validatedData['pono'];
        $invoice->po_date = $validatedData['po_date'];
        $invoice->Against = $validatedData['Against'];
        $invoice->amt_words = $request->amtInWords;

        $invoice->save();
        // invoice transaction table
        $disc = $request->discription;
        $rowId = $request->row_id;
        $invoiceDataId = []; $totalamt = 0;
        foreach($disc as $idx => $data){
        if($rowId[$idx] === NULL || $rowId[$idx] === ''){
            $insertedId = DB::table('invoice_data')->insertGetId([
                'invoice_id' => $invoice->id,
                'description' => $data,
                'sac' => $request->sac[$idx],
                'qty' => $request->qty[$idx],
                'rate' => $request->rate[$idx],
                'discount' => $request->discount[$idx] ?? 0,
                'amt' => $request->amount[$idx],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $totalamt += $request->amount[$idx];
            $invoiceDataId[] = $insertedId;
        }else {
            DB::table('invoice_data')
                ->where('id', $rowId[$idx])
                ->update([
                    'invoice_id' => $invoice->id,
                    'description' => $data,
                    'sac' => $request->sac[$idx],
                    'qty' => $request->qty[$idx],
                    'rate' => $request->rate[$idx],
                    'discount' => $request->discount[$idx],
                    'amt' => $request->amount[$idx],
                    'updated_at' => now(),
                ]);
                $totalamt += $request->amount[$idx];
                $invoiceDataId[] = $insertedId;
            }
        }     // end invoice data table
        // $totalamt = number_format($totalamt, 2);
        InvoiceModel::where('id',$invoice->id)->update(['amount' =>$totalamt,'inv_data_id' =>$invoiceDataId]);

        return redirect()->route('invoice-management')->with('success', 'Invoice added successfully.');

    } catch (\Exception $e) {
        Log::error('Failed to save invoice: ' . $e->getMessage());
        Log::error($e->getTraceAsString());
        return back()->with('error', 'An error occurred while saving the invoice. Please check and fill all fields and try again.');
    }
}

    public function printInvoice($id)
    {
        $invoiceData = InvoiceModel::where('invoice.id', $id)
            ->leftJoin('clients', 'clients.id', '=', 'invoice.customer_name')
            ->select('invoice.*',
            'clients.c_name as customer_name',
            'clients.location as customer_address',
            'clients.comp_name',
            'clients.gst_no as cust_gst')
            ->first();

        $invData = DB::table('invoice_data')->where('invoice_id',$id)
            ->select(
                "description",
                "sac",
                "qty",
                "rate",
                "discount",
                "amt")
            ->get();

            // $invAmt = number_format((int)($invData->sum('amt')));
            $invAmt = ($invoiceData->sum('amount'));
            $amtwithgst = $invAmt;

            $numberToWords = new NumberToWords();

            // Convert the number to words (for the Indian numbering system)
            $numberTransformer = $numberToWords->getNumberTransformer('en'); // or 'en_IN' for Indian English
            $amtwithgst = $numberTransformer->toWords($amtwithgst);


            // dd($invAmt);
            // // ->setOptions(['defaultFont' => 'sans-serif']);
            // return $pdf->download('example.pdf');
        $pdf = PDF::loadView('invoicePDF', ['invoiceData' =>$invoiceData, 'invData' => $invData, 'amtwithgst' => $amtwithgst]);
        if(Auth::check()){
            return $pdf->stream();
        }else{
            return redirect('login');
        }
    }





}

