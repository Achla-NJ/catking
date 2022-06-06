<?php

namespace App\Http\Controllers;

use App\Mail\Mail;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Session;
use Illuminate\Support\Facades\Auth;
use App\Models\PasswordReset;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        return view('auth.register');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return RedirectResponse|void
     */
    public function signup(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'mobile_number' => 'required|min:10|numeric|unique:users',
            'password' => 'required|min:6',
            'is_catking_student'=>'required',
            'terms'=>'required'
        ]);

        if($validatedData){
            $user = new User();
            $user->name = $request->input('name') ;
            $user->avatar = 'user.png';
            $user->email = $request->input('email') ;
            $user->password = Hash::make($request->input('password')) ;
            $user->mobile_number = $request->input('mobile_number') ;
            $user->is_catking_student = $request->input('is_catking_student') ;
            $user->role = 'student' ;
            $signup = $user->save();
            if($signup){
                $details = [
                    'title' => 'New Registration',
                    'body' => $user->email.' Create New Account',
                ];

                \Mail::to('profile.catking@gmail.com')->send(new Mail($details));
                return redirect()->route('profile.account');
            }
        }
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = $request->only('email', 'password');
        $remember_me = $request->has('remember_me');
        $login= Auth::attempt($user,$remember_me);

        if($login){
            if(Auth::user()->role =="student"){
                return redirect()->route('profile.account');
            }
            else if(Auth::user()->role =="admin" || Auth::user()->role =="teacher"){
                return redirect()->route('admin.view');
            }
        }
        else{
            $msg = 'Login details are not valid';
            $request->session()->flash('error-msg',$msg);
            return redirect('login');
        }
    }

    public function signOut() {
        Session::flush();
        Auth::logout();
        return Redirect()->route('login');
    }

    public function login(){
        return view('auth.login');
    }

    public function passwordForgot(){
        return view('auth.passwords.forgot');
    }

    public function passwordReset(){
        return view('auth.passwords.reset');
    }

    public function passwordResetOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);
        $chquser = User::query()->where('email', '=', $request->post('email'))->first();
        if($chquser == null){
            $msg ='Email not registered';
            $request->session()->flash('error-msg',$msg);
            return redirect('forgot-password');
        }
       else{
            $chqotp = PasswordReset::query()->where('email', '=', $request->post('email'))->first();
            $random = rand(0000,9999);
            if($chqotp == null){
                $reset = new PasswordReset();
                $reset->email = $request->email;
                $reset->token =  $random;
                $reset->save();
            }else{
                $chqotp->token = $random;
                $chqotp->update();
            }

            $details = [
                'title' => 'OTP For Reset Password',
                'body' => 'This is your OTP '. $random,
            ];

            \Mail::to($request->email)->send(new Mail($details));

            $msg ='Mail Sent to Your Email';
            $request->session()->flash('success-msg',$msg);
            Session::put('email',$request->email);
            return redirect('reset-password');
       }
    }

    public function newPassword(Request $request)
    {

        $request->validate([
            'otp' => 'required',
            'old_password' => 'required',
            'new_password' => 'required|min:6',
        ]);
        if($request->old_password == $request->new_password){
            $check = passwordReset::query()->where(['email'=>$request->email,'token'=>$request->otp])->first();

            if($check){
                $user = User::query()->where('email',$request->email)->first();
                $user->password = Hash::make($request->new_password);
                $update = $user->update();
                if($update){
                    $msg ='Password Update Successfully';
                    $request->session()->flash('success-msg',$msg);
                    return redirect()->route('login');
                }
            }else{
                $msg ='Otp is Incorrect.';
                $request->session()->flash('error-msg',$msg);
                return redirect('reset-password');
            }
        }else{
            $msg ='password does not match with confirm password';
            $request->session()->flash('error-msg',$msg);
            return redirect('reset-password');
        }
    }
}
