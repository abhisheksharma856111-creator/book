@extends('home.header')

@section('content')
<div class="container my-5">
  <h2>Checkout</h2>

  <table class="table">
    <thead>
      <tr>
        <th>Book</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
    </thead>
    <tbody>
      @foreach($cart as $item)
      <tr>
        <td>{{ $item['title'] }}</td>
        <td>{{ $item['quantity'] }}</td>
        <td>₹{{ $item['price'] }}</td>
        <td>₹{{ $item['price'] * $item['quantity'] }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <h4>Total: ₹{{ $total }}</h4>

  <form method="POST" action="{{ route('checkout.pay') }}">
    @csrf
    <button class="btn btn-success">Pay Now</button>
  </form>
</div>
@endsection
