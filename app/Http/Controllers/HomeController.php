<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart_item;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //  $t = Cart_item::all()->where('cartId', 3)->where('productId', 2);
        if(Cart_item::all()->where('cartId', 3)->where('productId', 3)->isNotEmpty()){
            $t='есть';
        } else {
            $t='нету';
        }
        //dd($t);
        return view('home', compact('t'));
    }
}
