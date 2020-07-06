<?php

namespace App\Http\Controllers;

use App\User;
use App\Item;
use App\Order;
use App\Customer;
use App\customerModel;
use App\Bom;
use App\order_items;
////////////////////////////////////////
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Pusher\Laravel\Facades\Pusher;
use Illuminate\Support\Facades\DB;
use Excel;

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

        if(Auth::check()){

            $items = Item::where('status',true)->count();
            $models = customerModel::where('status',true)->count();
            $customers = Customer::where('status',true)->count();

            return view('home', [ 'items' => $items, 'models' => $models, 'customers' =>$customers ]);
        }
            
        else
            return redirect('/login');
    }

    public function excel_export(Request $request){
     $items  = DB::table('boms')
                     ->select(DB::raw('boms.quantity,items.code,customer_models.np,customers.name'))
                     ->leftJoin('items','items.id','=','boms.item_id')
                     ->leftJoin('customer_models','boms.model_id','=','customer_models.id')
                     ->leftJoin('customers', 'customer_models.customer_id','=','customers.id')
                     ->where('customers.id',$request->id)
                     ->get();
	

	//return $items->toArray();
	Excel::create('BOM', function($excel) use ($items)  {
	// Set the title
    $excel->setTitle('Toolcrib Bom');

    // Chain the setters
    $excel->setCreator('avaldezc@macktech.com')
          ->setCompany('MackTech');

    // Call them separately
    $excel->setDescription('A demonstration to change the file properties');
	$excel->sheet('Sheetname', function($sheet) use ($items) {
	


	//$sheet->fromArray($items->toArray());
	$sheet->appendRow(array('customer', 'model','item','quantity'));
        
// Sheet manipulation
	foreach($items as $row){
	$sheet->appendRow(array($row->name,$row->np,$row->code,$row->quantity));

	}


    });
	})->export('csv');
	 return redirect()->back();


    }

    public function profiles()
    {
        if(!Auth::user()->can('edit users')){
            abort(404);
        }
        //

        if(Auth::check()){
            
            $users = User::all();
            return view('users.profiles',['users'=>$users]);
    
        }
            
        else
            return redirect('/login');
    }

    

    public function login(Request $request)
    {
        if(!Auth::user()->can('auth orders')){
            abort(404);
        }
        
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

        $items = Bom::where( 'model_id',$req->model )->leftJoin('items', 'items.id','=','boms.item_id' )->get();


        //$items = Item::where('status',true)->where('code',"like","%$req->q%")->orWhere('description',"like","%$req->q%")->get();
        $elms = [];

        foreach ($items as $row) {
            # code...
            array_push($elms, array( 'id'=> $row->id, 'text' => "$row->code || $row->description" )  );

        }

        return json_encode(array( 'results' => $elms));

    }

public function filter2(Request $req)
    {
        //

        //$items = Bom::where( 'model_id',$req->model )->leftJoin('items', 'items.id','=','boms.item_id' )->get();


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
        if(!Auth::user()->can('create orders')){
            abort(404);
        }

        $data =  DB::table('orders')
                
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
        try {
            
    
            $order = Order::create([
                'name' => Auth::user()->name,
                'id_auth' => $req->auth!=-1?$req->auth:Auth::user()->id,
                'id_model' => $req->model_id,
	         'area' => $req->area,
                
                
            ]);
            
            $model = CustomerModel::where('id',$req->model_id  )->first();
            $customer = Customer::where( 'id', $model->customer_id );

            foreach ($req->items as $key => $value) {       
                $item = Item::where('id',$value['id'])->first();
                //print_r($item);
                order_items::create([
                    'id_order' => $order->id, 
                    'id_item' => $item->id,
                    'quantity' => $value['quantity'] 
                ]);

            }
            
            //send pusher notification
        
        Pusher::trigger('HOME', 'request', ['order' => $order , 'userID' => Auth::user()->id ]);
        //'name','id_auth','id_cliente','id_model','id_item','quantity','delivered','status'

            return response()->json( array('userID' => Auth::user()->id, 'order' => $order, 'model' => $model, 'customer' => $customer ));
        }catch (\Exception $exc) {
            //throw $th;
            return response()->json( array('message' => $exc ));    
        }
    }

    public function getUser(Request $request){
        if(!Auth::user()->can('edit users')){
            abort(404);
        }
        $user = User::where('id',$request->id)->first();


        if($user->hasRole('Admin')){
            $role = '1';
        }
        else if( $user->hasRole('Toolcrib') ){
            $role = '2';
        }else if( $user->hasRole('Enginner') ){
            $role = '3';
        }else if( $user->hasRole('Leader') ){
            $role = '4';
        }else if( $user->hasRole('Materialist') ){
            $role = '5';
        }else{
            $role = 0; //operator
        }

        return response()->json( ['user' => $user ,'role' => $role ]);
    }

    public function update( Request $request ){
        if(!Auth::user()->can('edit users')){
            abort(404);
        }
        

        User::where('id',$request->userid)->update([ 'name'  => $request->name,
                                                      'email' => $request->email,
                                                      'status' => $request->status?1:0
                                                         ]);
        
        
        $user = User::where('id',$request->userid)->first();
        
        //echo 'admin',$user->hasRole('Admin'); 
        
        if( $user->hasRole('Admin') )
            $user->removeRole('Admin');

        if( $user->hasRole('Toolcrib') )
            $user->removeRole('Toolcrib');
        
        if( $user->hasRole('Enginner') )
            $user->removeRole('Enginner');
        
        if( $user->hasRole('Leader') )
            $user->removeRole('Leader');
        
        if( $user->hasRole('Materialist') )
            $user->removeRole('Materialist');



        if($request->role == 1)
        {
            //asing admin
            $user->assignRole('Admin');
        }
        if($request->role == 2)
        {
            //asing admin
            $user->assignRole('Toolcrib');
        }

        if($request->role == 3)
        {
            //asing admin
            $user->assignRole('Enginner');
        }

        if($request->role == 4)
        {
            //asing admin
            $user->assignRole('Leader');
        }

        if($request->role == 5)
        {
            //asing admin
            $user->assignRole('Materialist');
        }

        if($request->cpass){
            $user->password = Hash::make($request->password);
            $user->save();
        }

        //$boxs = Box::where('status','<>',2)->get();
        return redirect()->back()->with('status', 'Updated user successfully!');
        
    }

    public function load_customer(){

        

        foreach ($customers as $key => $value) {
            # code...
            Customer::create( [ 'name'=> $value, 'image' => null ] );
        }

    }


    

}


