<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Repositories\IndexRepository;
use App\Repositories\OrderRepository;
use Illuminate\Http\Request;

use App\Repositories\SettingRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CartRepository;


class OrderController extends Controller
{
    /**
     * @var SettingRepository
     */
    private $settingRepository;

    /**
     * @var IndexRepository
     */
    private $categoryRepository;

    /**
     * @var CategoryRepository
     */
    private $indexRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var CartRepository
     */
    private $cartRepository;

    /**
     * PostController constructor.
     */
    public function __construct()
    {
        $this->categoryRepository = app(CategoryRepository::class);
        $this->cartRepository = app(CartRepository::class);
        $this->indexRepository = app(IndexRepository::class);
        $this->settingRepository = app(SettingRepository::class);
        $this->orderRepository = app(OrderRepository::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isUser = auth()->user();
        if (isset($isUser)) {
            //$userId = Auth::id();
            $userId = auth()->user()->id;
            $paginator = $this->orderRepository->getAllWithPaginate($userId, 10);
        } else {
            $paginator = null;
        }

        return view('order.index', compact('paginator'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     *
     */
    public function create(Request $request)
    {
        $sessionId = $this->indexRepository->getSessionId($request);
        $cartId = $this->cartRepository->getCartId($sessionId);

        $currencyName = $this->indexRepository->getCurrencyName($request);
        $currencyLogo = $this->indexRepository->getCurrencyLogo($currencyName);
        $currentExchangeRate = $this->indexRepository->getCurrentExchangeRate($currencyName);

        $cart = $this->cartRepository->getEdit($cartId);
        if (empty($cart)) {
            abort(404);
        }

        $paginator = $this->cartRepository->getCartItemsWithPaginate(10, $cartId, $currentExchangeRate);

        $deliveryCosts = $this->settingRepository->getDeliveryCosts($currentExchangeRate);
        $total = (float)$paginator->reduce(function ($carry, $item) {
            return round(($carry + $item->quantity * $item->product->price), 2);
        });
        $fullPrice = $total + $deliveryCosts;

        $dataOrder = [
            'user_id' => $cart->user_id,
            'status' => '0',
            'total' => $fullPrice,
            'currency' => $currencyName,
            'currencyLogo' => $currencyLogo,
            'name' => $cart->name,
            'email' => $cart->email,
            'phone' => $cart->phone,
            'address' => $cart->address
        ];
        $newOrder = new Order($dataOrder);

        return view('order.create', compact('newOrder', 'dataOrder'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->input();

        //$item = (new Product())->create($data);
        $item = new Order($data);
        $saveResult = $item->save();

        #Delete cart items
        $sessionId = $this->indexRepository->getSessionId($request);
        $cartId = $this->cartRepository->getCartId($sessionId);
        $costDeletedItems = $this->cartRepository->deleteCartItems($cartId);
        if ($costDeletedItems) {
            //
        } else {
            return back()->withErrors(['msg' => 'Delete cart items ERROR!']);
        }

        #Redirect
        if ($saveResult) {
            return redirect()->route('order.index')
                ->with(['success' => 'The order was placed successfully.
                                        The basket has been emptied.
                                        The order has been added to the list of your orders.']);
        } else {
            return back()->withErrors(['msg' => 'Save order error'])->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }
}
