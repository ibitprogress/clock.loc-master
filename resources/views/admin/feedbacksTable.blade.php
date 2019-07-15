
@extends('admin.layouts.app')

@section('content')


    <feedbacks-table v-bind:feedbacks-data='{!! $data !!}'
                  v-bind:feedbacks-url='"{!! route('feedbacks.index') !!}"'>
    </feedbacks-table>


@endsection
@section('scripts')
    <script>
    </script>


@endsection
