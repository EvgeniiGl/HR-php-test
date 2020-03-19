@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action='{{ url("order/update/{$order->id}") }}'>
            {{ csrf_field() }}
            <div class="form-group">
                <label for="client_email">Email</label>
                <input id="client_email"
                       type="email"
                       class="form-control @error('client_email') is-invalid @enderror"
                       name="client_email"
                       value="{{old('client_email', $order->client_email) }}"
                       required
                       pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$"
                       title="Электронная почта"
                       autofocus>
            </div>
            <div class="form-group">
                <label for="partner_id">Партнер</label>
                <select id="partner_id" class="form-control" name="partner_id">
                    @foreach($partners as $partner)
                        <option @if ($partner->id === $order->partner->id)
                                selected="selected"
                                @endif
                                value="{{$partner->id}}">{{$partner->name}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Продукты</label>
                <ul class="list-group">
                    @foreach($order->products as $product)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{$product->first()->name}}
                            <span class="badge badge-primary badge-pill">{{$product_count[$product->first()->id]}}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group">
                <label for="status">Статус</label>
                <select id="status" class="form-control" name="status">
                    <option @if ($order->status === 0)
                            selected="selected"
                            @endif
                            value="0">новый
                    </option>
                    <option @if ($order->status === 10)
                            selected="selected"
                            @endif
                            value="10">подтвержден
                    </option>
                    <option @if ($order->status === 20)
                            selected="selected"
                            @endif
                            value="20">завершен
                    </option>
                </select>
            </div>
            <div class="form-group">
                <label>Стоимость</label>
                <div>{{$total_price}}</div>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
