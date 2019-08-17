@extends('layouts.app')

@section('content')
    <div class="container">
        <form action="{{ route('ordersUpdate', ['order' => $order]) }}" method="post" data-toggle="validator" role="form">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}
            <h2>Редактирование заказа</h2>
            <div class="form-group required {{ $errors->has('client_email') ?? 'has-error' }}">
                <label for="client_email" class="control-label">E-mail</label>
                <input id="client_email" name="client_email" class="form-control"
                       type="email"
                       value="{{ old('client_email') ?? $order->client_email }}" required="required">
                @if ($errors->has('client_email'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('client_email') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group required">
                <label for="name" class="control-label">Название партнера</label>
                <input id="name" name="name"
                       class="form-control @if ($errors->has('name')) has-error @endif"
                       type="text"
                       value="{{ old('name') ?? $order->partner->name }}" required>
                @if ($errors->has('name'))
                    <div class="alert alert-danger">
                        <strong>{{ $errors->first('name') }}</strong>
                    </div>
                @endif
            </div>
            <div class="form-group">
                <h3>Продукты</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Наименование</th>
                            <th>Кол-во</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->orderProducts as $orderProduct)
                            <tr>
                                <td>{{ $orderProduct->product->name }}</td>
                                <td>{{ $orderProduct->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="form-group required">
                <label for="status" class="control-label">Статус</label>
                <select class="form-control" name="status" id="status">
                    <option @if ($order->status == 0) selected @endif value="0">новый</option>
                    <option @if ($order->status == 10) selected @endif value="10">подтвержден</option>
                    <option @if ($order->status == 20) selected @endif value="20">завершен</option>
                </select>
            </div>
            <div class="form-group">
                <label for="price" class="control-label">Стоимость</label>
                <span id="price">{{ $order->getOrderProductsPriceAmount() }}р.</span>
            </div>
            <button class="btn btn-success" type="submit">Сохранить</button>
        </form>
    </div>
@endsection
