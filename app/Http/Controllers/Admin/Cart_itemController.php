<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart_item;
use Illuminate\Http\Request;


class Cart_itemController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart_item $cart_item
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart_item $cart_item
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart_item $cart_item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Cart_item $cart_item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart_item $cart_item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart_item $cart_item
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft delete
        //$result = Cart_item::destroy($id); //$result will contain the number of deleted records

        //Full delete
        $result = Cart_item::find($id)->forceDelete();

        if ($result) {
            return back()->with(['success' => "Cart item $id was deleted"]);
        } else {
            return back()->withErrors(['msg' => 'Delete error']);
        }
    }
}
