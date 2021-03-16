<div id="part1">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h1>@lang('text.products_in')</h1>
            </div>
        </div>
        @if($paginator->items())
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>@lang('text.id')</th>
                    <th>@lang('text.image')</th>
                    <th>product_id
                        <small>(for debugging)</small>
                    </th>
                    <th>@lang('text.product_name')</th>
                    <th>@lang('text.price')</th>
                    <th>cart_id
                        <small>(for debugging)</small>
                    </th>
                    <th>@lang('text.quantity')</th>
                    <th>@lang('text.summ')</th>
                    <th>@lang('text.add')</th>
                    <th>@lang('text.reduce')</th>
                </tr>
                </thead>
                <tbody>
                @foreach($paginator as $item)
                    @php /** @var \App\Models\CartItem $item */ @endphp
                    <tr id="tr{{$item->product_id}}">
                        <th>{{$item->id}}</th>
                        <td>
                            <img class="img-thumbnail" src="{{asset("storage/".$item->product->ImageUrlPrepared)}}"
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
            <th>@lang('text.delivery_costs')</th>
            <td>
                <div id="deliveryCosts" class="d-inline">{{$deliveryCosts}}</div>
                <small class="text-muted d-inline divCurrencyName">{{$currencyLogo}}</small>
            </td>
        </tr>
        <tr>
            <th>@lang('text.full_price')</th>
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
                    class="btn btn-block btn-primary buttonPartControl {{$paginator->items() ? '' : 'disabled' }} ">@lang('text.next')
            </button>
        </div>
    </div>

    @else
        <p>@lang('text.empty')</p>
    @endif

</div>
