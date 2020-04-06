@extends('./layout')

@section('content')
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
            <td>
                <form action="/addToCart" method="post">
                    @csrf
                    <input type="hidden" name="productName" value="{{$product->productName}}">
                    <input type="number" name="productAmount" min="1" value="1">
                    <button type="submit">Add To Cart</button>
                </form>
            </td>
        </tr>
    </table>
@endsection
