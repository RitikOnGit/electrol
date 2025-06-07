<?php

namespace App\Http\Controllers;
use App\Models\StockItem;
use App\Models\ProductModel;
use App\Models\StaffManage;
use App\Models\SiteManage;
use App\Models\CashManage;
use App\Models\ClientModel;
use App\Models\PurchaseOrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class StockManagementController extends Controller{

     public function ProductManage(){
        $productList = ProductModel::all();
        return view('pages.ProductManage',['product_data'=>$productList]);
    }
     public function productSave(Request $request)
     {
        // dd($request->all());
        $request->validate([
            'pname' => 'required|string|max:255',
            'product_price' => 'required|numeric',
        ]);

        if ($request->product_id) {
            $product = ProductModel::findOrFail($request->product_id);
        } else {
            $product = new ProductModel();
        }
        $product->name = $request->pname;
        $product->price = $request->product_price;
        $product->unit = $request->units;
        $product->save();

        return response()->json(['success' => 'Product Added successfully'], 200);
    }

    public function productShow($id)
    {
        $product = ProductModel::where('status','Active')->find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    // stock management
    public function stockManage(){
        $stockItems = StockItem::all();
        $stockItems = DB::table('stock_item')
        ->leftJoin('staff_management', function($join) {
            $join->on('stock_item.siteSuperviser', '=', 'staff_management.id');
                //  ->where('staff_management.status', '=', 'active');
        })
        ->leftJoin('products', 'stock_item.name', '=', 'products.id')
        ->leftJoin('site_management', 'stock_item.siteName', '=', 'site_management.id')
        ->select(
            'stock_item.*',
            'products.name as product_name',
            'staff_management.name as siteSuperviser',
            'site_management.site_name as siteName',
        )
        ->get();
        // dd($stockItems1);
        $emp_name = StaffManage::where('role','!=', '')->select('id', 'name')->get();
        $site_data = SiteManage::select('id', 'site_name')->get();
        $productData = ProductModel::where('status','Active')->select("id","name","price","unit")->get();
        return view('pages.stockManage',['data_list'=>$stockItems,'superviser'=>$emp_name,'site_data'=>$site_data,'productData'=>$productData]);
    }
    public function show($id)
    {
        $product = StockItem::where('status','Active')->find($id);
        if ($product) {
            return response()->json($product);
        } else {
            return response()->json(['error' => 'Product not found'], 404);
        }
    }

    public function save(Request $request)
    {
        // $request->validate([
        //     'pname' => 'required|string|max:255',
        //     'amt' => 'required|numeric',
        //     'qty' => 'required|date',
        // ]);

        if ($request->product_id) {
            $product = StockItem::findOrFail($request->product_id);
        } else {
            $product = new StockItem();
        }
        // dd($request->all());
        $product->name = $request->pname;
        $product->amt = intval($request->product_price);
        $product->quantity = intval($request->product_qty);
        $product->siteName = $request->siteName;
        $product->siteLocation = $request->siteLocation;
        $product->siteSuperviser = $request->siteSuperviser;
        $product->save();

        return redirect()->back()->with('success', 'Product saved successfully!');
    }

    // cash management
    public function cashManage(){
        $emp_name = StaffManage::where('role', '!=', '')->get();
        $site_data = SiteManage::get();
        // $cash_data = CashManage::get();
        $cash_data = DB::table('cash_manage')
        ->leftJoin('staff_management', 'cash_manage.emp_name', '=', 'staff_management.id')
        ->leftJoin('site_management', 'cash_manage.site_name', '=', 'site_management.id')
        ->select(
            'cash_manage.*',
            'staff_management.name as emp_name',
            'site_management.site_name as site_name'
        )
        ->get();
        return view('pages.cashManage', ['cashData' => $cash_data, 'emp_data' => $emp_name, 'site_data' => $site_data]);
    }
    public function cashEdata($id)
    {
        $cashManage = CashManage::where('status','Active')->find($id);
        if ($cashManage) {
            return response()->json($cashManage);
        } else {
            return response()->json(['error' => 'Not found or something went wrong'], 404);
        }
    }
    public function addCashManage(Request $request)
    {
        try {
            if ($request->cm_id) {
                $cashManage = CashManage::findOrFail($request->cm_id);
            } else {
                $cashManage = new CashManage();
            }
            $cashManage->alloted_amt = floatval($request->alloted_amt);
            $cashManage->emp_name = $request->emp_name;
            $cashManage->expense_amt = floatval($request->exp_amount);
            $cashManage->site_name = $request->siteName;
            $cashManage->remark = $request->remark;
            $cashManage->save();

            return response()->json(['success' => 'Added successfully'], 200);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'There was an error saving the product: ' . $e->getMessage());
        }
    }



// purchase order
    public function Purchaseorder(){
        $client_data = ClientModel::select('id','c_name as name')->get();
        $emp_name = StaffManage::where('role','!=', '')->select('id', 'name')->get();
        $site_data = SiteManage::select('id', 'site_name')->get();
        $productData = ProductModel::where('status','Active')->select("id","name","price","unit")->get();
        $purchaseOrder_data = DB::table('purchase_order')
        ->leftJoin('staff_management', function($join) {
            $join->on('purchase_order.siteSuperviser', '=', 'staff_management.id');
                //  ->where('staff_management.status', '=', 'active');
        })
        ->leftJoin('products', 'purchase_order.product_id', '=', 'products.id')
        ->leftJoin('site_management', 'purchase_order.siteName', '=', 'site_management.id')
        ->leftJoin('clients', 'purchase_order.client_name', '=', 'clients.id')
        ->select(
            'purchase_order.*',
            'products.name as product_name',
            'staff_management.name as siteSuperviser',
            'site_management.site_name as siteName',
            'clients.c_name as client_name'
        )
        ->get();
        // dd($purchaseOrder_data);
    return view('pages.Purchaseorder',['purchaseOrder_data' => $purchaseOrder_data,'client_data' =>$client_data ,'productData'=>$productData,'emp_data'=>$emp_name, 'site_data'=>$site_data]);
    }

    public function addPurchaseorder(Request $request)
    {
        try {
            // dd($request->all());
            $validated = $request->validate([
                'start_date' => 'required|date',
            ]);
            $startDate = $validated['start_date'];

            if ($request->order_id) {
                $purchaseManage = PurchaseOrderModel::findOrFail($request->order_id);
            } else {
                $purchaseManage = new PurchaseOrderModel();
                $lastOrderNo = PurchaseOrderModel::max('order_no');
                $newOrderNo = $lastOrderNo ? $lastOrderNo + 1 : 1000;
                $purchaseManage->order_no = $newOrderNo;
            }
            $purchaseManage->siteName = $request->siteName;
            $purchaseManage->siteSuperviser = $request->siteSuperviser;
            $purchaseManage->client_name = $request->client_name;
            $purchaseManage->product_id = $request->product_name;
            $purchaseManage->quantity = $request->quantity;
            $purchaseManage->total_price = floatval($request->total_price);
            $purchaseManage->remark = $request->remark;
            $purchaseManage->start_date = $startDate;
            $purchaseManage->save();

            return response()->json(['success' => 'Added successfully'], 200);

        } catch (\Exception $e) {
            \Log::error('Error:', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'There was an error saving the product: ' . $e->getMessage()], 500);
        }
    }

    public function printPurorder($id){
        $pdfData = PurchaseOrderModel::where('purchase_order.id', $id)
            ->leftJoin('clients', 'clients.id', '=', 'purchase_order.client_name')
            ->leftJoin('site_management', 'purchase_order.siteName', '=', 'site_management.id')
            ->leftJoin('staff_management', function($join) {
                $join->on('purchase_order.siteSuperviser', '=', 'staff_management.id');
                    //  ->where('staff_management.status', '=', 'active');
            })
            ->leftJoin('products', 'purchase_order.product_id', '=', 'products.id')
            ->select('purchase_order.*',
            'clients.c_name as client_name',
            'site_management.site_name as siteName',
            'staff_management.name as siteSuperviser',
            'products.name as product_name',
            'products.price as rate',
            'products.unit',
            'clients.location as client_address',
            'clients.comp_name')
            ->first();

        // $invData = DB::table('invoice_data')->where('invoice_id',$id)
        //     ->select(
        //         "description",
        //         "sac",
        //         "qty",
        //         "rate",
        //         "discount",
        //         "amt")
        //     ->get();

            // $invAmt = number_format((int)($invData->sum('amt')));
            // $invAmt = ($pdfData->sum('amount'));
            // $amtwithgst = $invAmt;

            // $numberToWords = new NumberToWords();

            // Convert the number to words (for the Indian numbering system)
            // $numberTransformer = $numberToWords->getNumberTransformer('en'); // or 'en_IN' for Indian English
            // $amtwithgst = $numberTransformer->toWords($amtwithgst);

            // $pdf = PDF::loadView('purchaseOrderPDF', ['pdfData' =>$pdfData, 'invData' => $invData, 'amtwithgst' => $amtwithgst]);
            $pdf = PDF::loadView('purchaseOrderPDF',['pdfData' =>$pdfData]);
            return $pdf->stream();
        // return view('purchaseOrderPDF');
    }

}
