@extends('admin.layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                @include('admin.layouts.result_messages')

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <h1>Categories</h1>
                            <div class="float-right">
                                <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
                                    <a class="btn btn-primary" href="{{ route('admin.categories.create') }}">Add
                                        category</a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Category</th>
                            <th>Parent</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($paginator as $item)
                            @php /** @var \App\Models\Category $item */ @endphp
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    <img class="img-thumbnail" src="{{asset("storage/$item->image_url")}}" alt="">
                                </td>
                                <td>
                                    <a href="{{  route('admin.categories.edit', $item->id) }}">{{$item->title}}</a>
                                </td>

                                <td {{ ($item->parent_id == 1) ? 'class=root-color' : ''}} >
                                    {{ $item->parentCategory->title }}
                                </td>
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

