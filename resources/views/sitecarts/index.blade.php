@extends('layouts.app')

@section('content')

    @include('admin.layouts.result_messages')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                @include ('sitecarts.components.part1')
                @include ('sitecarts.components.part2')
            </div>
        </div>
    </div>

    @if($errors->any())
        <script>
            document.getElementById('part1').style.display = 'none';
            document.getElementById('part2').style.display = 'block';
        </script>
    @endif

@endsection
