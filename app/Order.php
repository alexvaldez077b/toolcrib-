<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [ 'name','id_auth','id_cliente','id_model','id_item','area','quantity','delivered','status'];
    /*
    ('name'); //quien
    ('id_auth');    
    ('id_cliente');
    ('id_model');
    ('id_item');
    ('quantity')->default(0);
    ('delivered')->nullable();
    ('status')->default(0); //0 - open ; 1- close; 2- no stock
    */

}
