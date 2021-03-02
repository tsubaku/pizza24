<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Repositories\IndexRepository;
use App\Repositories\SettingRepository;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;

use App\Repositories\CartRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Validation\Rules\In;

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
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var Index Repository
     */
    private $indexRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->cartRepository = app(CartRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->settingRepository = app(SettingRepository::class);
        $this->indexRepository = app(IndexRepository::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        #Get session id from cookie.
        $sessionId = $this->indexRepository->getSessionId($request);

        $currencyName = $this->indexRepository->getCurrencyName($request);
        $currencyLogo = $this->indexRepository->getCurrencyLogo($currencyName);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);

        $cartId = $this->cartRepository->getCartId($sessionId);

        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId, $currentExchangeRate);
        $categoryList = $this->categoryRepository->getForComboBox();

        $deliveryCosts = $this->settingRepository->getDeliveryCosts($currentExchangeRate);
        $total = (float)$paginator->reduce(function ($carry, $item) {
            return round(($carry + $item->quantity * $item->product->price), 2);
        });
        $fullPrice = $total + $deliveryCosts;
        //dd($request->getRequestUri(), $request, $paginator, $fullPrice);

        return view('sitecarts.index', compact('paginator', 'categoryList', 'deliveryCosts', 'fullPrice', 'currencyLogo'));
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
