@component('mail::message')
# Заказ №{{ $order->id }} завершен

<table style="width: 100%; text-align: center;" class="table table-bordered">
<thead>
<tr>
<th>Наименование</th>
<th>Стоимость</th>
<th>Кол-во</th>
</tr>
</thead>
<tbody>
@foreach($order->orderProducts as $orderProduct)
<tr>
<td>{{ $orderProduct->product->name }}</td>
<td>{{ $orderProduct->price }}</td>
<td>{{ $orderProduct->quantity }}</td>
</tr>
@endforeach
<td>
</td>
<td>
Сумма р.
</td>
<td>
Всего шт.
</td>
</tr>
<tr>
<td>
</td>
<td>
{{ $order->getOrderProductsPriceAmount() }}
</td>
<td>
{{ $order->getOrderProductsQuantityAmount() }}
</td>
</tr>
</tbody>
</table>
<hr>
С уважением,<br>
{{ config('app.name') }}
@endcomponent
