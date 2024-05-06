<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function index(Request $request): RedirectResponse
    {
        if($request->has('logout_submit'))
        {
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerate();

            return redirect('/login');
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Logout',
                                'error' => 'error'
                             ]);
        }
    }
}
