@extends('admin.layouts.app')

@section('content')
    @php
        /** @var \App\Models\Cart $item */
    @endphp

    <div class="container">
        @include('admin.layouts.result_messages')

        @if($item->exists)
            <form method="post" action="{{ route('admin.carts.update', $item->id) }}">
                @method('PATCH')
                @else
                    <form method="post" action="{{ route('admin.carts.store') }}">
                        @endif

                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                @include('admin.carts.components.cart_edit_main_col')
                            </div>
                            <div class="col-md-3">
                                @include('admin.carts.components.cart_edit_add_col')
                            </div>
                        </div>

                    </form>

                    @if($item->exists)
                        <form method="post" action="{{ route('admin.carts.destroy', $item->id) }}">
                            @method('DELETE')
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-body">
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                </div>
                            </div>
                        </form>
        @endif
    </div>
@endsection
