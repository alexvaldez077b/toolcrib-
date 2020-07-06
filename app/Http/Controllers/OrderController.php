<?php

namespace App\Http\Controllers;
use Auth;
use App\Order;
use App\order_items;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Pusher\Laravel\Facades\Pusher;

class OrderController extends Controller
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
        if(!Auth::user()->can('edit orders')){
            abort(404);
        }
        //
        $data =  DB::table('orders')
                ->select('orders.created_at','orders.area', 'customers.name', 'customer_models.np', 'orders.id', 'orders.name as user' )
                ->Join('customer_models', 'orders.id_model','=','customer_models.id')
                ->Join('customers', 'customer_models.customer_id','=','customers.id')
                ->where('orders.status',0)
                ->get();

        return view('orders.index')->with('orders',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function close(Order $order)
    {
     
        
        if(!Auth::user()->can('edit orders')){
            abort(404);
        }
        //

        $status = true;
        $items = order_items::where('id_order',$order->id)->get();

        foreach ($items as $records) {
            # code...
            if(is_null($records->delivered)){

                return back()->with('status', 'Please deliver all requested items!');;

            }
        }
        
        $order->status = 1;

        $order->save();
        
        
        Pusher::trigger('HOME', 'close-orders', ['order' => $order ]);
        return back()->with('status', 'Order updated!');;
        //return response()->json( [ 'status' => true ] );
        
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
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req)
    {
        if(!Auth::user()->can('edit orders')){
            abort(404);
        }
        //
        /*
        SELECT   FROM toolcrib.orders 
        left join items on items.id = orders.id_item
        left join customer_models on customer_models.id = orders.id_model
        left join users on users.id = orders.id_auth
        where orders.created_at between "2018-12-04" and now()
        */
        $orders = order_items::select(DB::raw('orders.*,items.code,order_items.id as itemID,order_items.delivered,items.description,order_items.status as reg ,customer_models.np, customers.name as cliente, users.name as auth, timediff(order_items.updated_at, order_items.created_at) as delivery_time'))
        ->leftJoin('orders','orders.id','=','order_items.id_order')
        ->leftJoin('items','items.id','=','order_items.id_item')
        ->leftJoin("customer_models" , 'customer_models.id', '=', 'orders.id_model')
        ->leftJoin('customers' , 'customers.id', '=', 'customer_models.customer_id')
        ->leftJoin('users' , 'users.id' ,'=', 'orders.id_auth')
        ->where('orders.status',1)
        ->whereBetween('orders.created_at', [ $req->start? $req->start : date('Y-m-d 00:00'),$req->end?$req->end:date('Y-m-d 23:59:59') ])
        ->get();

        return view('orders.history', ['orders' =>$orders ] );

        



    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        if(!Auth::user()->can('edit orders')){
           // abort(404);
        }
        
        order_items::where('id', $request->id)->update([ 'status' => 1 ]);
        
	    return back()->with('status', 'Order updated!');;


    }
    public function view(Order $order)
    {
        //
        $items = order_items::where('id_order', $order->id )
        ->leftJoin( 'items', 'order_items.id_item', '=','items.id' )
        ->get();

        return view('orders.vieworder', ['items' => $items, 'order' => $order]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
