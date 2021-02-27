<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Product
 *
 * @package App\Models
 *
 * @property \App\Models\Category $category
 * @property \App\Models\Cart_item $cart_item
 * @property string $title
 * @property string $slug
 * @property integer $category_id
 * @property string $description
 * @property float $price
 * @property string $image_url
 * @property boolean $is_published
 */
class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'description',
        'price',
        'image_url',
        'is_published'
    ];

    /**
     * Get parent category
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * To get the quantity the product in the current cart
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasOne
     */
    public function cart_item()
    {
        return $this->hasOne(Cart_item::class);
    }


}

