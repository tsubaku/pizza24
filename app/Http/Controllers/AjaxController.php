<?php

namespace App\Http\Controllers;

//use App\Models\Cart_item;
use App\Repositories\CartRepository;
use App\Repositories\IndexRepository;
use Illuminate\Http\Request;

use App\Repositories\AjaxRepository;
use App\Repositories\SettingRepository;
use Cookie;
//use Session;

//use App\Models\Cart;
//use Illuminate\Validation\Rules\In;
//use function PHPUnit\Framework\isEmpty;


//use function PHPUnit\Framework\isNull;

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
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * @var IndexRepository
     */
    private $indexRepository;


    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->ajaxRepository = app(AjaxRepository::class);
        $this->settingRepository = app(SettingRepository::class);
        $this->cartRepository = app(CartRepository::class);
        $this->indexRepository = app(IndexRepository::class);
    }


    /**
     * Take from the database the prices for products in the selected currency
     *
     * @param Request $request
     */
    public function ajaxGetPrices(Request $request)
    {
        #Get price parameters
        $currencyName = $request->currency; //From request only!
        Cookie::queue('currency', $currencyName, 2628000);

        $currencyLogo = $this->indexRepository->getCurrencyLogo($currencyName);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);


        $uri = substr(strrchr($_SERVER['HTTP_REFERER'], "/"), 1);//no use getRequestUri()! Its AJAX.
        if ($uri == 'cart') {
            #Get Cart_id for this Session_id
            $sessionId = $this->indexRepository->getSessionId($request);
            $cartId = $this->cartRepository->getCartId($sessionId);

            #Get new full price for ALL products in the cart
            $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId, $currentExchangeRate);
            $paginator->map(function ($item, $key) {
                $item['summ'] = round(($item['quantity'] * $item['product']->price), 2); //Add Summ in the collection
                return $item;
            });
            $sums = $paginator->pluck('summ', 'product_id');
            $pricesProductInCart = $paginator->pluck('product', 'id')->pluck('price', 'id');

            $total = (float)$paginator->reduce(function ($carry, $item) {
                return round(($carry + $item->quantity * $item->product->price), 2);
            });
            $deliveryCosts = $this->settingRepository->getDeliveryCosts($currentExchangeRate);
            $fullPrice = round(($total + $deliveryCosts), 2);

            echo json_encode(array(
                //'currency' => $currencyName,
                'currencyLogo' => $currencyLogo,
                //'paginator' => $paginator,
                'pricesProductInCart' => $pricesProductInCart,
                'deliveryCosts' => $deliveryCosts,
                'fullPrice' => $fullPrice,
                'sums' => $sums,
                'total' => $total,
                'deliveryCosts' => $deliveryCosts,
                //'currentExchangeRate' => $currentExchangeRate,
            ));
        } else {
            $productPrices = $this->ajaxRepository->getProductPrices($currentExchangeRate);

            echo json_encode(array(
                //'currency' => $currencyName,
                'currencyLogo' => $currencyLogo,
                'productPrices' => $productPrices,
                //'paginator' => $paginator,
                //'currentExchangeRate' => $currentExchangeRate,
            ));
        }


    }


    /**
     * Increment/Decrement current quantity.
     *
     * @param Request $request
     */
    public function changeProductQuantity(Request $request)
    {
        #Get Session_id from cookie
        $sessionId = $this->indexRepository->getSessionId($request);

        #Get Cart_id for this Session_id
        $cartId = $this->cartRepository->getCartId($sessionId);

        if (empty($cartId)) {
            $cartId = $this->cartRepository->setCartId($sessionId);
        }

        #Add product to the Cart_item table
        $productId = $request->productId;
        $action = $request->action;
        if ($action == 'decrement') {
            $newQuantity = $this->cartRepository->decCartItemId($productId, $cartId);
        }
        if ($action == 'increment') {
            $newQuantity = $this->cartRepository->addCartItemId($productId, $cartId);
        }

        #Get Product Price Sum for this product
        $currencyName = $this->indexRepository->getCurrencyName($request);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);
        $productPrice = $this->ajaxRepository->getProductPrice($currentExchangeRate, $productId);
        $productPriceSum = round($productPrice * $newQuantity, 2);

        #Get new full price
        $deliveryCosts = $this->settingRepository->getDeliveryCosts($currentExchangeRate);
        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId, $currentExchangeRate);
        $total = (float)$paginator->reduce(function ($carry, $item) {
            return round(($carry + $item->quantity * $item->product->price), 2);
        });
        $fullPrice = round(($total + $deliveryCosts), 2);

        #Return data to the front
        echo json_encode(array(
            'productId' => $productId,
            'quantity' => $newQuantity,
            'productPriceSum' => $productPriceSum,
            'deliveryCosts' => $deliveryCosts,
            'fullPrice' => $fullPrice

        ));
    }

}


