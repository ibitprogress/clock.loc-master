@extends('layouts.app')

@section('content')
    @include('layouts.headerMin')
    <div class="container">
        <div class="row">
            <div class="col-lg-6 offset-lg-1">
                <h2 class="mt-3"><i class="fas fa-check text-success"></i> @lang('localization.checkoutSuccess')</h2>
                @if ($data['payMethod'] === 'cash')
                    <p class="pay-method">@lang('localization.paymentCash')</p>
                    <p class="order-number">@lang('localization.order') №{{$data['orderId']}}</p>
                    <p>@lang('localization.checkoutCashMessage')</p>
                @elseif($data['payMethod'] === 'online')
                    <p class="pay-method">@lang('localization.paymentOnline')</p>
                    <p class="order-number">@lang('localization.order') №{{$data['orderId']}}</p>
                    <p>@lang('localization.checkoutOnlineMessage')</p>
                @endif

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

    </script>

@endsection
