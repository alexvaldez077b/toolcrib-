<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bom extends Model
{
    //
    protected $fillable = [
        'model_id', 'item_id', 'quantity',
    ];


}
