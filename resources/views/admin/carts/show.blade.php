@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Cart items</h1>
                        </div>
                    </div>
                    @if($paginator->items())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>product_id</th>
                                <th>Product title</th>
                                <th>cart_id</th>
                                <th>User id (from Cart)</th>
                                <th>User name (from Cart)</th>
                                <th>Quantity</th>
                                <th>Delete</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $item)
                                @php /** @var \App\Models\Cart $item */ @endphp
                                <tr>
                                    <th>{{$item->id}}</th>
                                    <td>{{$item->product_id}}</td>
                                    <td>{{$item->product->title}}</td>
                                    <td>{{$item->cart_id}}</td>
                                    <td>{{$item->cart->user_id}}</td>
                                    <td>{{$item->cart->name}}</td>
                                    <td>{{$item->quantity}}</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.cart_items.destroy', $item->id) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>The cart is empty!</p>
                    @endif
                </div>
                @include('admin.layouts.paginator')

            </div>
        </div>
    </div>



@endsection
