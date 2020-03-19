<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Order;
use App\Partner;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with('partner')->with('products')->paginate(25);
        return view('order.index', ['orders' => $orders]);
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $order->partner;
        $order->products;
        $partners        = Partner::all();
        $totalPrice      = 0;
        $order->products = $order->products->groupBy(function ($item) use (&$totalPrice) {
            $totalPrice += $item->price;
            return $item['id'];
        });
        $productCount    = $order->products->map(function ($item) {
            return collect($item)->count();
        });
        $data            = [
            'order'         => $order,
            'partners'      => $partners,
            'product_count' => $productCount,
            'total_price'   => $totalPrice,
        ];
        return view('order.edit', $data);
    }


    public function update(OrderRequest $request, $id)
    {
        $order               = Order::find($id);
        $order->client_email = $request->client_email;
        $order->partner_id   = $request->partner_id;
        $order->status       = $request->status;
        $order->save();
        Session::flash('message', 'Изменения сохранены!');
        Session::flash('alert-class', 'alert-success');
        return redirect('order');
    }
}
