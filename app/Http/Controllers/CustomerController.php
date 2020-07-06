<?php

namespace App\Http\Controllers;
use Auth;
use App\Customer;
use Illuminate\Http\Request;
use App\customerModel;
use Validator;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        $customers = Customer::All();
        return view('customers.index')->with('items',$customers);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer, Request $request )
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        /*  updateOrCreate( [data],[where]);    */

        $fileName = "";


            $validator = Validator::make($request->all(), [
                'image' => 'required|file|max:1024',
            ]);
                
            

            
            if(!$validator->fails()){

                $fileName = $request->code.time().'.'.request()->image->getClientOriginalExtension();
        
                $request->image->storeAs('public',$fileName);
            
            }else{
                $fileName = "";
            }

        if($request->id == -1)
        {
            Customer::create( [ 'name'=> $request->name, 'image' => $fileName!=""?$fileName:null ] );
        }else{
            
            
            
            $temp = Customer::where('id',$request->id)->first();

            
            Customer::where( ['id' => $request->id ])->update( [ 'name'=> $request->name, 'image' => $fileName!=""?$fileName:$temp->image , 'status' => $request->status ] );
            customerModel::where('customer_id',$request->id )->update( [ 'status' => $request->status ] );

            //call all models and edit

            


        }

        return Redirect('customers');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        //
        
        $item = Customer::where( 'id', $request->id )->first();
        return view('customers.update')->with('customer', $item);
        
            

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
