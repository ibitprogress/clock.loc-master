@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <clocks-list v-bind:images-path='"{!! url('images/medium').'/'!!}"'
                 v-bind:clocks-data='{!! json_encode($data["clocks"]) !!}'
                 v-bind:filter='{!! json_encode($data["filter"]) !!}'
                 v-bind:filter-url='"{!! route('filter') !!}"'
                 v-bind:shop-url='"{!! route('shop') !!}"'
                 v-bind:main-url='"{!! route('main') !!}"'
                 v-bind:cart-url='"{!! route('addToCart') !!}"'>
    </clocks-list>

@endsection

@section('scripts')
    <script>
        var data = {!! json_encode($data) !!};
    </script>

@endsection
