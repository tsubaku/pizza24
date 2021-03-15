<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class OrderItem extends BaseModel
{
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'order_id',
        'price',
        'quantity'
    ];
}



