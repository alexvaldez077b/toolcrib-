<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class customerModel extends Model
{
    //

    protected $fillable = [
        'customer_id', 'np', 'family', 'required_quantity', 'status'
    ];



}
