@extends('admin.layouts.app')

@section('content')

    <div id="adminOrder" class="mt-3">
        <div class="form-group row">
            <div class="col-lg-12">
                <table class="table table-sm">
                    <tbody>
                        <tr>
                            <th>Замовлення №</th>
                            <td>{{$data['order_id']}}</td>
                        </tr>
                        <tr>
                            <th>Час | Дата</th>
                            <td>{{$data['created_at']}}</td>
                        </tr>
                        <tr>
                            <th>Ім'я</th>
                            <td>{{$data['client_first_name']}}</td>
                        </tr>
                        <tr>
                            <th>Прізвище</th>
                            <td>{{$data['client_last_name']}}</td>
                        </tr>
                        <tr>
                            <th>Номер телефону</th>
                            <td>0{{$data['phone']}}</td>
                        </tr>
                        <tr>
                            <th>Місто</th>
                            <td>{{$data["city"]["Present"] ?? "Невизначено"}}</td>
                        </tr>
                        <tr>
                            <th>Метод доставки</th>
                            <td>{{trans('localization.'.$data['delivery_method'], [], 'uk')}}</td>
                        </tr>
                        <tr>
                            <th>Відділення</th>
                            <td>{{$data["warehous"]["Description"] ?? $data["warehous"]}}</td>
                        </tr>
                        <tr>
                            <th>Метод оплати</th>
                            <td>{{trans('localization.'.$data['pay_method'], [], 'uk')}}</td>
                        </tr>
                        <tr>
                            <th>Разом до оплати</th>
                            <td>{{$data['total_price']}} грн</td>
                        </tr>
                        @if ($data['revised'])
                            <tr>
                                <th>Статус</th>
                                <td class="text-success">Переглянуто</td>
                            </tr>
                            <tr>
                                <th>Час перегляду</th>
                                <td>{{$data['updated_at']}}</td>
                            </tr>
                        @else
                            <tr>
                                <th>Статус</th>
                                <td class="text-danger">Не переглянуто</td>
                            </tr>
                        @endif

                    </tbody>
                </table>

                <table id="cartTable" class="table table-sm mt-5 mb-0">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Назва товару</th>
                            <th scope="col">Ціна</th>
                            <th scope="col">Кількість</th>
                            <th scope="col">Сума</th>
                        </tr>
                    </thead>
                    <tbody>

                    @foreach($cart as $item)
                        <tr>
                            <td class="logo-cell">
                                <a href="{{route('clocks.show', ['id' => $item['clock_id']])}}" target="_blank">
                                    <img src="{{ url('images/small').'/'.$item['clock']['logo_uuid']}}" class="img-fluid img-thumbnail logo" alt="Responsive image">
                                </a>
                            </td>
                            <td>
                                <div class="product-name">
                                    <a href="{{route('clocks.show', ['id' => $item['clock_id']])}}" target="_blank">{{$item['clock']['name']}}</a>
                                </div>
                            </td>
                            <td>{{$item['clock']['price']}} грн</td>
                            <td>{{$item['qty']}} шт.</td>
                            <td>{{$item['clock']['price'] * $item['qty']}} грн</td>
                        </tr>
                    @endforeach

                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <span class="order-total-price">Разом до оплати: {{$data['total_price']}} грн</span>
                </div>
            </div>
        </div>
        <div id="visited" class="row mb-5">
            <div class="col-2">
                <form action="{!! route('orders.update', ['id' => $data['order_id']]) !!}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT">
                    @if ($data['revised'] == 0)
                        <input type="hidden" name="revised" value=1>
                        <input class="btn btn-success w-100" type="submit" value="Переглянуто">
                    @endif
                </form>
            </div>
        </div>

    </div>


@endsection
@section('scripts')
    <script >

    </script>


@endsection
