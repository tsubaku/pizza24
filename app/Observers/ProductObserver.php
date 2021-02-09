<?php

namespace App\Observers;

use App\Models\Product;

class ProductObserver
{

    /**
     * @param Product $product
     */
    public function creating(Product $product)
    {
        $this->setSlug($product);
    }

    /**
     * Handle the Product "created" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function created(Product $product)
    {
        //
    }

    /**
     * @param Product $product
     */
    public function updating(Product $product)
    {
        $this->setSlug($product);
    }


    /**
     * Handle the Product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updated(Product $product)
    {
        //
    }

    /**
     * Handle the Product "deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function deleted(Product $product)
    {
        //
    }

    /**
     * Handle the Product "restored" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function restored(Product $product)
    {
        //
    }

    /**
     * Handle the Product "force deleted" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function forceDeleted(Product $product)
    {
        //
    }

    /**
     * If the slug field is empty, then fill it with header conversion
     *
     * @param Product $product
     */
    protected function setSlug(Product $product)
    {
        if (empty($product->slug)) {
            $product->slug = \Str::slug($product->title);
        }
    }
}
