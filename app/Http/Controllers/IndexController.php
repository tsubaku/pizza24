<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\IndexRepository;
use App\Repositories\SettingRepository;

use Illuminate\Http\Response;
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
     * PostController constructor.
     */
    public function __construct()
    {
        $this->indexRepository = app(IndexRepository::class);
        $this->categoryRepository = app(CategoryRepository::class);
        $this->settingRepository = app(SettingRepository::class);
    }


    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        #Get cookie and set if empty
        $currencyName = $request->cookie('currency');
        if(empty($currencyName)){
            Cookie::queue('currency', 'EUR');
        }

        #Get exchange rate and currency designation for view
        if ($currencyName == 'USD') {
            $exchangeRate = $this->settingRepository->getExchangeRate();
            $currencyLogo = '$';
        } else {
            $exchangeRate = 1;
            $currencyLogo = '€';

        }

        #Get data from models
        $selectedCategory = $request->category;
        $paginator = $this->indexRepository->getWithPaginate(9, $selectedCategory, $exchangeRate);
        $categoryList = $this->categoryRepository->getForComboBox();

        return view('index', compact('paginator', 'categoryList', 'currencyName', 'currencyLogo'));
    }
}
