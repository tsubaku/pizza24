@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Carts</h1>

                        </div>
                    </div>
                    @if($paginator->items())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>User name (from user table)</th>
                                <th>Session_id
                                    <small>(for debugging)</small>
                                </th>
                                <th>Name (from cart table)</th>
                                <th>E-mail</th>
                                <th>Phone</th>
                                <th>Address</th>
                                <th>Data/Time</th>
                                <th>Products in cart</th>
                                <th>Delete cart</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $item)
                                @php /** @var \App\Models\Cart $item */ @endphp
                                <tr {{ $item->cart_item->count() ? '' : 'class=td-draft'}}>
                                    <th>{{$item->id}}</th>
                                    <td>{{$item->user_id ? $item->user->name : '' }}</td>
                                    <td><a href="{{ route('admin.carts.show', $item) }}">{{$item->session_id}}</a></td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->address }}</td>
                                    <td>{{$item->created_at }}</td>
                                    <td>{{$item->cart_item->count()}}</td>
                                    <td>
                                        <form method="post" action="{{ route('admin.carts.destroy', $item->id) }}">
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
                        <p>Cart list is empty!</p>
                    @endif

                </div>
                @include('admin.layouts.paginator')

            </div>
        </div>
    </div>



@endsection
