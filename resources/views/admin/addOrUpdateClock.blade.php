
@extends('admin.layouts.app')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (! isset($data['clock_id']))
        <clock-form></clock-form>
    @else
        <clock-form v-bind:clock-data='{!! json_encode($data) !!}'
                    v-bind:update-url='"{!! url("/admin/clocks")."/".$data["clock_id"] !!}"'
        ></clock-form>
        <ul class="nav nav-tabs" id="tabList" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="descriptions-tab" data-toggle="tab" href="#descriptions" role="tab" aria-controls="descriptions" aria-selected="true">Опис</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="characteristics-tab" data-toggle="tab" href="#characteristics" role="tab" aria-controls="characteristics" aria-selected="false">Характеристики</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="images-tab" data-toggle="tab" href="#images" role="tab" aria-controls="images" aria-selected="false">Зображення</a>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade  show active" id="descriptions" role="tabpanel" aria-labelledby="descriptions-tab">
                <descriptions-form v-bind:descriptions-data='{!! json_encode($data["descriptions"]) !!}'
                                   v-bind:update-url='"{!! url("/admin/clocks/descriptions")."/".$data["clock_id"] !!}"'
                ></descriptions-form>
            </div>

            <div class="tab-pane fade" id="characteristics" role="tabpanel" aria-labelledby="characteristics-tab">
                <characteristics-form v-bind:characteristics-data='{!! json_encode($data["characteristics"]) !!}'
                                      v-bind:functions-data='{!! json_encode($data["functions"]) !!}'
                                      v-bind:update-url='"{!! url("/admin/clocks/characteristics")."/".$data["clock_id"] !!}"'
                ></characteristics-form>
            </div>

            <div class="tab-pane fade" id="images" role="tabpanel" aria-labelledby="images-tab">
                <images-form v-bind:images-data='{!! json_encode($data["images"]) !!}'
                             v-bind:logo='{!! json_encode($data["logo_uuid"]) !!}'
                             v-bind:update-url='"{!! url("/admin/clocks/images")."/".$data["clock_id"] !!}"'
                             v-bind:set-logo-url='"{!! url("/admin/clocks/images/set-logo")."/".$data["clock_id"] !!}"'
                             v-bind:images-path='"{!! url("/images/medium")."/" !!}"'

                ></images-form>
            </div>
        </div>
    @endif


@endsection
@section('scripts')
    <script>
    </script>


@endsection
