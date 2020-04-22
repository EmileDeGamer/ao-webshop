<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <script defer src="{{asset('js/accounts.js')}}"></script>
    </head>
    <body>
        <header>
            <ul id="left">

            </ul>
            <ul id="middle">
                <a href="/">Products</a>
            </ul>
            <ul id="right">
                @if(Session::has('user'))
                    <?php $user = Session::get('user') ?>
                    <span>{{$user['name']}}</span>
                @endif
                @if(Session::has('user'))
                    <a href="/cart" id="cart">
                        Cart
                        <ul id="cartItems">
                            @if(Session::has('cart'))
                                <?php
                                    $cart = Session::get('cart');
                                    for ($i=0; $i < count($cart->products); $i++) {
                                        echo "<li>".$cart->products[$i]->productName.":".$cart->products[$i]->amount."</li><form action='/deleteFromCart' method='post'>";?>@csrf<?php echo"<input type='hidden' name='productName' value='".$cart->products[$i]->productName."'><button type='submit'>X</button></form>";
                                    }
                                ?>
                                <?php
                                    $cart = Session::get('cart');
                                    echo "<li>Price: €".$cart->price."</li>";
                                ?>
                            @endif
                        </ul>
                    </a>
                    <a href="/logout">Logout</a>
                @endif
            </ul>
        </header>
        @yield('content')
        <footer>
            &copy; {{ now()->year }} Webshop - Emile Mol
        </footer>
    </body>
</html>
