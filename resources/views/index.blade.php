@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-12">
            <div class="pricing-header px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
                <h1 class="display-4">Pricing</h1>
                <p class="lead">Quickly build an effective pricing table for your potential customers with this
                    Bootstrap
                    example. It’s built with default Bootstrap components and utilities with little customization.</p>
            </div>
        </div>
    </div>

    <div class="row">


        @foreach($paginator as $product)
            <div class="col-4">
                <div class="card-deck mb-3 text-center">
                    @php /** @var \App\Models\Product $product */ @endphp
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header">
                            <h4 class="my-0 font-weight-normal">
                                {{$product->title}}
                            </h4>
                        </div>
                        <div class="card-body">
                            <h5>{{$product->category->title}}</h5>
                            <h1 class="card-title pricing-card-title">
                                <small class="text-muted">$</small>
                                {{$product->price}}
                            </h1>
                            <ul class="list-unstyled mt-3 mb-4">
                                <li><img class="img-thumbnail" src="{{asset("storage/$product->image_url")}}" alt="">
                                </li>
                                <li>{{$product->description}}</li>
                            </ul>
                            <button type="button" class="btn btn-lg btn-block btn-primary">Add to cart</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach


    </div>
    @include('layouts.paginator')



@endsection
