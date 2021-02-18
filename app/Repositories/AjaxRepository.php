<?php

namespace App\Repositories;

use App\Models\Product as Model;


class AjaxRepository extends CoreRepository
{
    /**
     * Implementation of an abstract method from CoreRepository
     *
     * @return string
     */
    public function getModelClass()
    {
        return Model::class;
    }

    /**
     * Get a model for editing in the admin panel
     *
     * @param int $id
     * @return Model
     */
    public function getEdit($id)
    {
        return $this->startConditions()->find($id);
    }


    /**
     * Get (and recalculate if necessary)  of the price of all products on the page.
     * Called when the currency is changed.
     *
     * @param  int $perPage
     * @param  int $selected
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductPrices($currencyName, $exchangeRate)
    {
        if ($currencyName != $this::USD_NAME_CURRENCY) {
            $exchangeRate = 1;
        }

        $results = $this
            ->startConditions()
            ->select('id',
                \DB::raw("ROUND((price / $exchangeRate),2) AS price"))
            ->where('is_published', 1)
            ->get();

        return $results;
    }

}
