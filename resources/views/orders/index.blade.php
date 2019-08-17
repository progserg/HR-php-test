@extends('layouts.app')

@section('content')
    <div class="container">
        <ul class="nav nav-tabs">
            <li role="presentation" class="@if (url()->current() == route('ordersExpired'))active @endif"><a href="{{ route('ordersExpired') }}">просроченные</a></li>
            <li role="presentation" class="@if (url()->current() == route('ordersCurrent'))active @endif"><a href="{{ route('ordersCurrent') }}">текущие</a></li>
            <li role="presentation" class="@if (url()->current() == route('ordersNew'))active @endif"><a href="{{ route('ordersNew') }}">новые</a></li>
            <li role="presentation" class="@if (url()->current() == route('ordersDone'))active @endif"><a href="{{ route('ordersDone') }}">выполненные</a></li>
        </ul>
        <div class="tab-content">
            @component('orders.slots.order-list', compact('orders'))
            @endcomponent
        </div>
        <div class="row">
            <div class="col-md-12 text-center">
                {{ $orders->links() }}
            </div>
        </div>
    </div>
@endsection
