<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class KeranjangController extends Controller
{
    public function index(): Response
    {
        $keranjangs = Keranjang::where('user_id_buyer', auth()->user()->id)
                               ->latest()
                               ->get();

        $totalPrice =  Product::whereHas('Keranjang', function ($query) {
            return $query->where('checked', true);
        })->pluck('price')
          ->sum();

        // dd(
        //     $keranjangs,
        //     $keranjangs[0]->product
        // );

        return response()->view('keranjang', [
            'title' => 'Halaman Keranjang',
            'keranjangs' => $keranjangs,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        if($request->has('keranjang_submit'))
        {
            $validate = $request->validate([
                'product_id' => ['required', 'integer', 'min:0'],
                'user_id_buyer' => ['required', 'integer', 'min:0']
            ]);

            Keranjang::create($validate);

            return redirect('/belanja')->with('flash', [
                'message' => 'Belanja Berhasil Dimasukan Ke Keranjang',
                'status' => 'success'
            ]);
        }
        else
        {
            return redirect()->back()
                             ->with('flash', [
                'message' => 'Submit Bukan Dari Keranjang',
                'status' => 'error'
            ]);
        }
    }

    public function delete(Request $request): RedirectResponse
    {
       if($request->has('delete_keranjang_submit'))
       {
            Keranjang::where('id', $request->input('id'))
                     ->delete();

            return redirect('/keranjang')->with('flash', [
                'message' => 'Barang Di Keranjang Berhasil Di Hapus',
                'status' => 'success'
            ]);
       }
       else
       {
            return redirect()->back()
                             ->with('flash', [
                                'message' => 'Submit Bukan Dari Keranjang',
                                'status' => 'error'
                            ]);
       }
    }

    public function checked(Request $request)
    {
        if($request->ajax())
        {
            // saat checked di tangkap $request->input('checked') 
            // maka tipe datanya string bukan boolean
            if($request->input('checked') === 'true')
            {
                Keranjang::where('id', $request->id)
                         ->update(['checked' => true]);

                $totalPrice =  Product::whereHas('keranjang', function ($query) {
                    return $query->where('checked', true);
                })->pluck('price')
                  ->sum();
                
                return response()->view('cheked-result', [
                    'keranjangs' => Keranjang::latest()->get(),
                    'totalPrice' => $totalPrice,
                ]);
            }
            else
            {
                Keranjang::where('id', $request->id)
                         ->update(['checked' => false]);

                $totalPrice =  Product::whereHas('keranjang', function ($query) {
                    return $query->where('checked', true);
                })->pluck('price')
                  ->sum();
                
                return response()->view('cheked-result', [
                    'keranjangs' => Keranjang::latest()->get(),
                    'totalPrice' => $totalPrice,
                ]);
            }
        }
    }
}