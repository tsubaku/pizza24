<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\IndexRepository;
use App\Repositories\CartRepository;

class IndexController extends Controller
{
    /**
     * @var CategoryRepository
     */
    private $categoryRepository;

    /**
     * @var IndexRepository
     */
    private $indexRepository;

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
        $sessionId = $this->indexRepository->getSessionId($request);

        #Get price parameters
        $currencyName = $this->indexRepository->getCurrencyName($request);
        $currencyLogo = $this->indexRepository->getCurrencyLogo($currencyName);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);

        $cartId = $this->cartRepository->getCartId($sessionId);

        #Get data from models
        $selectedCategory = $request->category;
        $paginator = $this->indexRepository->getWithPaginate(9, $selectedCategory, $currentExchangeRate, $cartId);
        $categoryList = $this->categoryRepository->getForComboBox(); //for Select options in layouts/header
        //dd($request->url(),$request, $selectedCategory, $paginator);

        return view('index', compact('paginator', 'categoryList', 'currencyName', 'currencyLogo', 'sessionId', 'cartId', 'selectedCategory'));
    }
}
