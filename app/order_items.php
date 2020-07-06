<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class order_items extends Model
{
    //
    protected $fillable = [
        'id_order', 'id_item','quantity','delivered','status'
    ];
}
