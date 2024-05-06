<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BelanjaController extends Controller
{
    public function index(): Response
    {  
        return response()->view('belanja', [
            'title' => 'Halaman Belanja',
            'user_id_buyer' => auth()->user()->id,
            'products' => Product::where('user_id_seller', '!=', auth()->user()->id)->get()
        ]);
    }
}
