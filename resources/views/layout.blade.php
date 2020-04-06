<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
    </head>
    <body>
        <header>
            <ul id="left">

            </ul>
            <ul id="middle">

            </ul>
            <ul id="right">
                <div id="cart">
                    Cart
                    <ul id="cartItems">
                        @if(Session::has('cart'))
                            <?php
                                $cart = Session::get('cart');
                                for ($i=0; $i < count($cart); $i++) {
                                    echo "<li>".$cart[$i]->productName.":".$cart[$i]->amount."</li>";
                                }
                            ?>
                        @endif
                        @if(Session::has('cartCost'))
                            <?php
                                $cost = Session::get('cartCost');
                                echo "<li>Price:".$cost."</li>";
                            ?>
                        @endif
                    </ul>
                </div>
            </ul>
        </header>
        @yield('content')
        <footer>
            &copy; {{ now()->year }} Webshop - Emile Mol
        </footer>
    </body>
</html>
