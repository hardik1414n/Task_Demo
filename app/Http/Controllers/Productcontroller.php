<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Product;
use Illuminate\Http\Request;

class Productcontroller extends Controller
{
    public function index(){
        $data = Product::where('unit',">",0)->get();

        return view('welcome',['data'=>$data]);
    }

    public function select_product(Request $request)
    {
        $data = Product::find($request->id);

        return response()->json($data);
    }

    public function getsession(){

        $name = "Hello 7";

        $age = "21";

        $arr = [];

        $value = ['name'=>$name,'age'=>$age];

        if(session()->has('values'))
        {
            $val = session()->get('values');

            array_push($val,$value);
            session()->put('values',$val);

            echo "In If";



        }
        else
        {
            array_push($arr,$value);

            echo "In Else";
            session()->put('values',$arr);
            // dd(session()->get('values'));
        }


    }

    public function show_session(){
        return view('task');

    }

    public function remove(){
        if(session()->has('values'))
        {
            $val = session()->get('values');
            unset($val[2]);
            $set_val = array_values($val);
            session()->put('values',$set_val);
            echo "<h1>Unset SuccessFully</h1>";
        }
        else
        {
            echo "<h1>Nothing To Remove</h1>";
        }

    }

    public function add_product(Request $request)
    {
        $arr = [];
        $value = [
            'name'=>$request->name,
            'product'=>$request->product,
            'rate'=>$request->rate,
            'unit'=>$request->unit,
            'qty'=>$request->qty,
            'discount'=>$request->discount,
            'net_amount'=>$request->net_amount,
            'total_amount'=>$request->total_amount
        ];

        if(session()->has('data'))
        {
            $values = session()->get('data');

            array_push($values,$value);
            session()->put('data',$values);
            return 1;
        }
        else
        {
            array_push($arr,$value);

            session()->put('data',$arr);

            return 1;
        }


    }



    public function remove_product(Request $request)
    {
        if(session()->has('data'))
        {
            $val = session()->get('data');
            unset($val[$request->index]);
            $set_val = array_values($val);
            session()->put('data',$set_val);
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function edit_product(Request $request)
    {
        if(session()->has('data'))
        {
            $data = session()->get('data');

            $data[$request->index_id]['product'] = $request->product;
            $data[$request->index_id]['rate'] = $request->rate;
            $data[$request->index_id]['unit'] = $request->unit;
            $data[$request->index_id]['qty'] = $request->qty;
            $data[$request->index_id]['discount'] = $request->discount;
            $data[$request->index_id]['net_amount'] = $request->net_amount;
            $data[$request->index_id]['total_amount'] = $request->total_amount;

            session()->put('data',$data);
            return 1;
        }
    }

    public function store_invoice(Request $request){
        // $key = 'gozhi';
        // $sum = array_sum(array_column($array,$key));

        //str_pad($str,3,0,STR_PAD_LEFT);

        // $data = session()->get('data');

        // $sum = array_sum(array_column($data,"total_amount"));

        // return $sum;



        if(session()->has('data'))
        {
            $data = session()->get('data');
            $sum = array_sum(array_column($data,"total_amount"));

            $check = Invoice::latest()->first();

            if($check !="")
            {
                $invoiceNo = $check['invoice_no'] +1;

                $invoiceNo = str_pad($invoiceNo,3,0,STR_PAD_LEFT);
            }
            else{
                $invoiceNo = str_pad(1,3,0,STR_PAD_LEFT);
            }



            $store = new Invoice;

            $store->invoice_no = $invoiceNo;
            $store->invoice_date = date('Y-m-d');
            $store->customer_name = $data[0]['name'];
            $store->total_amount = $sum;

            if($store->save()){

                foreach($data as $value)
                {
                    $invoice = new InvoiceDetail;

                    $invoice->invoice_id = $store->id;
                    $invoice->product_id = $value['product'];
                    $invoice->rate = $value['rate'];
                    $invoice->unit = $value['unit'];
                    $invoice->qty = $value['qty'];
                    $invoice->disc_percentage = $value['discount'];
                    $invoice->net_amount = $value['net_amount'];
                    $invoice->total_amount = $value['total_amount'];

                    $invoice->save();
                }

                session()->forget('data');
                return 1;
            }
            else
            {
                return 0;
            }

        }
    }

}