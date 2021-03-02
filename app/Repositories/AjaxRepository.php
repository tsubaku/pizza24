<?php

namespace App\Repositories;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Cart_item;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class AjaxRepository extends CoreRepository
{
    /**
     * Implementation of an abstract method from CoreRepository
     *
     * @return string
     */
    public function getModelClass()
    {
        return Product::class;
    }

    /**
     * Get a model for editing in the admin panel
     *
     * @param int $id
     * @return Product
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }


    /**
     * Get the Price product
     * Called when the Quantity is changed on the Cart page.
     *
     * @param  int $perPage
     * @param  int $selected
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductPrice($exchangeRate, $productId)
    {
        $results = $this
            ->startConditions()
            ->select('id',
                \DB::raw("ROUND((price / $exchangeRate),2) AS price"))
            ->where('id', $productId)
            ->first()['price'];

        return $results;
    }

    /**
     * Get (and recalculate if necessary)  of the price of all products on the page.
     * Called when the currency is changed.
     *
     * @param  int $perPage
     * @param  int $selected
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductPrices($exchangeRate)
    {
        $results = $this
            ->startConditions()
            ->select('id',
                \DB::raw("ROUND((price / $exchangeRate),2) AS price"))
            ->where('is_published', 1)
            ->get();
            //->simplePaginate(9)
            //->items();
        return $results;
    }





}

