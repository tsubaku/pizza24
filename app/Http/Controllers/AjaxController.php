<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use Illuminate\Http\Request;

use App\Repositories\AjaxRepository;
use App\Repositories\SettingRepository;
use Cookie;
//use Session;

use App\Models\Cart;


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

    /**
     *
     *
     * @param Request $request
     */
    public function ajaxAddProduct(Request $request)
    {
        #Get Session_id from cookie
        $sessionName = session()->getName();
        $sessionId = $request->cookie($sessionName);

        #Get Cart_id for this Session_id
        $fieldName = 'session_id';
        $model = Cart::all();
        $cartId = $this->ajaxRepository->getItemId($fieldName, $sessionId, $model);

        #If cart is new, add the cart to DB and return new Cart_id
        if (empty($cartId)) {
            $data = [
                'session_id' => $sessionId
            ];
            $item = new Cart($data);
            $item->save();
            $cartId = $item->id;
        }

        #Add product to the Cart_item table
        $productId = $request->productId;
        $newQuantity = $this->ajaxRepository->addCartItemId($productId, $cartId);

        #Return data to the front
        echo json_encode(array(
            'productId' => $productId,
            'session_id' => $sessionId,
            'cartId' => $cartId,
            'quantity' => $newQuantity
        ));


    }

    /**
     *
     *
     * @param Request $request
     */
    public function ajaxDecProduct(Request $request)
    {
        #Get Session_id from cookie
        $sessionName = session()->getName();
        $sessionId = $request->cookie($sessionName);

        #Get Cart_id for this Session_id
        $fieldName = 'session_id';
        $model = Cart::all();
        $cartId = $this->ajaxRepository->getItemId($fieldName, $sessionId, $model);

        #If cart is new, add the cart to DB and return new Cart_id
        if (empty($cartId)) {
            /*
            $data = [
                'session_id' => $sessionId
            ];
            $item = new Cart($data);
            $item->save();
            $cartId = $item->id;
            */
        }

        #Add product to the Cart_item table
        $productId = $request->productId;
        $newQuantity = $this->ajaxRepository->decCartItemId($productId, $cartId);

        #Return data to the front
        echo json_encode(array(
            'productId' => $productId,
            'session_id' => $sessionId,
            'cartId' => $cartId,
            'quantity' => $newQuantity
        ));


    }


}


