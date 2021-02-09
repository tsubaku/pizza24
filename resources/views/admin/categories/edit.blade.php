@extends('admin.layouts.app')

@section('content')
    @php
        /** @var \App\Models\Category $item */
    @endphp

    @include('admin.layouts.result_messages')

    @if($item->exists)
        <form method="post" action="{{ route('admin.categories.update', $item->id) }}">
            @method('PATCH')
            @else
                <form method="post" action="{{ route('admin.categories.store') }}">
                    @endif
                    @csrf
                    <div class="row justify-content-center">
                        <div class="col-md-8">
                            @include('admin.categories.components.item_edit_main_col')
                        </div>
                        <div class="col-md-3">
                            @include('admin.categories.components.item_edit_add_col')
                        </div>
                    </div>
                </form>

                <form method="post" action="{{ route('admin.categories.destroy', $item->id) }}">
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

@endsection
