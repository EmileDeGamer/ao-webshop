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
                @if(Session::has('customer'))
                    <?php $user = Session::get('customer') ?>
                    <span>{{$user['name']}}</span>
                @endif
                @if(Session::has('customer'))
                <a href="/cart" id="cart">
                    Cart
                    <ul id="cartItems">
                        @if(Session::has('cart') && Session::has('customer'))
                            <?php
                                $cart = Session::get('cart');
                                for ($i=0; $i < count($cart); $i++) {
                                    echo "<li>".$cart[$i]->productName.":".$cart[$i]->amount."</li><form action='/deleteFromCart' method='post'>";?>@csrf<?php echo"<input type='hidden' name='productName' value='".$cart[$i]->productName."'><button type='submit'>X</button></form>";
                                }
                            ?>
                        @endif
                        @if(Session::has('cartCost') && Session::has('customer'))
                            <?php
                                $cost = Session::get('cartCost');
                                echo "<li>Price:".$cost."</li>";
                            ?>
                        @endif
                    </ul>
                </a>
                @endif
                @if(Session::has('customer'))
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
