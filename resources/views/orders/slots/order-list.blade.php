<table class="table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Партнер</th>
        <th>Стоимость</th>
        <th>Состав</th>
        <th>Статус</th>
    </tr>
    </thead>
    @foreach($orders as $order)
        <tr>
            <td><a href="{{ route('ordersEdit', ['order' => $order]) }}">{{ $order->id }}</a></td>
            <td>{{ $order->partner->name }}</td>
            <td>
                @foreach($order->orderProducts as $orderProduct)
                    <p>{{ $orderProduct->price }}р.</p>
                @endforeach
                <div>
                    <span>Общая сумма: {{ $order->getOrderProductsPriceAmount() }}р.</span>
                </div>
            </td>
            <td>
                @foreach($order->orderProducts as $orderProduct)
                    <p>Продукт: {{ $orderProduct->product->name }} - Кол-во: {{ $orderProduct->quantity }} шт.</p>
                @endforeach
                <hr>
                <div>
                    <span>Общее кол-во: {{ $order->getOrderProductsQuantityAmount() }} шт.</span>
                </div>
            </td>
            <td>{{ $order->getStatus() }}</td>
        </tr>
    @endforeach
</table>
