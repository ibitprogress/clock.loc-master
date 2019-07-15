
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
    @if (strpos(Route::currentRouteAction(), "create"))
        <article-form article-create-url={!! route("articles.store") !!}
                      article-detail-create-url={!! route("articles-detail.store") !!}
                      article-image-create-url={!! route("articles.image") !!}

{{--                v-bind:update-url='"{!! url("/admin/clocks")."/".$data["clock_id"] !!}"'--}}
        ></article-form>
    @elseif(strpos(Route::currentRouteAction(), "edit"))
{{--        <clock-form v-bind:clock-data='{!! json_encode($data) !!}'--}}
{{--                    v-bind:update-url='"{!! url("/admin/clocks")."/".$data["clock_id"] !!}"'--}}
{{--        ></clock-form>--}}
    @endif



@endsection
@section('scripts')
    <script>

    </script>


@endsection
