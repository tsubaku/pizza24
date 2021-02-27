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


    /**
     * Add new item in Cart_item, or increment, if it exist.
     *
     * @param  int $productId
     * @param  int $cartId
     * @return int
     */
    public function addCartItemId($productId, $cartId)
    {
        $result = Cart_item::where('product_id', $productId)->where('cart_id', $cartId)->first();
        if ($result) {
            $newQuantity = $result->quantity + 1;
            $data = [
                'quantity' => $newQuantity
            ];
            $saveResult = $result->update($data);//writing in DB

        } else {
            $newQuantity = 1;
            $data = [
                'product_id' => $productId,
                'cart_id' => $cartId,
                'quantity' => $newQuantity
            ];
            $item = new Cart_item($data);
            $saveResult = $item->save();
        }
        return $newQuantity;
    }


    /**
     * Decrement the quantity item from Cart_item, or delete item if the quantity is 0.
     *
     * @param  int $productId
     * @param  int $cartId
     * @return int
     */
    public function decCartItemId($productId, $cartId)
    {
        $cartItem = Cart_item::where('product_id', $productId)->where('cart_id', $cartId)->first();
        $newQuantity = 0;
        if (isset($cartItem)) {
            if ($cartItem->quantity > 1) {
                $newQuantity = $cartItem->quantity - 1;
                $data = [
                    'quantity' => $newQuantity
                ];
                $cartItem->update($data);//writing in DB

            } else {
                Cart_item::find($cartItem->id)->forceDelete();
            }
        }
        return $newQuantity;
    }


}

