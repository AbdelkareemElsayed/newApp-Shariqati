<?php

namespace App\Http\Controllers\invoices;

use App\Http\Controllers\Settings\settingsController;
use App\Http\Controllers\Controller;
use App\Models\dashboard\Branches\branch;
use App\Models\dashboard\invoices\invoice;
use Illuminate\Http\Request;
use App\Models\dashboard\items\items;
use App\Models\User;
use App\Models\dashboard\items\ItemsFlashsale;
use PDF;

class invoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $items =  items::wherehas('itemsDetails', function ($item) {
            $item->where('language', session()->get('lang'));
        })->get();

        $data = invoice::with('items.itemsDetails', 'userDetails', 'adminDetails','branchDetails')->get();
        $branchs = branch :: get(); 

        return view('dashboard.invoice.index', ['items' => $items, 'data' => $data , 'branchs' => $branchs]);
    }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $data = $this->validate($request, [
            'item_id'      => 'required',
            'quantity'     => 'required',
            'invoice_type' => 'required',
            'phone'        => 'required',
            'name'         => 'required',
            'branch_id'    => 'required' 
        ]);

        // GET ITEM DATA . . .
        $item = items::find($data['item_id']);

        // GET USER DATA . . .
        $total = $item->price * $data['quantity'];

        // Get falshsale data . . .

        $falshsale = ItemsFlashsale::where('item_id', $data['item_id'])->where('quantity',$data['quantity'])->first();

        # check Flashsale . . .

         if ($falshsale) {
           $data['discount_value'] = $falshsale->price;
           $data['discount_type']  = $falshsale->type;
          }


        $userdata =  User::where(['phone' => $data['phone'], 'name' => $data['name']])->get();

        if (count($userdata) == 1) {
            $user_id = $userdata[0]->id;
        } else {

            // insert user data
            $user =   user::create(['phone' => $data['phone'], 'name' => $data['name']]);
            $user_id = $user->id;
        }

        invoice::create(['user_id' => $user_id, 'admin_id' => auth('admin')->user()->id, 'item_id' => $request->item_id, 'price' => $item->price, 'quantity' => $data['quantity'], 'total' => $total, 'invoice_type' => $data['invoice_type'], 'time' => time(),'discount_value'=> $data['discount_value'] , 'discount_type'=> $data['discount_type'] , 'branch_id' => $data['branch_id']]);


        return redirect(aurl('Invoice'));
    }

   ###################################################################################################################################
   
   public static function generate_pdf($id)
     {

        # Get the invoice data
        $invoice =  invoice::with('items.itemsDetails', 'userDetails', 'adminDetails')->whereId($id)->get();
        
        # Get Company Data . . .
        $companyInfo = settingsController :: loadCompanyInfo();
         
        $pdf = PDF::loadView('dashboard.invoice.pdf.invoice', ['data' => $invoice , 'companyInfo' => $companyInfo]);
        
        return $pdf->stream('invoice');
    }

    ###################################################################################################################################
}
