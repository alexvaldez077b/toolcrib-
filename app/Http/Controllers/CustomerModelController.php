<?php

namespace App\Http\Controllers;

use App\customerModel;
use Illuminate\Http\Request;

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
        //

        if($request->id == -1)
        {
            customerModel::create( [ 'pn'=> $request->pn, 'customer_id' => $request->customer_id ,'family' => $request->family, 'required_quantity' => $request->required_quantity ] );
        }else{
            customerModel::where( ['id' => $request->id ])->update( [ 'pn'=> $request->pn,'customer_id' => $request->customer_id, 'family' => $request->family, 'required_quantity' => $request->required_quantity, 'status' => $request->status ] );
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
        //
        $item = customerModel::where( 'id', $request->id )->first();
        return view('models.update')->with('model', $item)->with('customerId', $request->customerId);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\customerModel  $customerModel
     * @return \Illuminate\Http\Response
     */
    public function destroy(customerModel $customerModel)
    {
        //
    }
}
