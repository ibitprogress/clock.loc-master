@extends('layouts.app')

@section('content')
    @include('layouts.header')
    <clock-page v-bind:clock-data='{!! json_encode($data) !!}'>
    </clock-page>

@endsection

@section('scripts')
    <script>

    </script>

@endsection
