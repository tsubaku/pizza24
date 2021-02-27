<?php

namespace App\Http\Controllers;


use App\Models\Cart;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\IndexRepository;
use App\Repositories\SettingRepository;
use App\Repositories\AjaxRepository;
use App\Repositories\CartRepository;

use Cookie;

class IndexController extends Controller
{

    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var IndexRepository
     */
    private $indexRepository;

    /**
     * @var AjaxRepository
     */
    private $ajaxRepository;

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->indexRepository = app(IndexRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->settingRepository = app(SettingRepository::class);
        $this->ajaxRepository = app(AjaxRepository::class);
        $this->cartRepository = app(CartRepository::class);
    }


    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        #Get session id from cookie. If not, then install from session
        $sessionName = session()->getName();
        $sessionId = $request->cookie($sessionName);
        if (empty($sessionId)) {
            $sessionId = session()->getId();
            Cookie::queue($sessionName, $sessionId, 2628000);
            Cookie::queue('currency', 'EUR', 2628000);
        }

        #Get exchange rate and currency designation for view
        $currencyName = $request->cookie('currency');
        if ($currencyName == 'USD') {
            $exchangeRate = $this->settingRepository->getExchangeRate();
            $currencyLogo = '$ ';
        } else {
            $exchangeRate = 1;
            $currencyLogo = '€ ';

        }

        $cartId = $this->indexRepository->getItemId('session_id', $sessionId, Cart::all());

        #Get data from models
        $selectedCategory = $request->category;
        $paginator = $this->indexRepository->getWithPaginate(9, $selectedCategory, $exchangeRate, $cartId);
        $categoryList = $this->categoryRepository->getForComboBox();
        //$cart = $this->cartRepository->getCartItemsWithPaginate(10, $cartId);

        //dd(Cookie::get(), $request->session(), session()->getId(), session()->getName());
       // dd($paginator);


        return view('index', compact('paginator', 'categoryList', 'currencyName', 'currencyLogo', 'sessionId', 'cartId'));
    }
}
