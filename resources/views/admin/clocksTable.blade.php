
@extends('admin.layouts.app')

@section('content')


    <clocks-table v-bind:clocks-data='{!! json_encode($data) !!}'
                  v-bind:clocks-url='"{!! route('clocks.index') !!}"'
                  v-bind:shop-url='"{!! route('shop') !!}"'
    >
    </clocks-table>


@endsection
@section('scripts')


@endsection
