<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartUpdateRequest;
use App\Models\Cart;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Http\Request;

use App\Repositories\IndexRepository;
use App\Repositories\SettingRepository;
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
        //dd($request);

        #Get session id from cookie.
        $sessionId = $this->indexRepository->getSessionId($request);

        $currencyName = $this->indexRepository->getCurrencyName($request);
        $currencyLogo = $this->indexRepository->getCurrencyLogo($currencyName);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);

        $cartId = $this->cartRepository->getCartId($sessionId);
        $cart = $this->cartRepository->getEdit($cartId);

        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId, $currentExchangeRate);
        $categoryList = $this->categoryRepository->getForComboBox();

        $deliveryCosts = $this->settingRepository->getDeliveryCosts($currentExchangeRate);
        $total = (float)$paginator->reduce(function ($carry, $item) {
            return round(($carry + $item->quantity * $item->product->price), 2);
        });
        $fullPrice = $total + $deliveryCosts;
        //dd($request->getRequestUri(), $request, $paginator, $fullPrice, $cart);

        return view('sitecarts.index', compact('cart', 'paginator', 'categoryList', 'deliveryCosts', 'fullPrice', 'currencyLogo'));
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
     * @param  CartUpdateRequest $request
     * @param  int $cartId
     * @return \Illuminate\Http\Response
     */
    public function update(CartUpdateRequest $request, $cartId)
    {

        $cart = $this->cartRepository->getEdit($cartId);
        if (empty($cart)) {
            return back()
                ->withErrors(['msg' => "Cart id=$cartId not found"])
                ->withInput();
        }

        #working with a request
        //$data = $request->all();
        $data = $this->cartRepository->processRequest($request);

        $saveResult = $cart->update($data);//writing in DB
        //   dd($id, $saveResult, $data, $item, $request);

        //$goTo = $this->cartRepository->redirectAfterSaveCart($saveResult, $cart);
        //return $goTo;

        //$part = ['part' => 2];
        if ($saveResult) {
            return redirect()->route('cart.index')
                ->with(['success' => 'Saved successfully']);
        } else {
            return back()->withErrors(['msg' => 'Save error'])->withInput();
        }
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
