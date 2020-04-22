<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\CartController;

class UserController extends Controller
{
    /*public function createNewUser(Request $request){
        $user = new User($request);
        $cart = $user->getCart($request);
        $userData = $user->getUser($request);
        return view('index', ['user'=>$userData, 'cart'=>$cart]);
    }*/

    public function loginUser(Request $request){
        $errors = [];
        $user = \DB::table('users')->select('name', 'email', 'password')->where('email' , '=', $request->input('email'))->first();
        if(!$user){
            array_push($errors, 'User doesn\'t exist');
            return back()->with(['email'=>$request->input('email'), 'errors'=>$errors]);
        }
        else{
            if(\Hash::check($request->input('password'), $user->password)){
                $request->session()->put('user', ['name'=>$user->name]);
                $cartController = new CartController();
                CartController::getOrders($request);
                return redirect('/');
            }
            else{
                array_push($errors, 'Wrong password');
                return back()->with(['email'=>$request->input('email'), 'errors'=>$errors]);
            }
        }
    }

    public function registerUser(Request $request){
        $errors = [];
        if (!preg_match("/^[a-zA-Z\s\-]{3,255}$/", $request->input('name'))) {
            array_push($errors, 'Wrong usage of name (no numbers allowed)');
        }
        if (!filter_var( $request->input('email'), FILTER_VALIDATE_EMAIL)) {
            array_push($errors, 'Wrong usage of email (no spaces allowed)');
        }
        if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $request->input('password'))) {
            array_push($errors, 'Wrong usage of password (1 uppercase, 1 lowercase, 1 number and min length 8)');
        }
        if( $request->input('password') !==  $request->input('repeatPassword')){
            array_push($errors, 'Passwords are not the same');
        }
        if(count($errors) === 0){
            $hash = \Hash::make($request->input('password'));
            \DB::table('users')->insert(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'password'=>$hash]);
            $request->session()->put('user', ['name'=>$request->input('name')]);
            CartController::getOrders($request);
            return redirect('/');
        }
        else{
            return back()->with(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'errors'=>$errors]);
        }
    }

    public function logoutUser(Request $request){
        $request->session()->forget('user');
        $request->session()->forget('cart');
        $request->session()->forget('orders');
        return redirect('login');
    }
}
