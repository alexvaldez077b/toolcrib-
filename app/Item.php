<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
    protected $fillable = [
        'code','description','localization',
        'pn',
        'stock',
        'status',   //////************************ */
        'family',
         
        'umdelivery',
        'umpurchase',
     
        'price',
        'packing',
     
        'leadtime',
     
        'priority',
     
        'currency',
     
        'image',
    ];

   
}
