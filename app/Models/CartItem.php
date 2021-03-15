<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class CartItem extends BaseModel
{
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
     * For Product title and Images URL in list Cart items (on the site and in the admin panel)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        //The cartItem belongs to the product
        return $this->belongsTo(Product::class);
    }

    /**
     * For the counter "cart->user_id" and "cart->name" in list Carts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        //The cartItem belongs to the Cart
        return $this->belongsTo(Cart::class);
    }

}


