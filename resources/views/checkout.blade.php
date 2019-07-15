@extends('layouts.app')

@section('content')
    @include('layouts.headerMin')
    <checkout v-bind:images-path='"{!! url('images/small').'/'!!}"'
              v-bind:shop-url='"{!! route('shop').'/'!!}"'
              v-bind:checkout-success-url='"{!! route('checkoutSuccess').'/'!!}"'
              v-bind:new-order-url='"{!! route('newOrder') !!}"'

    ></checkout>
@endsection

@section('scripts')
    <script>

    </script>

@endsection
