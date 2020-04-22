@extends('./layout')

@section('content')
    <table>
        <tr>
            <th>Name</th>
            <th>Price</th>
            <th>Amount</th>
        </tr>
        @if(Session::has('cart'))
            <?php
                $cart = Session::get('cart');
                for ($i=0; $i < count($cart->products); $i++) {
                    ?>
                    <tr>
                        <td>{{$cart->products[$i]->productName}}</td>
                        <td>{{$cart->products[$i]->amount}} * €{{$cart->products[$i]->productPrice}} = €{{$cart->products[$i]->productPrice * $cart->products[$i]->amount}}</td>
                        <td>
                            <form action='/editCart' method='post'>
                                @csrf
                                <input type='hidden' name='productName' value="{{$cart->products[$i]->productName}}">
                                <input type='number' name='productAmount' min="1" value="{{$cart->products[$i]->amount}}">
                                <button type='submit'>Edit amount</button>
                            </form>
                        </td>
                        <td>
                            <form action='/deleteFromCart' method='post'>
                                @csrf
                                <input type='hidden' name='productName' value="{{$cart->products[$i]->productName}}">
                                <button type='submit'>X</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
            ?>
            <tr>
                <td>
                    Totaal: € {{$cart->price}}
                </td>
                <td>
                    <form action='/placeOrder' method='post'>
                        @csrf
                        <button type='submit'>Place Order</button>
                    </form>
                </td>
            </tr>
        @endif
    </table>
    @if(Session::has('orders'))
        <ul id="ordersDisplay">
            <span>Orders:</span>
            <?php
                $orders = Session::get('orders');
                for ($i=0; $i < count($orders); $i++) {
                    echo "<li>";
                    echo("Price: €".$orders[$i]->orderedPrice);
                    echo "<br>";
                    for ($x=0; $x < count($orders[$i]->orders); $x++) {
                        foreach ($orders[$i]->orders[$x] as $key => $value) {
                            foreach ($orders[$i]->orders[$x][$key] as $key => $value) {
                                if($key != 'orderedPrice'){
                                    echo $key . ": " . $value;
                                    echo "<br>";
                                }
                            }
                        }
                    }
                    echo "</li>";
                }
            ?>
        </ul>
    @endif
@endsection
