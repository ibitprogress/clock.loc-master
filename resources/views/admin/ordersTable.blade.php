
@extends('admin.layouts.app')

@section('content')


    <orders-table v-bind:orders-data='{!! json_encode($data) !!}'
                  v-bind:orders-url='"{!! route('orders.index') !!}"'>
    </orders-table>


@endsection
@section('scripts')
    <script>
    </script>


@endsection
