@php
    /** @var \App\Models\Cart $cart */
@endphp
<div id="part2">
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                <h1>@lang('text.contact_information')</h1>
            </div>

            @if($paginator->items())
                <form method="post" action="{{ route('cart.update', $cart->id) }}">
                    @method('PATCH')
                    @csrf
                    <fieldset class="">
                        <label for="name" class="">@lang('text.name')
                            <input name="name" id="name" type="text" required="required" class="form-control"
                                   value="{{ old('name', $cart->name) }}">
                        </label>
                    </fieldset>
                    <fieldset class="">
                        <label for="email" class="">@lang('text.email')
                            <input name="email" id="email" type="text" required="required" class="form-control"
                                   value="{{ old('email', $cart->email) }}">
                        </label>
                    </fieldset>
                    <fieldset class="">
                        <label for="phone" class="">@lang('text.phone')
                            <input name="phone" id="phone" type="text" required="required" class="form-control"
                                   value="{{ old('phone', $cart->phone) }}">
                        </label>
                    </fieldset>
                    <fieldset class="">
                        <label for="address" class="">@lang('text.address')
                            <input name="address" id="address" type="text" required="required" class="form-control"
                                   value="{{ old('address', $cart->address) }}">
                        </label>
                    </fieldset>

                    <div class="row">
                        <div class="col-3">
                        </div>
                        <div class="col-3">
                            <button type="button" id="buttonBack"
                                    class="btn btn-block btn-primary buttonPartControl">@lang('text.back')
                            </button>
                        </div>
                        <div class="col-3">
                            <button type="submit" id="buttonSubmit"
                                    class="btn btn-block btn-primary">@lang('text.next')
                            </button>
                        </div>
                    </div>

                </form>
            @endif

        </div>
    </div>


</div>

