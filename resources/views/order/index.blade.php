@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>@lang('text.my_orders')</h1>
                        </div>
                    </div>

                    @isset($paginator)
                        @if($paginator->items())
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>@lang('text.id')</th>
                                    <th>@lang('text.user_id')</th>
                                    <th>@lang('text.сreated_at')</th>
                                    <th>@lang('text.status')</th>
                                    <th>@lang('text.full_price')</th>
                                    <th>@lang('text.currency')</th>
                                    <th>@lang('text.name')</th>
                                    <th>@lang('text.email')</th>
                                    <th>@lang('text.phone')</th>
                                    <th>@lang('text.address')</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($paginator as $item)
                                    @php /** @var \App\Models\Order $item */ @endphp
                                    <tr>
                                        <th>{{$item->id}}</th>
                                        <td>{{$item->user_id}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td>{{$item->statusName}}</td>
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
                            @include('layouts.paginator')
                        @else
                            <p>The list order is empty.</p>
                        @endif
                    @endisset
                </div>

            </div>
        </div>
    </div>

@endsection
