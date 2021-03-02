<?php

namespace App\Repositories;

use App\Models\Cart as Model;

use App\Models\Cart;
use App\Models\Cart_item;

class CartRepository extends CoreRepository
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
     * Get a list of carts to be displayed by the paginator in the list
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllWithPaginate($perPage = null)
    {
        $columns = ['id', 'user_id', 'session_id', 'name', 'email', 'phone', 'address', 'created_at'];
        $results = $this
            ->startConditions()
            ->select($columns)
            ->orderBy('id', 'ASC')
            ->with(['cart_item', 'user:id,name'])//Add a relay for the specified fields to reduce the number of requests
            ->paginate($perPage);

        return $results;
    }


    /**
     * Get a list of cart items to be displayed by the paginator in the list
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCartItemsWithPaginate($perPage, $cartId, $currentExchangeRate = 1)
    {
        $columns = ['id', 'product_id', 'cart_id', 'quantity'];
        $results = Cart_item::orderBy('id', 'ASC')
            ->select($columns)
            ->where('cart_id', $cartId)
            ->with([
                'product' => function ($query) use ($currentExchangeRate) {
                    $query
                        ->select(['id', 'title', 'image_url', \DB::raw("ROUND((price / $currentExchangeRate),2) AS price")]);
                }
            ])
            ->paginate($perPage);

        return $results;
    }


    /**
     * Get referral address
     *
     * @param boolean $saveResult
     * @param Cart $item
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectAfterSaveCart($saveResult, $item)
    {
        if ($saveResult) {
            return redirect()->route('admin.carts.edit', $item->id)
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
    }

    #################################

    /**
     * Get the Cart id (if exist) or start setCartId() (if not exist)
     *
     * @param  string $sessionId
     * @return int
     */
    public function getCartId($sessionId)
    {
        $result = Cart::where('session_id', $sessionId)
            ->select('id')
            ->first();
        if ($result) {
            $cartId = $result->id;
        } else {
            //$itemId = 0;
            $cartId = $this->setCartId($sessionId);
        }
        return $cartId;
    }

    /**
     * If cart is new, add the cart to DB and return new Cart_id
     *
     * @param string $sessionId
     * @return int
     */
    public function setCartId($sessionId)
    {
        $data = [
            'session_id' => $sessionId
        ];
        $item = new Cart($data);
        $cartId = $item->save();
        //$cartId = $item->id;

        return $cartId;
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
            $item->save();
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
