<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\AjaxRepository;
use App\Repositories\SettingRepository;
use Cookie;


class AjaxController extends Controller
{
    /**
     * @var AjaxRepository
     */
    private $ajaxRepository;

    /**
     * @var SettingRepository
     */
    private $settingRepository;


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->ajaxRepository = app(AjaxRepository::class);
        $this->settingRepository = app(SettingRepository::class);
    }


    /**
     * Take from the database the prices for products in the selected currency
     *
     * @param Request $request
     */
    public function ajaxGetPrices(Request $request)
    {
        $currencyName = $request->currency;
        $exchangeRate = $this->settingRepository->getExchangeRate();
        $productPrices = $this->ajaxRepository->getProductPrices($currencyName, $exchangeRate);

        Cookie::queue('currency', $currencyName);

        echo json_encode(array(
            'currency' => $currencyName,
            'productPrices' => $productPrices
        ));


    }


}


