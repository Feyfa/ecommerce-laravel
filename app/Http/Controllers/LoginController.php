<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(): Response
    {
        return response()->view('login', [
            'title' => 'Halaman Login'
        ]);
    }

    public function auth(Request $request): RedirectResponse
    {
        if($request->has('login_submit'))
        {
            $credentials = $request->validate([
                'username' => ['required', 'min:5'],
                'password' => ['required', 'min:5']
            ]);
    
            if(Auth::attempt($credentials))
            {
                $request->session()->regenerate();
    
                return redirect()->intended('/');
            }
    
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Login Gagal',
                                'status' => 'error'
                             ]);
        }
        else 
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Login',
                                'status' => 'error'
                             ]);
        }

    }
}
