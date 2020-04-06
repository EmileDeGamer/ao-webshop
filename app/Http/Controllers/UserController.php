<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    function indexLogin(){
        return view('login');
    }

    function indexRegister(){
        return view('register');
    }

    public function register(Request $request){
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
            return redirect('categories');
        }
        else{
            return back()->with(['name'=>$request->input('name'), 'email'=>$request->input('email'), 'errors'=>$errors]);
        }
    }

    public function login(Request $request){

    }
}
