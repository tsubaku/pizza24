<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

use App\Repositories\CartRepository;

class CartController extends Controller
{
    /**
     * @var CartRepository
     */
    private $cartRepository;


    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->cartRepository = app(CartRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginator = $this->cartRepository->getAllWithPaginate(10);

        return view('admin.carts.index', compact('paginator'));
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
     */
    public function store(Request $request)
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cart->id);

        return view('admin.carts.show', compact('paginator'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Soft delete
        //$result = Cart::destroy($id); //$result will contain the number of deleted records

        //Full delete
        $result = Cart::find($id)->forceDelete();

        if ($result) {
            return redirect()
                ->route('admin.carts.index')
                ->with(['success' => "Cart $id was deleted"]);
        } else {
            return back()->withErrors(['msg' => 'Delete error']);
        }
    }
}
