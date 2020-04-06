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
                for ($i=0; $i < count($cart); $i++) {
                    ?>
                    <tr>
                        <td>{{$cart[$i]->productName}}</td>
                        <td>€{{$cart[$i]->amount}} * {{$cart[$i]->productPrice}} = {{$cart[$i]->productPrice * $cart[$i]->amount}}</td>
                        <td>
                            <form action='/editCart' method='post'>
                                @csrf
                                <input type='hidden' name='productName' value="{{$cart[$i]->productName}}">
                                <input type='number' name='productAmount' min="1" value="{{$cart[$i]->amount}}">
                                <button type='submit'>Edit amount</button>
                            </form>
                        </td>
                        <td>
                            <form action='/deleteFromCart' method='post'>
                                @csrf
                                <input type='hidden' name='productName' value="{{$cart[$i]->productName}}">
                                <button type='submit'>X</button>
                            </form>
                        </td>
                    </tr>
                <?php
                }
            ?>
            <tr>
                <td>
                    Totaal: €{{Session::get('cartCost')}}
                </td>
            </tr>
        @endif
    </table>
@endsection
