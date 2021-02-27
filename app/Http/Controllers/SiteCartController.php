<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;

class SiteCartController extends Controller
{
    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->cartRepository = app(CartRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #Get session id from cookie.
        $sessionName = session()->getName();
        $sessionId = $request->cookie($sessionName);
        $model = Cart::all();
        $cartId = $this->cartRepository->getItemId('session_id', $sessionId, $model);
        //
        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId);
        $categoryList = $this->categoryRepository->getForComboBox();
        //$imgUrl = 'stoeage'. $paginator->product->image_url;
 //        dd($paginator);
        return view('sitecarts.index', compact('paginator', 'categoryList'));
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
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
