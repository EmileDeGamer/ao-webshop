@extends('./layout')

@section('content')
<h1>
    Login
</h1>
@if(Session::has('errors'))
    <ul id="errors">
        <?php
            for ($i=0; $i < count(Session::get('errors')); $i++) {
                echo "<li>".Session::get('errors')[$i]."</li>";
            }
        ?>
    </ul>
@endif
<form action="/login" method="post">
    @csrf
<div>
    <label for="email">Email:</label>
    <input required type="text" name="email" <?php if(Session::has('email')) echo "value=".Session::get('email')?>>
</div>
<div>
    <label for="password">Password:</label>
    <input required id="password" type="password" name="password">
    <input type="checkbox" id="showPassword">
</div>
<div>
    <button type="submit">Login</button>
</div>
</form>
@endsection
