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
            ->with(['cart_item', 'user:id,name']) //Add a relay for the specified fields to reduce the number of requests
            ->paginate($perPage);

        return $results;
    }


    /**
     * Get a list of cart items to be displayed by the paginator in the list
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getCartItemsWithPaginate($perPage, $cartId)
    {
        $columns = ['id', 'product_id', 'cart_id', 'quantity'];
        $results = Cart_item::orderBy('id', 'ASC')
            ->select($columns)
            ->where('cart_id', $cartId)
            ->with([
                'product:id,image_url',//we will refer to the category relation
               // 'cart_item' => function ($query) use ($cartId) {
              //      $query->where('cart_id', $cartId)->select(['product_id', 'quantity']);
              //  }
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


}
