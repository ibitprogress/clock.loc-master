<body>
<h3>Нове замовлення</h3>
<p>Прізвище: <b>{{$lastName}}</b></p>
<p>Ім'я: <b>{{$firstName}}</b></p>
<p>Номер телефону: <b>0{{$phone}}</b></p>
<p>Ціна комплекту: <b>{{$totalPrice}}</b> грн</p><br>
<table style="border-collapse: collapse; border: 1px solid black;">
        <thead>
        <tr>
                <th scope="col" style="border: 1px solid black; padding: 0.2em 0.6em;">Код товару</th>
                <th scope="col" style="border: 1px solid black; padding: 0.2em 0.6em;">Назва товару</th>
                <th scope="col" style="border: 1px solid black; padding: 0.2em 0.6em;">Кількість, шт</th>
                <th scope="col" style="border: 1px solid black; padding: 0.2em 0.6em;">Ціна, грн/шт</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cart as $item)
                <tr>
                        <th style="border: 1px solid black; padding: 0.2em 0.6em;" scope="row">{{$item['clockId']}}</th>
                        <td style="border: 1px solid black; padding: 0.2em 0.6em;"><a href="{{config('app.url')}}/shop/{{$item['clockId']}}">{{$item['name']}}</a></td>
                        <td style="border: 1px solid black; padding: 0.2em 0.6em;">{{$item['qty']}}</td>
                        <td style="border: 1px solid black; padding: 0.2em 0.6em;">{{$item['price']}}</td>
                </tr>
        @endforeach
        </tbody>
</table>
<br>
<p>{{$time}}</p>
<br><br>
</body>