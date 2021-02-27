<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'session_id',
        'name',
        'email',
        'phone',
        'address'
    ];

    /**
     * For the counter "User name" in list Carts
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        //The cart belongs to the user
        return $this->belongsTo(User::class);
    }


    /**
     * For the counter "Products in cart" in list Carts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cart_item()
    {
        //The cart_item belongs to the user
        return $this->hasMany(Cart_item::class);
    }


}
