<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Item;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// You can alias this in config/app.php.
use Pusher\Laravel\Facades\Pusher;


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
        //Pusher::trigger('HOME', 'request', ['message' => "bienvenido ".Auth::user()->name ]);

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


}
