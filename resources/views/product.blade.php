<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
    </head>
    <body>
        <table>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
            </tr>
            <tr>
                <td>{{$product->productName}}</td>
                <td>{{$product->productPrice}}</td>
                <td>{{$product->productCategory}}</td>
            </tr>
        </table>
    </body>
</html>
