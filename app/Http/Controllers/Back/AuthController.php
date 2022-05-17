<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('back.auth.login');
    }

    public function loginPost(Request $req)
    {
       $auth = Auth::attempt(['email' => $req->email, 'password' => $req->password]);
       if($auth){
        toastr()->success('Başarıya giriş yaptınız '.Auth::user()->name);

        return redirect()->route('admin.dashboard');
       }else{
           toastr()->error('Hata','Lütfen Bilgilerinizi Kontrol Ediniz');
           return redirect()->route('admin.login')->withErrors('Girilen Bilgiler Yanlış')->withInput();
       }
    }

    public function logout(){
        Auth::logout();
        toastr()->info('Çıkış yaptınız');
        return redirect()->route('admin.login');
    }
}
