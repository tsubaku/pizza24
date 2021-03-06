<header>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">

                    <li class="nav-item px-3 ">
                        <select id="selectCurrency" class="custom-select">
                            <option class="currencySet"
                                    value="EUR" {{Cookie::get('currency')==='EUR' ? 'selected=selected' : '' }}>EUR
                            </option>
                            <option class="currencySet"
                                    value="USD" {{Cookie::get('currency')==='USD' ? 'selected=selected' : '' }}>USD
                            </option>
                        </select>
                    </li>

                    @isset($categoryList)
                        <li class="nav-item px-3 ">
                            <select id="selectCategory" class="custom-select ">
                                @foreach($categoryList as $category)
                                    <option class="categorySet" value="{{$category->id}}"
                                    @isset($selectedCategory){{$category->id==$selectedCategory ? 'selected=selected' : '' }}@endisset>
                                        {{$category->title}}
                                    </option>
                                @endforeach
                            </select>
                        </li>
                    @endisset

                    <li class="nav-item px-1">
                        <a class="nav-link" href="{{ route('cart.index') }}">@lang('text.my_cart')</a>
                    </li>

                    <li class="nav-item px-1">
                        <a class="nav-link" href="{{ route('order.index') }}">@lang('text.my_order')</a>
                    </li>

                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">@lang('text.login')</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">@lang('text.register')</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest

                    <li class="nav-item">
                        <a class="nav-link {{App::isLocale('en') ? 'page-link' : '' }}"
                           href="{{ route('locale', ['locale' => 'en']) }}">EN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{App::isLocale('ru') ? 'page-link' : '' }}"
                           href="{{ route('locale', ['locale' => 'ru']) }}">RU</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
</header>
