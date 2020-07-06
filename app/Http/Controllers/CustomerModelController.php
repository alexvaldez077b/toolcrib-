<?php

namespace App\Http\Controllers;
use Auth;
use App\customerModel;
use App\Customer;
use Illuminate\Http\Request;
use Excel;
class CustomerModelController extends Controller
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
    public function index(Request $request)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        //
        $models = customerModel::where('customer_id',$request->id)->get();
        return view('models.index')->with('items',$models)->with('customerId', $request->id);
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
     * @param  \App\customerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function show(customerModel $customerModel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\customerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function edit(customerModel $customerModel, Request $request)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        //

        if($request->id == -1)
        {
            customerModel::create( [ 'np'=> $request->np, 'customer_id' => $request->customer_id ,'family' => $request->family, 'required_quantity' => $request->required_quantity ] );
        }else{
            customerModel::where( ['id' => $request->id ])->update( [ 'np'=> $request->np,'customer_id' => $request->customer_id, 'family' => $request->family, 'required_quantity' => $request->required_quantity, 'status' => $request->status ] );
        }
        return Redirect( )->route('customer_models', $request->customer_id) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\customerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, customerModel $customerModel)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }
        //
        $item = customerModel::where( 'id', $request->id )->first();
        return view('models.update')->with('model', $item)->with('customerId', $request->customerId);
    }

    public function updatequantity(Request $request)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }

        customerModel::where('id',$request->modelid)
        ->update( ['required_quantity' => $request->quantity] );  

        return response()->json( [ 'status' => 200 ] );
        # code...
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\customerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function uploaddemand(Request $request)
    {
        if(!Auth::user()->can('edit customer')){
            abort(404);
        }


        Excel::load($request->csv, function($reader) {
 
            $excel = $reader->get();
     	    CustomerModel::where('required_quantity','>',0)->where('customer_id','!=',16) ->update(['required_quantity'=> 0]);

            // iteracción
            
            $reader->each(function($row) {

                
                //$customer = Customer::where('name', 'like', substr( $row->customer , 0,3 ) ."%" )->first();
                //echo $customer->id,  " + ",substr( $row->customer , 0,3 )," " ,$row->model, "<br>";
                
                //$model = customerModel::create( [ 'np'=> $row->model, 'customer_id' => $customer->id ,'family' => $row->model, 'required_quantity' => $row->demand ] );
                
                /*
                }else{
                    substr( $row->customer , 0,3 );
                }
                */

                //
                    
                // 
                        //echo print_r($model);
                
                
              
                try{
                    
                    

                    $model = CustomerModel::where('np',$row->model)->first();
                    if( $model ){
                        
                        $model->required_quantity = $row->demand;

                        $model->save();

                        //echo "update: [ ",$model->np, ",", $row->demand,"] OK <br>";
                    }else{
			echo $row->model , " Error ", $row->customer, "<br>";

                        //$model = customerModel::create( [ 'np'=> $row->model, 'customer_id' => $customer->id ,'family' => $row->model, 'required_quantity' => $row->demand ] );
                        //echo print_r($model);
                        //echo  $i++," <br> ";
                    }

                }
                catch( \Exception $e ){
                    //echo "INSER: [ ",$row->model, ",", $row->demand,"] Fail <br>";
                }

                
                
                

                

                
            });
        
        });
    }
}
