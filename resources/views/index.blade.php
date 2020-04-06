<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        @if(Session::has('cart'))
            <?php
                $cart = Session::get('cart');
                for ($i=0; $i < count($cart); $i++) {
                    foreach ($cart[$i] as $key => $value) {
                        echo $key . " " . $value;
                    }
                }
            ?>
        @endif
    </body>
</html>
