<?php

namespace App\Repositories;

use App\Models\Product;
use Cookie;

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
     * @param  float $exchangeRate
     * @param  int $productId
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
     * @param  float $exchangeRate
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
        return $results;
    }


    /**
     * Set user currency
     *
     * @param $rawLocale
     * @return bool
     */
    public function setCurrency($currencyName)
    {
        Cookie::queue(self::NAME_COOKIE_CURRENCY, $currencyName, self::COOKIE_LIFE_TIME);

        return true;
    }



}

