@extends('admin.layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-12">

            @include('admin.layouts.result_messages')

            <div class="card">
                <div class="card-body">
                    <div class="card-title">
                        <h1>Settings</h1>
                    </div>

                    @foreach($allSettings as $item)
                        <form method="post" action="{{ route('admin.settings.update', $item->id) }}">
                            @method('PATCH')
                            @csrf

                            @php /** @var \App\Models\Setting $item */ @endphp

                            <label for="{{$item->name}}">{{$item->name}}</label>
                            <div class="form-group">
                                <input name="value" value="{{ old('value', $item->value) }}"
                                       id="{{$item->name}}" type="text" class="form-control">
                            </div>

                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    @endforeach

                </div>

            </div>

        </div>
    </div>

@endsection
