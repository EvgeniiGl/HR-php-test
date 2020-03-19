@extends('layouts.app')

@section('content')
    <div class="container">
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Партнер</th>
                <th scope="col">Стоимость</th>
                <th scope="col">Название</th>
                <th scope="col">Статус</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td><a class="btn btn-link" href="{{url("order/edit/{$order->id}")}}">{{$order->id}}</a></td>
                    <td>{{$order->partner->name}}</td>
                    @php
                        $totalPrice = 0;
                        $totalName = '';
                    @endphp
                    @foreach ($order->products as $product)
                        @php
                            $totalPrice += $product->price;
                            $totalName .= $product->name.", ";
                        @endphp
                    @endforeach
                    <td>{{$totalPrice}}</td>
                    <td>{{$totalName}}</td>
                    <td>{{$order->status}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {!! $orders->render() !!}
    </div>

    @if(Session::has('message'))
        <div class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</div>
    @endif
@endsection
