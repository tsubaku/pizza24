@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Products in your cart</h1>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>id</th>
                            <th>Image</th>
                            <th>product_id
                                <small>(for debugging)</small>
                            </th>
                            <th>Product name</th>
                            <th>cart_id
                                <small>(for debugging)</small>
                            </th>
                            <th>Products in cart</th>
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
                                <td>{{$item->cart_id}}</td>
                                <td id="tdQuantity{{$item->product_id}}">{{$item->quantity}}</td>
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

            </div>
        </div>
    </div>



@endsection
