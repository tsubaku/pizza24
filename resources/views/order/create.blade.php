@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h1>@lang('text.сonfirmation')</h1>
                </div>

                <p>@lang('text.name'): {{$dataOrder['name']}} </p>
                <p>@lang('text.email'): {{$dataOrder['email']}}</p>
                <p>@lang('text.phone'): {{$dataOrder['phone']}}</p>
                <p>@lang('text.address'): {{$dataOrder['address']}}</p>
                <p>@lang('text.full_price'): {{$dataOrder['total']}} {{$dataOrder['currencyLogo']}}</p>

                <p>user_id: {{$dataOrder['user_id']}}
                    <small>(for debugging)</small>
                </p>
                <p>status: {{$dataOrder['status']}}
                    <small>(for debugging)</small>
                </p>
            </div>

            <form method="post" action="{{ route('order.store') }}">
                @csrf
                <div class="row justify-content-center">
                    <div class="col-8">
                        <input name="user_id" value="{{$dataOrder['user_id']}}"
                               id="user_id" type="hidden">
                        <input name="status" value="{{$dataOrder['status']}}"
                               id="status" type="hidden">
                        <input name="total" value="{{$dataOrder['total']}}"
                               id="total" type="hidden">
                        <input name="currency" value="{{$dataOrder['currency']}}"
                               id="currency" type="hidden">
                        <input name="name" value="{{$dataOrder['name']}}"
                               id="name" type="hidden">
                        <input name="email" value="{{$dataOrder['email']}}"
                               id="email" type="hidden">
                        <input name="phone" value="{{$dataOrder['phone']}}"
                               id="phone" type="hidden">
                        <input name="address" value="{{$dataOrder['address']}}"
                               id="address" type="hidden">
                    </div>
                </div>

                <div class="row">
                    <div class="col-3">
                    </div>
                    <div class="col-3">
                        <button type="button" id="buttonBack"
                                class="btn btn-block btn-primary buttonPartControl">@lang('text.back')
                        </button>
                    </div>
                    <div class="col-3">
                        <button type="submit" class="btn btn-block btn-primary">@lang('text.buy')</button>
                    </div>
                </div>

            </form>
        </div>

    </div>

@endsection
