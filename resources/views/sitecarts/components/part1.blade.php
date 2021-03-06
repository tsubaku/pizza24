<div id="part1">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h1>Products in your cart</h1>
            </div>
        </div>
        @if($paginator->items())
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>id</th>
                    <th>Image</th>
                    <th>product_id
                        <small>(for debugging)</small>
                    </th>
                    <th>Product name</th>
                    <th>Price</th>
                    <th>cart_id
                        <small>(for debugging)</small>
                    </th>
                    <th>Quantity</th>
                    <th>Summ</th>
                    <th>Add</th>
                    <th>Reduce</th>
                </tr>
                </thead>
                <tbody>
                @foreach($paginator as $item)
                    @php /** @var \App\Models\Cart_item $item */ @endphp
                    <tr id="tr{{$item->product_id}}">
                        <th>{{$item->id}}</th>
                        <td>
                            <img class="img-thumbnail" src="{{asset("storage/".$item->product->image_url)}}"
                                 alt="Product image">
                        </td>
                        <td>{{$item->product_id}}</td>
                        <td>{{$item->product->title}}</td>
                        <td nowrap>
                            <div id="idPrice{{$item->product_id}}"
                                 class="divPrice d-inline">{{$item->product->price}}</div>
                            <small class="text-muted d-inline divCurrencyName">{{$currencyLogo}}</small>
                        </td>
                        <td>{{$item->cart_id}}</td>
                        <td id="tdQuantity{{$item->product_id}}">{{$item->quantity}}</td>
                        <td nowrap>
                            <div id="tdSum{{$item->product_id}}"
                                 class="d-inline">{{$item->product->price * $item->quantity}}
                            </div>
                            <small class="text-muted d-inline divCurrencyName">{{$currencyLogo}}</small>
                        </td>
                        <td>
                            <button type="button" id="idAddButton{{$item->product_id}}"
                                    class="buttonAddProduct btn btn-lg btn-block btn-primary">+
                            </button>
                        </td>
                        <td>
                            <button type="button" id="idDecButton{{$item->product_id}}"
                                    class="buttonDecProduct btn btn-lg btn-block btn-dark">-
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

    </div>
    @include('layouts.paginator')

    <table class="table table-hover">
        <thead>
        <tr>
            <th></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <th>Delivery costs:</th>
            <td>
                <div id="deliveryCosts" class="d-inline">{{$deliveryCosts}}</div>
                <small class="text-muted d-inline divCurrencyName">{{$currencyLogo}}</small>
            </td>
        </tr>
        <tr>
            <th>Full price:</th>
            <td>
                <div>
                    <div id="divFullPrice" class="d-inline">{{$fullPrice}}</div>
                    <small class="text-muted d-inline divCurrencyName">{{$currencyLogo}}</small>
                </div>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="row">
        <div class="col-6"></div>
        <div class="col-3">
            <button type="button" id="buttonNext"
                    class="btn btn-block btn-primary buttonPartControl {{$paginator->items() ? '' : 'disabled' }} ">Next
            </button>
        </div>
    </div>

    @else
        <p>The cart is empty!</p>
    @endif

</div>