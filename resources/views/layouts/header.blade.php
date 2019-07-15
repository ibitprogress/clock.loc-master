<div id="header">
    <div class="top-line">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light px-0 py-1 row">
                <div class="col-8 col-md-5 d-lg-none">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <a class="navbar-brand d-lg-none ml-4 mr-0" href="/">
                        <img src="/images/logo.png" width="60" height="30" alt="">
                    </a>
                </div>
                <div class="collapse navbar-collapse col-lg-3 order-lg-0">
                    <div class="d-none d-lg-flex justify-content-start ">
                        <a class="mr-2" href="{{ LaravelLocalization::getLocalizedURL("uk") }}">
                            <img src="/images/ukraine.png" alt="Українська" title="Українська">
                        </a>
                        <a class="mr-2" href="{{ LaravelLocalization::getLocalizedURL("ru") }}">
                            <img src="/images/russia.png" alt="Русcкий" title="Русский">
                        </a>
                    </div>
                </div>
                <div class="d-none d-md-inline-block col-md-4 col-lg-3 order-lg-2">
                    <form class="form-inline">
                        <input class="form-control btn-sm d-none d-md-block w-100" type="search" placeholder="@lang('localization.search')" aria-label="@lang('localization.search')">
                    </form>
                </div>

                <div class="mobile-links d-lg-none col-4 col-md-3">
                    <div class="row">
                        <div class="col-6">
                            <a href="#" data-toggle="modal" data-target="#feedbackModal">
                                <i class="fas fa-phone"></i>
                            </a>
                        </div>
                        <div class="col-6">
                            <cart-button-min></cart-button-min>
                        </div>
                    </div>
                </div>
                <div class="collapse navbar-collapse col-lg-6 order-lg-1" id="navbarToggler">
                    <ul class="navbar-nav mt-2 mt-lg-0">
                        {{--<li class="nav-item mr-2">--}}
                            {{--<a class="nav-link" href="#">@lang('localization.blog')</a>--}}
                        {{--</li>--}}
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{route('paymentAndDelivery')}}">@lang('localization.paymentAndDelivery')</a>
                        </li>
                        <li class="nav-item mr-2">
                            <a class="nav-link" href="{{route('contacts')}}">@lang('localization.contacts')</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
    <div class="middle-line d-none d-lg-block">
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <a class="" href="/">
                        <img class="mt-1 mb-1" src="/images/logo.png" alt="Clock Shop" title="Clock Shop">
                    </a>
                </div>
                <div class="col-3 offset-3">
                    <div class="d-flex flex-column justify-content-center h-100 phones">
                        <div class="lifecell">
                            (093) 577-85-19
                        </div>
                        <div class="vodafone">
                            (095) 640-01-98
                        </div>
                        <div class="phone-icon">
                            <a href="#" data-toggle="modal" data-target="#feedbackModal">@lang('localization.callMeBack')</a>
                        </div>
                    </div>
                </div>
                <cart-button></cart-button>
            </div>
        </div>
    </div>
</div>
<cart v-bind:images-path='"{!! url('images/small').'/'!!}"'
      v-bind:checkout-url='"{!! route('checkout').'/'!!}"'
      v-bind:items-data='{!! session()->has("cart") ? json_encode(session()->get("cart")->items) : json_encode([]) !!}'
      v-bind:total-price-data='{!! session()->has("cart")? session()->get("cart")->totalPrice : 0 !!}'
      v-bind:total-qty-data='{!! session()->has("cart")? session()->get("cart")->totalQty : 0 !!}'
></cart>
<feedback-modal v-bind:feedback-url='"{!! route('new-feedback') !!}"'
></feedback-modal>

