<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart_item extends Model
{
    use HasFactory;
    use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'cart_id',
        'quantity'
    ];

    /**
     * For "Product title" in list Cart items
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        //The cart_item belongs to the product
        return $this->belongsTo(Product::class);
    }

    /**
     * For the counter "cart->user_id" and "cart->name" in list Carts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        //The cart_item belongs to the user
        return $this->belongsTo(Cart::class);
    }

}


