@extends('./layout')

@section('content')
@if(Session::has('errors'))
    <ul id="errors">
        <?php
            for ($i=0; $i < count(Session::get('errors')); $i++) {
                echo "<li>".Session::get('errors')[$i]."</li>";
            }
        ?>
    </ul>
@endif
<form action="/register" method="post">
    @csrf
<div>
    <label for="name">Name:</label>
    <input required type="text" name="name" <?php if(Session::has('name')) echo "value=".Session::get('name')?>>
</div>
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
    <label for="repeatPassword">Repeat Password:</label>
    <input required id="repeatPassword" type="password" name="repeatPassword">
    <input type="checkbox" id="showRepeatPassword">
</div>
<div>
    <button type="submit">Register</button>
</div>
</form>
@endsection
