<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(): Response
    {   
        return response()->view('register', [
            'title' => 'Halaman Register'
        ]);
    }   

    public function store(Request $request): RedirectResponse
    {
        if($request->has('register_submit'))
        {
            $validated = $request->validate([
                'name' => ['required'],
                'username' => ['required', 'min:5'],
                'password' => ['required', 'min:5']
            ]);
            $validated['password'] = Hash::make($validated['password']);
    
            User::create($validated);
    
            return redirect('/login')->with('flash', [
                'message' => 'Register Berhasil',
                'status' => 'success'
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'status' => 'Submit Bukan Dari Register',
                                'status' => 'error'
                             ]);
        }
    }
}
