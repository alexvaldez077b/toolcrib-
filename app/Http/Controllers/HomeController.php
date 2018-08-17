<?php

namespace App\Http\Controllers;

use App\User;
use App\Item;
use App\Order;
use App\Customer;
use App\customerModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pusher\Laravel\Facades\Pusher;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        if(Auth::check())
            return view('home');
        else
            return redirect('/login');
    }

    public function login(Request $request)
    {
    
        
        $user = User::where('email',$request->email)->first();
       
        if ( isset($user) && Hash::check( $request->password, $user->password ) ) {
            // Authentication passed...
            return response()->json([
                'status' => true,
                'user'   => $user   
            ]);
        }
        
        else{
            return response()->json([
                'status' => false,
            ]);
        }
    
    }

    public function filter(Request $req)
    {
        //
        $items = Item::where('status',true)->where('code',"like","%$req->q%")->orWhere('description',"like","%$req->q%")->get();
        $elms = [];

        foreach ($items as $row) {
            # code...
            array_push($elms, array( 'id'=> $row->id, 'text' => "$row->code || $row->description" )  );

        }

        return json_encode(array( 'results' => $elms));

    }
        
    public function details(Request $req)
    {
        return response()->json( Item::where('id',$req->id)->first());
    }


    public function request(Request $req){


        $data =  DB::table('items')
                ->leftJoin('orders', 'items.id', '=', 'orders.id_item')
                ->where('orders.status',0)
                ->get();

        $customers = Customer::where('status',true)->get();
        
        return view('orders.request')->with('orders',$data)->with('customers',$customers);
    }

    public function getModelsbyClient(Request $req)
    {
        return response()->json( customerModel::where('customer_id',$req->id)->get() );
    }

    public function setRequest(Request $req)
    {
        
        $order = Order::create([
            'name' => $req->name,
            'id_auth' => $req->auth!=-1?$req->auth:Auth::user()->id,
            'id_cliente' => $req->client,
            'id_model' => $req->model_id,
            'id_item' => $req->item_id,
            'quantity' => $req->quantity,
            
        ]);
        
        //send pusher notification
        $item = Item::where('id',$req->item_id)->first();
        Pusher::trigger('HOME', 'request', ['order' => $order, 'item' => $item ]);



        //'name','id_auth','id_cliente','id_model','id_item','quantity','delivered','status'
        return response()->json( array('order' => $order, 'item' => $item ));
    }

    

}
