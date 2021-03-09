@if($errors->any())
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <ul>
                    @foreach($errors->all() as $errorTxt)
                        <li>{{ $errorTxt }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                {{session()->get('success')}}
            </div>
        </div>
    </div>
@endif


@auth
@else
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="alert alert-info" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
                <p>You are not logged in. </p>
                <p>Your shopping cart are linked to the session number, which is stored in the browser cookies. Your order history are linked to the user id (get it at registration). In order for orders not to get lost and to be available from any device, register and log in with your username and password. </p>
            </div>
        </div>
    </div>
@endauth


