<?php

namespace App\Http\Controllers;

use App\Models\Keranjang;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class KeranjangController extends Controller
{
    public function index(): Response
    {
        $keranjangs = Keranjang::select(
                                    'keranjangs.*',
                                    DB::raw('COUNT(*) as product_count'),
                                    DB::raw('SUM(products.price) as price_total')
                                )
                                ->join('products', 'keranjangs.product_id', '=', 'products.id')
                                ->where('user_id_buyer', auth()->user()->id)
                                ->groupBy('product_id')
                                ->get();

        $totalPrice = 0;
        foreach($keranjangs as $keranjang)
        {
            if($keranjang->checked == 1) {
                $totalPrice += $keranjang->price_total; 
            }
        }

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
            $keranjangs = Keranjang::where('product_id', $request->product_id)
                                   ->where('user_id_buyer', auth()->user()->id)
                                   ->get();

            foreach($keranjangs as $keranjang)
            {
                $keranjang->delete();
            }
            

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
                $keranjangs = Keranjang::where('product_id', $request->product_id)
                                       ->where('user_id_buyer', auth()->user()->id)
                                       ->get();
                            
                foreach($keranjangs as $keranjang)
                {
                    $keranjang->checked = true;
                    $keranjang->save();
                }

                $keranjangs = Keranjang::select(
                                            'keranjangs.*',
                                            DB::raw('COUNT(*) as product_count'),
                                            DB::raw('SUM(products.price) as price_total')
                                        )
                                        ->join('products', 'keranjangs.product_id', '=', 'products.id')
                                        ->where('user_id_buyer', auth()->user()->id)
                                        ->groupBy('product_id')
                                        ->get();

                $totalPrice = 0;
                foreach($keranjangs as $keranjang)
                {
                    if($keranjang->checked == 1) {
                        $totalPrice += $keranjang->price_total; 
                    }
                }
                
                return response()->view('cheked-result', [
                    'keranjangs' => $keranjangs,
                    'totalPrice' => $totalPrice,
                ]);
            }
            else
            {
                $keranjangs = Keranjang::where('product_id', $request->product_id)
                                       ->where('user_id_buyer', auth()->user()->id)
                                       ->get();
                            
                foreach($keranjangs as $keranjang)
                {
                    $keranjang->checked = false;
                    $keranjang->save();
                }

                $keranjangs = Keranjang::select(
                                            'keranjangs.*',
                                            DB::raw('COUNT(*) as product_count'),
                                            DB::raw('SUM(products.price) as price_total')
                                        )
                                        ->join('products', 'keranjangs.product_id', '=', 'products.id')
                                        ->where('user_id_buyer', auth()->user()->id)
                                        ->groupBy('product_id')
                                        ->get();
                
                $totalPrice = 0;
                foreach($keranjangs as $keranjang)
                {
                    if($keranjang->checked == 1) {
                        $totalPrice += $keranjang->price_total; 
                    }
                }
                
                return response()->view('cheked-result', [
                    'keranjangs' => $keranjangs,
                    'totalPrice' => $totalPrice,
                ]);
            }
        }
    }
}