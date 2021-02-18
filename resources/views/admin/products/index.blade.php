@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Products</h1>
                            <div class="float-right">
                                <a class="btn btn-primary" href="{{ route('admin.products.create') }}">Add
                                    product</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Published</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $product)
                            @php /** @var \App\Models\Product $product */ @endphp
                            <tr {{ $product->is_published ? '' : 'class=td-draft'}} >
                                <th>{{$product->id}}</th>
                                <td>
                                    <img class="img-thumbnail" src="{{asset("storage/$product->image_url")}}" alt="">
                                </td>
                                <td>
                                    <a href="{{ route('admin.products.edit', $product->id) }}">{{$product->title}}</a>
                                </td>
                                <td>{{$product->category->title}}</td>
                                <td>{{$product->is_published ? 'Published' : 'Draft' }}</td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @include('admin.layouts.paginator')

            </div>
        </div>
    </div>



@endsection
