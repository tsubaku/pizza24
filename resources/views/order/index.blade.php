@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>My orders</h1>
                        </div>
                    </div>

                    @if($paginator->items())
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>user_id</th>
                                <th>created_at</th>
                                <th>session_id</th>
                                <th>status</th>
                                <th>total</th>
                                <th>currency</th>
                                <th>name</th>
                                <th>email</th>
                                <th>phone</th>
                                <th>address</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($paginator as $item)
                                @php /** @var \App\Models\Order $item */ @endphp
                                <tr>
                                    <th>{{$item->id}}</th>
                                    <td>{{$item->user_id}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->session_id}}</td>
                                    <td>{{$item->status}}</td>
                                    <td>{{$item->total}}</td>
                                    <td>{{$item->currency}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->phone}}</td>
                                    <td>{{$item->address}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    @else
                        <p>The list order is empty.</p>
                    @endif

                </div>
                @include('admin.layouts.paginator')

            </div>
        </div>
    </div>

@endsection
