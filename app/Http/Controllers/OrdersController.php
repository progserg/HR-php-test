<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::getAll();
        return view('orders.index', compact('orders'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Order $order)
    {
        $data = request()->validate([
            'client_email' => 'required|email',
            'name' => 'required',
            'status' => 'required'
        ]);
        $route = $order->getActiveTabRoute();
        $order->updateOrder($data);

        return redirect(route($route));
    }

    public function expired()
    {
        $orders = Order::getExpired();
        return view('orders.index', compact('orders'));
    }

    public function current()
    {
        $orders = Order::getCurrent();
        return view('orders.index', compact('orders'));
    }

    public function new()
    {
        $orders = Order::getNew();
        return view('orders.index', compact('orders'));
    }

    public function done()
    {
        $orders = Order::getDone();
        return view('orders.index', compact('orders'));
    }
}
